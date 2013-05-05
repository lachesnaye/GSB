var lesModifications="";
//window.onbeforeunload = alert("fin");
function changeVisit()
{
    //alert(document.getElementById('idVisit').value);
    // on va soumettre le formulaire que si on a sélectionné un cours (l'indice 0 de la liste n'est pas sélectionné)
    if(document.getElementById('idVisit').selectedIndex!=0)
    {
        document.getElementById('idFrmSelection').submit();
        
    }
    else
    {
        
        /* 
         * si l'élément sélectionné dans la liste est le premier (choisir un cours) on va supprimer 
         * la div . On aurait pu la cacher, mais on aurait pris le risque de laisser des infos visibles depuis firebug
         * (inspecter élément)
         * pour la supprimer, on récupére son parent et on supprime la supprime à partir de ce parent (voir DOM)
         */
        div=document.getElementById('IdDivEnreg');
        parent=div.parentNode;
        parent.removeChild(div);
       
        
    }
}

function changeMois()
{
    //alert(document.getElementById('idVisit').value);
    // on va soumettre le formulaire que si on a sélectionné un cours (l'indice 0 de la liste n'est pas sélectionné)
    if(document.getElementById('idMois').selectedIndex!=0)
    {
        document.getElementById('idFrmSelection').submit();
        
    }
    else
    {
        
        /* 
         * si l'élément sélectionné dans la liste est le premier (choisir un cours) on va supprimer 
         * la div . On aurait pu la cacher, mais on aurait pris le risque de laisser des infos visibles depuis firebug
         * (inspecter élément)
         * pour la supprimer, on récupére son parent et on supprime la supprime à partir de ce parent (voir DOM)
         */
        div=document.getElementById('IdDivEnreg');
        parent=div.parentNode;
        parent.removeChild(div);
       
        
    }
}

function modifLigneHF(idLigneHF) {
    //document.location.replace('http://' +location.hostname + location.pathname + '?etape=validerModifLigneHF&idLigneHF=' + document.getElementById('idLigneHF').value +'&dateLigneHF='+ document.getElementById('dateLigneHF').value +'&libelleLigneHF='+ document.getElementById('libelleLigneHF').value +'&montantLigneHF='+ document.getElementById('montantLigneHF').value );
    document.location.replace('http://' +location.hostname + location.pathname + '?etape=validerModifLigneHF&idLigneHF=' + idLigneHF +'&dateLigneHF='+ document.getElementById('dateLigneHF' + idLigneHF + '').value +'&libelleLigneHF='+document.getElementById('libelleLigneHF' + idLigneHF + '').value +'&montantLigneHF='+ document.getElementById('montantLigneHF' + idLigneHF + '').value );
	

}

