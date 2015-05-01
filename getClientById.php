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
    
    /*On prépare la requête
    $req = $connexion->prepare("SELECT * FROM \"webServiceEdf\".client WHERE identifiant=:idCli ;");
    
    //On renseigne les paramètres de la requête préparée
    $req->bindParam(':idCli', $idClient);
    
    //On exécute la requête
    $r = $req->execute();
    
    //Si l'exécution de la requête retourne FALSE, on lève une exception car la requête ne s'est pas exécutée normalement
    if(!$r)
    {
        throw new Exception("Impossible de récupérer le client : ".$idClient. " - ".$req->queryString);
    }//fin if
    
    //On récupère le client parmit le tableau retourné par postgreSQL
    if($ligne = $req->fetch())
    {
        $resultat = $ligne;
    }//fin if
    else
    {
        throw new Exception("Auncun client ne correspond à l'identifiant \"".$idClient."\" !");
    }//fin else */
    
    
    //On retourne le résultat de l'encodage en JSON du résultat
    //print(json_encode($resultat));
    print(getClientById($connexion, $idClient));
} catch (Exception $ex) {
    print "Erreur : ".$ex->getMessage();
}//fin catch
?>