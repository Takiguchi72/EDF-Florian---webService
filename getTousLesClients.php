<?php
include "./BddConnexion.php";
include "./fonctions.php";

try {
    //On établit la connexion
    $connexion = getConnexion();

    //On récupère tous les clients de la bdd et on retourne le résultat de l'encodage en JSON du résultat
    print(getTousLesClients($connexion));
} catch (Exception $ex) {
    print "Erreur :<br />".$ex->getMessage();
    //die();
}//fin catch
?>