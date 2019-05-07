<?php

class  db{
    private $dbhost = 'localhost';
    private $user= 'root';
    private $password = 'root';
    private $dbname = 'dbname';

    public function connecti()
    {
        $mysqlconnect = 'mysql:host=localhost;dbname=dbname';
        $dbConnection = new PDO($mysqlconnect,'root', 'root');
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}

?>
