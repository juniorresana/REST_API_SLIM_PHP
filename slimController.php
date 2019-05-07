<?php
namespace App\apiController;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use PDO;

final class apiController{
    private $db;
    public function __construct($host, $dbname, $user, $password){
        try {

            $this->db = new PDO("mysql:host=" . $host . ";dbname=" . $dbname, $user, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    public function getDb() {
        if ($this->db instanceof PDO) {
            return $this->db;
        }
    }
}