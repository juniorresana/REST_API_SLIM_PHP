<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//composer created instance

require 'vendor/autoload.php';
require 'db.php';

$app = new \Slim\App;

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/user/{username}', function (Request $request, Response $response, array $args) {

    $username = $args['username'];
    $sqlq = "SELECT * FROM tab where username = '$username'";
    try {

        $db = new db();
        $com = $db->connecti();

        $stmnttt = $com->query($sqlq);
        $names = $stmnttt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo json_encode($names);

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
});

$app->get('/all', function (Request $request, Response $response, array $args) {

    $sqlq = "SELECT * FROM tab";
    try {

        $db = new db();
        $com = $db->connecti();

        $stmnttt = $com->query($sqlq);
        $names = $stmnttt->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        echo json_encode($names);

    } catch (PDOException $e) {
        echo "error";
    }
});

$app->get('/delete/{id}', function (Request $request, Response $response, array $args) {

    $id = $args['id'];
    $sqlq = "delete FROM tab where id = $id";
    try {

        $db = new db();
        $db = $db->connecti();
        $com = $db->prepare($sqlq);
        $com->execute();

        $db = null;

        echo "ok";


    } catch (PDOException $e) {
        echo "error";
    }
});

$app->get('/add', function (\Slim\Http\Request $request, \Slim\Http\Response $response) {
    $userpassword = $request->getParam('userp');
    $username = $request->getParam('username');

    $sql = "insert into tab (
userp, username, datetime) 
values (:userp,:username, now());";


    try{
        $db = new db();
        $db = $db->connecti();
        $stmnt = $db->prepare($sql);
        $stmnt -> bindParam(':userp', $userp);
        $stmnt -> bindParam(':username', $username);
        
        $stmnt->execute();
        echo "ok";

        $stmnt = $db->prepare("delete from tab where datetime <= (now() - interval 1 day);");
        $stmnt->execute();

    } catch (PDOException $e){
        echo "error";
    }


});


$app->get('/mix1', function (\Slim\Http\Request $request, \Slim\Http\Response $response) {

    $param1 = $request->getParam('param1');
    $param2 = $request->getParam('param2');

    $sql = "select * from tab where p1 = '$param1' or p2='$param2'";


    try{
        $db = new db();
        $com = $db->connecti();

        $stmnttt = $com->query($sql);
        $names = $stmnttt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($names);

    } catch (PDOException $e){
        echo "error";
    }
});

$app->get('/mix2', function (\Slim\Http\Request $request, \Slim\Http\Response $response) {

    $p1 = $request->getParam('param1');
    $p2 = $request->getParam('param2');



    $sql = "select * from tab where p1 = '$param1' and p2='$param2'";


    try{
        $db = new db();
        $com = $db->connecti();

        $stmnttt = $com->query($sql);
        $names = $stmnttt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($names);

    } catch (PDOException $e){
        echo "error";
    }
});

$app->run();
