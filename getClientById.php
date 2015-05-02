<?php
include "./BddConnexion.php";
include "./fonctions.php";

try {
    //Si $_POST['identifiant'] n'est pas renseigné, on lève une exception
    if(!isset($_POST['identifiant']))
    {
        throw new Exception ("Aucun identifiant reçu !");
    }//fin if
    
    //On récupère l'identifiant du client
    $idClient = $_POST['identifiant'];
    
    //On établit la connexion
    $connexion = getConnexion();
    
    //On retourne le résultat de l'encodage en JSON du résultat
    print(getClientById($connexion, $idClient));
} catch (Exception $ex) {
    print "Erreur : ".$ex->getMessage();
}//fin catch
?>