<?php


error_reporting(E_ALL);
ini_set('diplay_error',1);

class User{

    // user property
    private $clientId;
    private $name;
    private $email;
    private $profileImg;

    private $connection;
    private $table = 'users';

    function __construct($db){
        $this->connection = $db;
    }

    function createUser($params){
        try {
            $this->clientId = $params['clientId'];
            $this->name = $params['name'];
            $this->email = $params['email'];
            $this->profileImg = $params['profileImg'];

            $query = 'INSERT INTO '.$this->table.'
                    SET
                    clientId = :clientId,
                    name = :name,
                    email = :email,
                    profileImg = :profileImg';
            
            $user = $this->connection->prepare($query);
            $user->bindValue('clientId',$this->clientId);
            $user->bindValue('name',$this->name);
            $user->bindValue('email',$this->email);
            $user->bindValue('profileImg',$this->profileImg);
            
            if($user->execute()) {
                return true;
            }
            return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

}