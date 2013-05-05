<?php
$repInclude = 'include/';
require($repInclude . "_init.inc.php");

/**
 * On verifie si un utilisateur est bien conn�ct�, s'il ne l'est pas la page inaccessible
 */
if (!estVisiteurConnecte()) {
    header("Location: cSeConnecter.php");
}

require($repInclude . "_entete.inc.html");
require($repInclude . "_sommaireComptable.inc.php");
?>
<style>
    #contenu h2 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-weight: bold;
        color: #980101;
        text-decoration: none;
        border : 1px solid #980101;
        padding-left: 25px;
        background-color: rgb(238,136,68);
        height : 28px;
    }
    /* Styles pour les tableaux de la page principale */
    #contenu table {
        background-color:white;
        border : 0.1em solid #980101;
        color:#980101;
        margin-right : auto ;
        margin-left:0.3em;
        border-collapse : collapse;
    }
    /* Style pour les lignes d'en-t�te des tableaux */
    #contenu th {  
        background-color:rgb(238,136,68);
        height:21px;
        text-align:left;
        vertical-align:top;
        font-weight:bold;
        border-bottom:0.1em solid #980101;
        font-size:1.1em;
        color:#980101;
    }
    #contenu td {
        border :1px solid #980101;
    }
</style>
<!-- Division principale -->
<div id="contenu">
    <h2>Suivi de paiement</h2>
    <?php
    $idUser = obtenirIdUserConnecte();
    /**
     * Requete qui va r�cuperer toutes les fiches de frais dont l'�tat est VA (valid�)
     * S'il n'y en a pas alors un message apparait � l'�cran
     * S'il la requete renvoie une ou plusieurs ligne alors un tableau va �tre cr��
     */
    $req = mysql_query("SELECT idVisiteur, mois, nbJustificatifs, montantValide, dateModif, idEtat, nom 
                        FROM fichefrais INNER JOIN visiteur ON fichefrais.idVisiteur=visiteur.id
                        WHERE idEtat = 'VA'");
    if (mysql_num_rows($req) == false) {
        echo "Il n'y a pas de fiche VALIDER � rembourser !";
    } else {
        /**
         * Tableau affichant les fiches de frais de la base de donn�es
         */
        ?>
        <table>
            <tr>
                <th>id Visiteur</th>
                <th>Nom</th>
                <th>Mois</th>
                <th>Nombre justificatifs</th>
                <th>Montant</th>
                <th>Date modification</th>
                <th>Valider</th>
            </tr>
            <?php
            while ($ligne = mysql_fetch_assoc($req)) {
                /**
                 * $id identifiant du visiteur
                 * $nom nom du visiteur
                 * $noMois mois de la fiche de frais
                 * $annee ann�e de la fiche de frais
                 * $nbJustificatifs nombre de justificatifs pour la fiche de frais
                 * $montant montant totale de la fiche de frais (forfait et hors forfait)
                 * $dateModif date a laquelle la fiche a �t� valid�
                 */
                $id = $ligne['idVisiteur'];
                $nom = $ligne['nom'];
                $mois = $ligne['mois'];
                $noMois = intval(substr($mois, 4, 2));
                $annee = intval(substr($mois, 0, 4));
                $nbJustificatifs = $ligne['nbJustificatifs'];
                $montant = $ligne['montantValide'];
                if ($montant == "") {
                    $montant = "null";
                }
                $dateModif = $ligne['dateModif'];
                ?>		
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $nom; ?></td>
                    <td><?php echo obtenirLibelleMois($noMois) . " " . $annee; ?></td>
                    <td><?php echo $nbJustificatifs; ?></td>
                    <td><?php echo $montant; ?></td>
                    <td><?php echo $dateModif; ?></td>
                    <td><a href='cValiderPaiementFicheFrais.php?id=<?php echo $id; ?>
                           &mois=<?php echo $mois; ?>'>Valider</a></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>
<?php
require($repInclude . "_pied.inc.html");
require($repInclude . "_fin.inc.php");
?>