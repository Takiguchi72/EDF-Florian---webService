<?php
include "./BddConnexion.php";
include "./fonctions.php";

try {
    //Si $_POST['chaineJSON'] n'est pas renseignée, on lève une exception
    if(!isset($_POST['chaineJSON']))
    {
        throw new Exception("Aucune donnée n'a été reçue !");
    }//fin if
    
    //On récupère les données du client passées par $_POST
    $jsonClient = json_decode($_POST['chaineJSON']);
    
    //On établit la connexion
    $connexion = getConnexion();
    
    //On modifie et on affiche le client modifié
    print(setClient($connexion, $jsonClient));
} catch (Exception $ex) {
    print "Erreur : ".$ex->getMessage();
}//fin catch