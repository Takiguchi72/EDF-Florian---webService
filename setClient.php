<?php
include "./BddConnexion.php";
include "./fonctions.php";

try {
    //Si $_POST['chaineJSON'] n'est pas renseignée, on lève une exception
    if(!isset($_POST['ancienReleve']) || !isset($_POST['dateAncienReleve']) || !isset($_POST['situation']) || !isset($_POST['signatureBase64']))
    {
        throw new Exception("Certaines données n'ont pas été reçues !");
    }//fin if
        
    //On récupère les données du client passées par $_POST
    $arrValeurs = array($_POST['identifiant'], $_POST['ancienReleve'], $_POST['dateAncienReleve'], $_POST['situation'], $_POST['signatureBase64']);
    
    $file = fopen("./log", "a");
    fputs($file, $arrValeurs);
    fclose($file);
    
    //On établit la connexion
    $connexion = getConnexion();
    
    //On modifie et on affiche le client modifié
    print(setClient($connexion, $arrValeurs));
} catch (Exception $ex) {
    print "Erreur : ".$ex->getMessage();
}//fin catch