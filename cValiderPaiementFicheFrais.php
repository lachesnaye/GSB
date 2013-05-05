<?php
$repInclude = 'include/';
require($repInclude . "_init.inc.php");

// page inaccessible si visiteur non connect�
if (!estVisiteurConnecte()) {
    header("Location: cSeConnecter.php");
}

require($repInclude . "_entete.inc.html");
require($repInclude . "_sommaireComptable.inc.php");
?>
<!-- Division principale -->
<div id="contenu">
    <h2>Validation de remboursement</h2>
    <?php
    /**
     * Variables pour les deux requ�tes
     */
    $id = $_GET['id'];
    $mois = $_GET['mois'];
    $update = date("Y-m-d");
/**
 * Ici on passe de l'�tat VA(Valid�) � l'�tat CL(Clotur�)
 * Et de l'�tat CL � l'�tat RB(Rembours�)
 */
    $req1 = "UPDATE fichefrais set idEtat = 'MP', dateModif = '$update' WHERE idVisiteur = '$id' AND mois = '$mois'";
    mysql_query($req1);
    $req2 = "UPDATE fichefrais set idEtat = 'RB', dateModif = '$update' WHERE idVisiteur = '$id' AND mois = '$mois'";
    mysql_query($req2);
    ?>
    La fiche a &eacute;t&eacute; mise &agrave; jour.	
</div>
<?php
require($repInclude . "_pied.inc.html");
require($repInclude . "_fin.inc.php");
?>