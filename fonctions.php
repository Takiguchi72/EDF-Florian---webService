<?php
/**
 * Retourne le client dans la bdd correspondant à l'identifiant passé en paramètres sous forme de chaîne encodée en JSON /!\ Succeptible de soulever une exception
 * @param PDO::Connection La variable contenant la connexion à la bdd
 * @param String L'identifiant du client à récupérer dans la bdd
 * @return String La chaîne encodée en JSON contenant les données du client récupéré
 * @throws Exception
 */
function getClientById($connexion, $identifiant)
{
    //On prépare la requête
    $req = $connexion->prepare("SELECT * FROM \"webServiceEdf\".client WHERE identifiant=:idCli ;");
    
    //On renseigne les paramètres de la requête préparée
    $req->bindParam(':idCli', $identifiant);
    
    //On exécute la requête
    $r = $req->execute();
    
    //Si l'exécution de la requête retourne FALSE, on lève une exception car la requête ne s'est pas exécutée normalement
    if(!$r)
    {
        throw new Exception("Impossible de récupérer le client : ".$identifiant. " - ".$req->queryString);
    }//fin if
    
    //On récupère le client parmit le tableau retourné par postgreSQL
    if($ligne = $req->fetch())
    {
        $resultat = $ligne;
    }//fin if
    else
    {
        throw new Exception("Auncun client ne correspond à l'identifiant \"".$identifiant."\" !");
    }//fin else
    
    //On ferme le curseur
    $req->closeCursor();
    
    //On retourne le resultat encodé en JSON
    return json_encode($resultat);
}//fin getClientById

/**
 * Retourne la liste des clients de la bdd sous forme de chaîne encodée en JSON /!\ Succeptible de soulever une exception
 * @param PDO::Connection La variable contenant la connexion à la bdd
 * @return String La chaîne encodée en JSON contenant les données de tous les clients récupérés
 * @throws Exception
 */
function getTousLesClients($connexion)
{
    //On prépare la requête qui retournera tous les clients de la bdd
    $req = $connexion->prepare("SELECT * FROM \"webServiceEdf\".client ;");
    
    //On exécute la requête
    $r = $req->execute();
    
    //Si l'exécution de la requête retourne FALSE, on lève une exception car la requête ne s'est pas exécutée normalement
    if(!$r)
    {
        throw new Exception("Impossible de récupérer les clients");
    }//fin if
    
    //Pour chaque tuple, on va le stoquer dans $resultat
    while($ligne = $req->fetchObject())
    {
        //On va ajouter une nouvelle ligne au tableau $arrResultat avec $ligne <=> array_push($arrResultat, $ligne);
        $arrResultat[] = $ligne;
    }//fin while
    
    //On ferme le curseur
    $req->closeCursor();
    
    //On retourne le résultat encodé en JSON
    return json_encode($arrResultat);
}//fin getTousLesClients

/**
 * Modifie le client correspondant à la chaîne JSON passée en paramètres et le retourne sous forme de chaîne encodée en JSON
 * @param PDO::Connection La variable contenant la connexion à la bdd
 * @param JSONObject L'objet JSON correspondant au client à modifier
 * @throws Exception
 */
function setClient($connexion, $jsonClient)
{
    //On prépare la requête
    $req = $connexion->prepare("UPDATE \"webServiceEdf\".client set "
                                . "nom=:nom, prenom=:prenom, adresse=:adresse, cp=:cp, "
                                . "ville=:ville, tel=:tel, idcompteur=:idcompteur, "
                                . "dateancienreleve=:dateancienreleve, ancienreleve=:ancienreleve,"
                                . "datedernierreleve=:datedernierreleve, dernierreleve=:dernierreleve, "
                                . "signaturebase64=:signaturebase64, situation=:situation "
                                . "WHERE identifiant=:identifiant ;");
    
    //On renseigne les paramètres de la requête préparée
    $req->bindParam(':nom', $jsonClient->{'nom'});
    $req->bindParam(':prenom', $jsonClient->{'prenom'});
    $req->bindParam(':adresse', $jsonClient->{'adresse'});
    $req->bindParam(':cp', $jsonClient->{'cp'});
    $req->bindParam(':ville', $jsonClient->{'ville'});
    $req->bindParam(':tel', $jsonClient->{'tel'});
    $req->bindParam(':idcompteur', $jsonClient->{'idcompteur'});
    $req->bindParam(':dateancienreleve', $jsonClient->{'dateancienreleve'});
    $req->bindParam(':ancienreleve', $jsonClient->{'ancienreleve'});
    $req->bindParam(':datedernierreleve', $jsonClient->{'datedernierreleve'});
    $req->bindParam(':dernierreleve', $jsonClient->{'dernierreleve'});
    $req->bindParam(':signaturebase64', $jsonClient->{'signaturebase64'});
    $req->bindParam(':situation', $jsonClient->{'situation'});
    $req->bindParam(':identifiant', $jsonClient->{'identifiant'});
    
    //On exécute la requête
    $r = $req->execute();
    
    //Si l'exécution de la requête retourne FALSE, on lève une exception car la requête ne s'est pas exécutée normalement
    if(!$r)
    {
        throw new Exception("Impossible de modifier le client : ".$jsonClient->{'identifiant'}. " - ".$req->queryString);
    }//fin if
    
    //On récupère le client modifié en base de données et on le retourne sous forme de chaîne encodée en JSON
    return getClientById($connexion, $jsonClient->{'identifiant'});
}//fin setClient