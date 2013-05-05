<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php 
                        $result=mysql_query("select DISTINCT nom,id from visiteur, fichefrais WHERE visiteur.id = fichefrais.idVisiteur");
                        while($data=mysql_fetch_array($result))
                        {?>                           
                        <option id="<?php echo $data['id'];?>"value="-1"> Choisir un visiteur</option>
                        
                            
                        <?php } ?>
                        </select>
                        <?php
                        mysql_close();
                        ?>

                        
                        
                        
                        
                        
                        
                        
                        
                        
          <?php              function date_fr($format, $timestamp=false) {
	    if  ( !$timestamp ) $date_en = date($format);
	    else               $date_en = date($format,$timestamp);
	 
	    $texte_en = array("January","February", "March", "April", "May","June", "July", "August", "September","October", "November", "December");
	    $texte_fr = array("Janvier","F&eacute;vrier", "Mars", "Avril", "Mai","Juin", "Juillet", "Ao&ucirc;t", "Septembre","Octobre", "Novembre", "D&eacute;cembre");
	    $date_fr = str_replace($texte_en, $texte_fr, $date_en);
            return $date_fr;}
            
            ?>

                        
                        
                        
                        
                        
                        
                                                <label class="titre">Mois :</label> <br> 
                            <select name="Date">
                        <option  selected="selected" ><?php echo date_fr("F");?> </option> 
                         <option ><?php echo date_fr("F")-1;?> </option>
                            </select>
                        <?php echo date_fr("Y");?>
                        
                       
		<p class="titre" />
                
                
		<div style="clear:left;"><h2>Frais au forfait </h2></div>
		
                <?php 
                
                //$sql="select quantite from lignefraisforfait where idVisiteur='a131' and idFraisForfait='REP' and mois = '201210' ";
                
                //$requete1=mysql_query($sql);
                //$requete1=mysql_query("select 2");
                ?> 
                <table style="color:black;" border="1">
                    <tr><th>Repas midi</th><th>Nuit&eacute;e </th><th>Etape</th><th>Km </th><th>Situation</th></tr>
			<tr align="center">
                                <td width="80"><input type="text" size="3" name="repas" value="<?php //echo $data['REP']; ?>" /></td>
				<td width="80"><input type="text" size="3" name="nuitee" /></td> 
				<td width="80"><input type="text" size="3" name="etape" /></td>
				<td width="80"><input type="text" size="3" name="km" /></td>
				<td width="80"> 
					<select size="3" name="situ">
                                            <option value="E">Enregistr&eacute;</option>
                                            <option value="V">Valid&eacute;</option>
                                            <option value="R">Rembours&eacute;</option>
					</select></td>
				</tr>
		</table>
		
		<p class="titre" /><div style="clear:left;"><h2>Hors Forfait</h2></div>
		<table style="color:black;" border="1">
			<tr><th>Date</th><th>Libell&eacute; </th><th>Montant</th><th>Situation</th></tr>
			<tr align="center"><td width="100" ><input type="text" size="12" name="hfDate1"/></td>
				<td width="220"><input type="text" size="30" name="hfLib1"/></td> 
				<td width="90"> <input type="text" size="10" name="hfMont1"/></td>
				<td width="80"> 
					<select size="3" name="hfSitu1">
                                            <option value="E">Enregistr&eacute;</option>
						<option value="V">Valid&eacute;</option>
                                                <option value="R">Rembours&eacute;</option>
					</select></td>
				</tr>
		</table>		
		<p class="titre"></p>
		<div class="titre">Nb Justificatifs</div><input type="text" class="zone" size="4" name="hcMontant"/>		
		<p class="titre" /><label class="titre">&nbsp;</label><input class="zone"type="reset" /><input class="zone"type="submit" />
	</form>
                        </div>
        
        
        
        
        
        
        
        
        
        
            <label  class="titre" >Choisir le mois :</label>
                    <select name="lstMois" id="idMois" onchange="changeMois();">
                        <option value="-1" hidden="hidden"> Choisir un mois</option>
                        
                         <?php
                         
                            $result2=mysql_query("select distinct mois,idVisiteur from visiteur, lignefraisforfait where id.visiteur = idVisiteur.lignefraisforfait ");
                        while($data2=mysql_fetch_array($result2)) {
                        if (isset($_POST["lstMois"]) && $_POST["lstMois"] == $data2[1]) {
                            // on teste ici si le cours qu'on rajoute à la liste est celui qui avait été sélectionné
                            // et qui est stocké dans $_POST. Si oui, on le sélectionne, c'est lui qui sera affiché dans la liste 
                            echo "<option value='" . $data2[1] . "' selected='selected' >" . $data2[0] . "</option>";
                        } else {
                            echo "<option value='" . $data2[1] . "'>" . $data2[0] . "</option>";
                        }
                        }    
        