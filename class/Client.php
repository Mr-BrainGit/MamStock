<?php

class Client
{
    private $nomClient;
    private $prenomClient;
    private $emailClient;
    private $telClient;
    private $adresseClient;
    private $nomStructClient;

    public function __construct($nomClient, $prenomClient, $emailClient, $telClient, $adresseClient, $nomStructClient)
    {
        $this->setNomClient($nomClient);
        $this->setPrenomClient($prenomClient);
        $this->setEmailClient($emailClient);
        $this->setTelClient($telClient);
        $this->setAdresseClient($adresseClient);
        $this->setNomStrutClient($nomStructClient);
    }

    public function setNomClient(string $nomClient)
    {
        $this->nomClient = $nomClient;
    }

    public function getNomClient()
    {
        return $this->nomClient;
    }

    public function setPrenomClient(string $prenomClient)
    {
        $this->prenomClient = $prenomClient;
    }

    public function getPrenomClient()
    {
        return $this->prenomClient;
    }

    public function setEmailClient(string $emailClient)
    {
        $this->emailClient = $emailClient;
    }

    public function getEmailClient()
    {
        return $this->emailClient;
    }

    public function setTelClient(string $telClient)
    {
        $this->telClient = $telClient;
    }

    public function getTelClient()
    {
        return $this->telClient;
    }

    public function setAdresseClient(string $adresseClient)
    {
        $this->adresseClient = $adresseClient;
    }

    public function getAdresseClient()
    {
        return $this->adresseClient;
    }

    public function setNomStrutClient(string $nomStructClient)
    {
        $this->nomStructClient = $nomStructClient;
    }

    public function getNomStructClient()
    {
        return $this->nomStructClient;
    }

    public static function getAll()
    {
        include 'db-connect.php';
        $requete = $bdd->prepare("SELECT * FROM clients");
        $requete->execute();
        return $requete->fetchAll();
    }

    /**Méthode pour ajouter un client */
    public static function create(Client $client)
    {
        include 'db-connect.php';
        $email = $client->getEmailClient();

        $requete = $bdd->prepare("SELECT * FROM clients WHERE emailClient = '$email'");
        $requete->execute();
        $emails = $requete->fetchAll();


        if (count($emails) === 0) {
            $pdoStat = $bdd->prepare('INSERT INTO clients VALUES (:idClient, :nomClient, :prenomClient, :emailClient, :telClient, :adresseClient, :nomStructClient)');
            $pdoStat->bindValue(':idClient', NULL);
            $pdoStat->bindValue(':nomClient', $client->getNomClient(), PDO::PARAM_STR);
            $pdoStat->bindValue(':prenomClient', $client->getPrenomClient(), PDO::PARAM_STR);
            $pdoStat->bindValue(':telClient', $client->getTelClient(), PDO::PARAM_STR);
            $pdoStat->bindValue(':adresseClient', $client->getAdresseClient(), PDO::PARAM_STR);
            $pdoStat->bindValue(':emailClient', $client->getEmailClient(), PDO::PARAM_STR);
            $pdoStat->bindValue(':nomStructClient', $client->getNomStructClient(), PDO::PARAM_STR);

            $insertOK = $pdoStat->execute();


            if ($insertOK) {
                echo "";
            } else {
                echo "Ajout echoué";
            }
        } else {
            $response = "Le client a été déja créé";
            return $response;
        }
    }

    /**Méthode pour supprimer un client */
    public static function delete($idClient)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("DELETE FROM clients WHERE idClient = $idClient");
        $requete->execute();
    }

    //**Méthode pour faire la mise a jour d'un client */
    public static function update(Client $client, $id)
    {
        include 'db-connect.php';

        $nom = $client->getNomClient();
        $prenom = $client->getPrenomClient();
        $tel = $client->getTelClient();
        $adresse = $client->getAdresseClient();
        $email = $client->getEmailClient();
        $struct = $client->getNomStructClient();


        $sql = "UPDATE clients SET
                nomClient = '$nom',
                prenomClient = '$prenom',
                emailClient = '$email',
                telClient = '$tel',
                adresseClient = '$adresse',
                nomStructClient = '$struct'
                WHERE idClient = $id";

        // Prepare statement
        $stmt = $bdd->prepare($sql);

        // execute the query
        $retour = $stmt->execute();

        if ($retour) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function findByCode($idClient)
    {
        include 'db-connect.php';

        $requete = $bdd->prepare("SELECT * FROM clients WHERE idClient = $idClient");
        $requete->execute();
        return $requete->fetchAll();
    }
}
