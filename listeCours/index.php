<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Cours</title>
        <script type="text/javascript" src="JavaScript/index.js"></script>
        <link  href="css/index.css" rel="stylesheet" type="text/css" media="screen"/>
    </head>
    <?php
    include('/include/define.inc.php');
    try {
//        $connect_str = "mysql:host=localhost;";
//        $connect_user = "benoit";
//        $connect_pass = "benoit";
//        $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $connect_str = "mysql:dbname=" . BASE . ";host=" . SERVEUR . ";";
        $connect_user = USER;
        $connect_pass = PWD;
        $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $dbmysql = new PDO($connect_str, $connect_user, $connect_pass, $options);
    } catch (Exception $e) {
        throw new Exception("Erreur à la connexion \n" . $e->getMessage());
    }
    ?>
    <body>

        <form name="frmselection" id="idFrmSelection" action="index.php" method="post">
            <fieldset id="FieldBases" class="cFieldBases">
                <legend>S&eacute;lection du cours</legend>
                <label for="idcours">Choisir une base de données </label> 
                <select name="nCours" id="idCours" onchange="changeCours();"> 
                    <option value='-1'> Choisir un cours </option>
                    <?php
                    /*
                      remplissage de la liste. 'idée est de stocker le code dans l'attribut value et de visualiser
                     * le libellé. Plus facile pour le choix.
                     * On récupérera dans la $_POST la valeur du code sélectionné.
                     */

                    $sql = "select codecours, libellecours from cours";
                    $resultat = $dbmysql->query($sql);
                    //print_r($resultat);
                    foreach ($resultat as $unCours) {
                        if (isset($_POST["nCours"]) && $_POST["nCours"] == $unCours[0]) {
                            // on teste ici si le cours qu'on rajoute à la liste est celui qui avait été sélectionné
                            // et qui est stocké dans $_POST. Si oui, on le sélectionne, c'est lui qui sera affiché dans la liste 
                            echo "<option value='" . $unCours[0] . "' selected='selected' >" . $unCours[1] . "</option>";
                        } else {
                            echo "<option value='" . $unCours[0] . "'>" . $unCours[1] . "</option>";
                        }
                    }
                    ?>
                </select>
            </fieldset>



            <?php
            /*
             * On va tester ici si le formulaire a été posté, et si l'élément sélectionné de la liste n'est pas la première entrée
             * que l'on a positionnée à -1 (choisir un cours)
             * Ainsi, si on a un cours sélectionné, on va aller chercher les séminaires du cours.
             */
            if (isset($_POST["nCours"]) && $_POST["nCours"] != -1) {
                $_SESSION['cours'] = $_REQUEST['nCours'];
                ?>

                <div id="IdDivEnreg" class="cDivEnreg">
                    <fieldset>
                        <legend>Séminaire du cours <?php echo $_SESSION['cours']; ?>  </legend>

                        <?php
                        $sql = "select codesemi , datedebutsem, DATE_ADD(datedebutsem, INTERVAL nbjours DAY) as datefin 
                                from cours inner join seminaire on cours.codecours=seminaire.codecours 
                                where cours.codecours = :pCodeCours";
                        $resultat = $dbmysql->prepare($sql);
                        $resultat->bindValue(':pCodeCours', $_SESSION['cours'], PDO::PARAM_STR);
                        $tableauResultat = $resultat->execute();
                        // on va tester si il y a au moins un séminaire pour le cours sélectionné (voir MCD)
                        if ($resultat->rowCount() == 0) {
                            echo "le cours " . $_SESSION['cours'] . " ne prévoit aucun séminaire";
                        } else {
                            ?>
                            <table border="1">
                                <thead>                        
                                    <tr>
                                        <?php
                                        $LesSeminaires = $resultat->fetchAll(PDO::FETCH_ASSOC);
                                        /*
                                         * On récupère dans un tableau associatif les enregistrements récupérés par la requête
                                         * le premier foreach sert à construire l'entête du tableau .
                                         * Ainsi, si on rajoute un champ dans la requête, on n'aura pas besoin de toucher le code HTML pour l'afficher
                                         * essayez en rajoutant le nbjour à la requête.
                                         */
                                        foreach ($LesSeminaires[0] as $cle => $valeur) {
                                            echo "<th>" . $cle . "</th>";
                                        }
                                        ?>
                                    </tr> 
                                </thead> 
                                <tbody>
                                    <?php
                                    // on parcourt le tableau pour afficher les valeurs.
                                    foreach ($LesSeminaires as $unSeminaire) {
                                        echo "<tr>";
                                        foreach ($unSeminaire as $valeur) {
                                            echo "<td> " . $valeur . "</td>";
                                        }
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        }
                    }
                    ?>
                </fieldset>
            </div>
        </form>
    </body>
</html>




</select>
                             <label  class="titre" >Choisir le mois :</label>
                    <select name="lstMois" id="idMois" onchange="changeMois();">
                        <option value="-1" hidden="hidden"> Choisir un mois</option>
                        
                         <?php
                         
                            $result2=mysql_query("select distinct mois,idVisiteur from visiteur, lignefraisforfait where id.visiteur = idVisiteur.lignefraisforfait ");
                            $data2=mysql_fetch_array($result2); 
                        if (isset($_POST["lstMois"]) && $_POST["lstMois"] == $data2[1]) {
                            // on teste ici si le cours qu'on rajoute à la liste est celui qui avait été sélectionné
                            // et qui est stocké dans $_POST. Si oui, on le sélectionne, c'est lui qui sera affiché dans la liste 
                            echo "<option value='" . $data2[1] . "' selected='selected' >" . $data2[0] . "</option>";
                        } else {
                            echo "<option value='" . $data2[1] . "'>" . $data2[0] . "</option>";
                        
                        }   ?> 
                    </select>