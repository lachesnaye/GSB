<?php

/**
 * Script de contrôle et d'affichage du cas d'utilisation "Valider fiche de frais"
 * @package default
 * @todo  RAS
 */
$repInclude = './include/';
require($repInclude . "_init.inc.php");

if (!estVisiteurConnecte()) {
    header("Location: cSeConnecter.php");
}


require($repInclude . "_entete.inc.html");
require($repInclude . "_sommaireComptable.inc.php");

$idVisit = lireDonnee("lstVisit", "");
$idMois = lireDonnee("lstMois", "");

$etape = lireDonnee("etape", "demanderSaisie");
$idLigneHF = lireDonnee("idLigneHF", "");
$dateLigneHF = lireDonnee("dateLigneHF", "");
$libelleLigneHF = lireDonnee("libelleLigneHF", "");
$montantLigneHF = lireDonnee("montantLigneHF", "");

if (isset($_GET['action'])) {
    if ($_GET['action'] == "refusHF") {
      $date = $_GET['date'];
      $idVisiteur = $_GET['idVisiteur'];
      $libelle = $_GET['libelle'];
      $ligneHf=$_GET['idLigneHF'];

      if(!preg_match("#REFUSE#", $libelle))       {       $libelle = "REFUSE : ".$libelle;
                                                          modifierLibelleHorsForfait($ligneHf,$date, $idVisiteur, $libelle);
                                                  }

      header("Location: ./formValidFrais.php");
    }
}

if ($etape == "validerSuppressionLigneHF") {
    supprimerLigneHF($idConnexion, $idLigneHF);
} else if ($etape == "validerModifLigneHF") {
    modifierLigneHF($idConnexion, $idLigneHF, $dateLigneHF, $libelleLigneHF, $montantLigneHF);
}
else if ($etape == "validerFiche") {
    modifierEtatFicheFrais($idConnexion, $_GET["idMois"],$_GET["idVisit"],"VA");
}


?>

<html>
    <head>
        <title>Validation des frais de visite</title>
        <style type="text/css">
            /*body {background-color: EE8855; color:EE8855; } 
            .titre { width : 180 ;  clear:left; float:left; } 
            .zone { float : left; color:CC8855 }*/
        </style>
    </head>
    <body>


        <div id ="contenu">

            <div name="gauche" style="clear:left; float:leftwidth 18%; background-color:white; height:100">
                <div name="coin" style="height:10%;text-align:center;"></div>
                <div name="menu" >



                </div>
            </div>
            <div name="droite" style="float:left;width:80%;">
                <div name="haut" style="margin: 2 2 2 2 ;height:10%;float:left;"><h1>Validation des Frais</h1></div>	
                <div name="bas" style="margin : 10 650 250 2;clear:left;background-color:EE8844;color:black;height:88%;">

                    <form id="idFrmSelection" name="formValidFrais" method="post" action="">
                        <h1> Validation des frais par visiteur </h1>
                        <label  class="titre" >Choisir le visiteur :</label>
                        <select name="lstVisit" id="idVisit" onchange="changeVisit();">
                            <option value="-1" hidden="hidden"> Choisir un visiteur</option>

                            <?php
                            $jeuVisit = mysql_query("select distinct nom,id from visiteur inner join  fichefrais on visiteur.id = fichefrais.idVisiteur ");
                            while ($lgVisit = mysql_fetch_array($jeuVisit)) {
                                if ($idVisit == $lgVisit['id']) {
                                    // on teste ici si le cours qu'on rajoute à la liste est celui qui avait été sélectionné
                                    // et qui est stocké dans $_POST. Si oui, on le sélectionne, c'est lui qui sera affiché dans la liste 
                                    echo "<option value='" . $lgVisit['id'] . "' selected='selected' >" . $lgVisit['nom'] . "</option>";
                                } else {
                                    echo "<option value='" . $lgVisit['id'] . "'>" . $lgVisit['nom'] . "</option>";
                                }
                            }
                            ?> 

                        </select>

                        <?php
                        if ($idVisit) {
                            ?>
                            <div id="IdDivEnreg" class="cDivEnreg">    
                                <label  class="titre" >Choisir le mois :</label>
                                <select name="lstMois" id="idMois" onchange="changeMois();">
                                    <option value="-1" hidden="hidden"> Choisir un mois </option>

                                    <?php
                                    $jeuMois = mysql_query("SELECT distinct mois FROM lignefraisforfait where idVisiteur = '" . $idVisit . "';   ");

                                    while ($lgMois = mysql_fetch_array($jeuMois)) {

                                        $moisChiffre = intval(substr($lgMois['mois'], 4, 2));
                                        $moisLettre = obtenirLibelleMois($moisChiffre);
                                        $annee = intval(substr($lgMois['mois'], 0, 4));

                                        if ($idMois == $lgMois['mois']) {

                                            echo "<option value='" . $lgMois['mois'] . "' selected='selected' >" . $moisLettre . " " . $annee . "</option>";
                                        } else {
                                            echo "<option value='" . $lgMois['mois'] . "'>" . $moisLettre . " " . $annee . "</option>";
                                        }
                                    }
                                    ?>


                                </select>
                            </div> 
                            <?php
                        }




                        if ($idVisit && $idMois) {
                            ?>    

                            <p class="titre" >


                            <div style="clear:left;"><h2>Frais au forfait </h2></div>


                            <table style="color:black;" border="1">
                                <tr><th>Etape</th><th>Km </th><th>Nuitee</th><th>Repas </th></tr>
                                <tr align="center">
                                    <?php
                                    $jeuIdFraisForfait = mysql_query("select idFraisForfait from lignefraisforfait where mois = '" . $idMois . "' and idVisiteur = '" . $idVisit . "' ;");

                                    while ($i = mysql_fetch_array($jeuIdFraisForfait)) {

                                        $jeuQuant = mysql_query("select quantite from lignefraisforfait where idVisiteur = '" . $idVisit . "' and mois ='" . $idMois . "' and idFraisForfait = '" . $i['idFraisForfait'] . "' ");
                                        $lgQuant = mysql_fetch_array($jeuQuant);


                                        switch ($i['idFraisForfait']) {
                                            case "ETP":
                                                ?><td width="80"><input type="text" size="3" name="etape" value="<?php echo $lgQuant['quantite']; ?>" ></td><?php
                                break;

                            case "KM":
                                                ?><td width="80"><input type="text" size="3" name="km" value="<?php echo $lgQuant['quantite']; ?>" ></td><?php
                                break;

                            case "NUI":
                                                ?><td width="80"><input type="text" size="3" name="nuitee" value="<?php echo $lgQuant['quantite']; ?>" ></td><?php
                                    break;

                                case "REP":
                                                ?><td width="80"><input type="text" size="3" name="repas" value="<?php echo $lgQuant['quantite']; ?>" ></td><?php
                                    break;
                            }
                        }
                                    ?>





                                </tr>
                            </table>

                            <p class="titre" /><div style="clear:left;"><h2>Hors Forfait</h2></div>
                            <table class="listeLegere">
                                <caption>Descriptif des éléments hors forfait 
                                </caption>
                                <tr>
                                    <th class="date">Date</th>
                                    <th class="libelle">Libellé</th>
                                    <th class="montant">Montant</th> 
                                    <th class="supprimer">Supprimer</th>
				    <th class="modifier">Modifier<th>
                                </tr>
                                <?php
                                // demande de la requête pour obtenir la liste des éléments hors
                                // forfait du visiteur connecté pour le mois demandé
                                $req = obtenirReqEltsHorsForfaitFicheFrais($idMois, $idVisit);
                                $idJeuEltsHorsForfait = mysql_query($req, $idConnexion);
                                $lgEltHorsForfait = mysql_fetch_assoc($idJeuEltsHorsForfait);

                                // parcours des éléments hors forfait 
                                while (is_array($lgEltHorsForfait)) {
                                    ?>
                                    <tr>
                                        <input id="idLigneHF" type="hidden" name="id" value="<?php echo $lgEltHorsForfait["id"]; ?>" >
                                        <td width="80"><input id="dateLigneHF<?php echo $lgEltHorsForfait["id"]; ?>" type="text" size="" name="date" value="<?php echo $lgEltHorsForfait["date"]; ?>" ></td>
                                        <td width="80"><input id="libelleLigneHF<?php echo $lgEltHorsForfait["id"]; ?>" type="text" size="" name="libelle" value="<?php echo filtrerChainePourNavig($lgEltHorsForfait["libelle"]); ?>" ></td>
                                        <td width="80"><input id="montantLigneHF<?php echo $lgEltHorsForfait["id"]; ?>" type="text" size="" name="montant" value="<?php echo $lgEltHorsForfait["montant"]; ?>" ></td>

                                        <td><a href="formValidFrais.php?action=refusHF&date=<?php echo $lgEltHorsForfait["date"] ?>&idVisiteur=<?php echo $idVisit; ?>&libelle=<?php echo $lgEltHorsForfait["libelle"]; ?>&idLigneHF=<?php echo $lgEltHorsForfait["id"]; ?>"
                                               onclick="return confirm('Voulez-vous vraiment refuser cette ligne de frais hors forfait ?');"
                                               title="Refuser la ligne de frais hors forfait">Refuser</a><br /></td>
                                               
                                        <td><a onclick="modifLigneHF(<?php echo $lgEltHorsForfait["id"]; ?>);"
                                               title="Modifier la ligne de frais hors forfait">Modifier</a></td>
                                               
                                    </tr>
                                    <?php
                                    $lgEltHorsForfait = mysql_fetch_assoc($idJeuEltsHorsForfait);
                                }
                                mysql_free_result($idJeuEltsHorsForfait);
                                ?>
                            </table>
                            <p class="titre"></p>
                            <div class="titre">Nb Justificatifs</div><input type="text" class="zone" size="4" name="hcMontant"/>		
                            <p class="titre" /><label class="titre">&nbsp;</label>
                            <a  href="?etape=validerFiche&amp;idVisit=<?php echo $idVisit; ?>&idMois=<?php echo $idMois; ?>">Valider la fiche de frais</a>
                            <?php
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>

    </body>






    <?php
    require($repInclude . "_pied.inc.html");
    ?>
    <script type="text/javascript" src="JavaScript/index.js"></script>
    <?php
    require($repInclude . "_fin.inc.php");
    ?>
</html>