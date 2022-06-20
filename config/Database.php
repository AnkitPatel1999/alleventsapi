<?php 


class Database{
    //db properties
    private $host = 'localhost';
    private $db_name = 'alleventsoop';
    private $username = 'root';
    private $password = '123456';
    private $connection;


    public function connect() {
        $this->connection = null;

        try {
            $this->connection = new PDO(
                'mysql:host='.$this->host.';
                dbname='.$this->db_name,
                $this->username,
                $this->password
            );
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $this->connection;



    }






}


?>