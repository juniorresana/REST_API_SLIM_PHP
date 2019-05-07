<?php

class  db{
    private $dbhost = 'localhost';
    private $user= 'root';
    private $password = '0000';
    private $dbname = 'slim';

    public function connecti()
    {
        $mysqlconnect = 'mysql:host=localhost;dbname=slim';
        $dbConnection = new PDO($mysqlconnect,'root', '0000');
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;

//        $conna = new mysqli('localhost', 'root', '0000','slim') or die("Connect failed: %s\n". $conn -> error);

    }
}

?>
