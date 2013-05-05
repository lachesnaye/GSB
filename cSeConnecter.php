<?php  
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Se connecter"
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  require($repInclude . "_init.inc.php");
  
  // est-on au 1er appel du programme ou non ?
  $etape=(count($_POST)!=0)?'validerConnexion' : 'demanderConnexion';
  
  if ($etape=='validerConnexion') { // un client demande à s'authentifier
      // acquisition des données envoyées, ici login, mot de passe et statut
      $login = lireDonneePost("txtLogin");
      $mdp = lireDonneePost("txtMdp");
      //$mdp = substr(sha1($mdp), 20, 20);
      //$statut = lireDonneePost("connect");
      $lgUserVisiteur = verifierInfosConnexionVisiteur($idConnexion, $login, sha1($mdp)) ;
      $lgUserComptable = verifierInfosConnexionComptable($idConnexion, $login, sha1($mdp)) ;
      // si l'id utilisateur a été trouvé, donc informations fournies sous forme de tableau 
      if(isset($_POST['connect']) && $_POST['connect'] == "visit") {
      if ( is_array($lgUserVisiteur) ) { 
          affecterInfosConnecte($lgUserVisiteur["id"], $lgUserVisiteur["login"]);
          header("location: cAccueil.php");
      }
      else {
          ajouterErreur($tabErreurs, "Pseudo et/ou mot de passe incorrects");
          
      }
      }
      if (isset($_POST['connect']) && $_POST['connect'] == "compta") {
      if ( is_array($lgUserComptable) ) { 
      affecterInfosConnecte($lgUserComptable["id"], $lgUserComptable["login"]);
      header("location: formValidFrais.php");  
      require($repInclude . "_sommaire.inc.php");
      }
      else {
          ajouterErreur($tabErreurs, "Pseudo et/ou mot de passe incorrects");
      }
      }
  
      
    
        
    
       
    
  }

  require($repInclude . "_entete.inc.html");
 
  
?>
<!-- Division pour le contenu principal -->
    <div id="contenu">
      <h2>Identification utilisateur</h2>
<?php
          if ( $etape == "validerConnexion" ) 
          {
              if ( nbErreurs($tabErreurs) > 0 ) 
              {
                echo toStringErreurs($tabErreurs);
              }
          }
?>               
      <form id="frmConnexion" action="" method="post" name="formulaire">
      <div class="corpsForm">
        <input type="hidden" name="etape" id="etape" value="validerConnexion" />
        
      <p>
        <label for="txtLogin" accesskey="n">* Login : </label>
        <input type="text" id="txtLogin" name="txtLogin" maxlength="20" size="15" value="bobdylan" title="Entrez votre login" />
      </p>
      
      <p>
        <label for="txtMdp" accesskey="m">* Mot de passe : </label>
        <input type="password" id="txtMdp" name="txtMdp" maxlength="8" size="15" value="password"  title="Entrez votre mot de passe"/>
      </p>
      
        <input type="radio" name="connect" value="visit" id="visiteur" >Visiteur
        <input type="radio" name="connect" value="compta" id="comptable"checked="checked">Comptable
        
      </div>  
      <div class="piedForm">
      <p>
        <input type="submit" id="ok" value="Valider" />
        <input type="reset" id="annuler" value="Effacer" />
      </p> 
      </div>
      </form>
    </div>
<?php
    require($repInclude . "_pied.inc.html");
    require($repInclude . "_fin.inc.php");
?>