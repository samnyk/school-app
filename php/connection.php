<?php


class Connection{
    private $servername;
    private $username;
    private $password;
    private $dbname;


    public function connect(){
        $this->servername="localhost";
        $this->username="root";
        $this->password="";
        $this->dbname="school";

        $conn = mysqli_connect($this->servername, $this->username, $this->password ,$this->dbname);

        return $conn;
    }
}

