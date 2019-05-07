<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

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
    $contact = $request->getParam('contact');
//   $date = $request->getParam('');
    $category = $request->getParam('category');
    $adname = $request->getParam('adname');
    $adtext = $request->getParam('adtext');
    $region = $request->getParam('region');

    $sql = "insert into tab (
userpassword, username, contact, datetime, category, adname, adtext, region) 
values (:userpassword,:username, :contact, now(), :category, :adname,:adtext,:region);";


    try{
        $db = new db();
        $db = $db->connecti();
        $stmnt = $db->prepare($sql);
        $stmnt -> bindParam(':userpassword', $userpassword);
        $stmnt -> bindParam(':username', $username);
        $stmnt -> bindParam(':contact', $contact);
        $stmnt -> bindParam(':category', $category);
        $stmnt -> bindParam(':adname', $adname);
        $stmnt -> bindParam(':adtext', $adtext);
        $stmnt -> bindParam(':region', $region);

        $stmnt->execute();
        echo "ok";

        $stmnt = $db->prepare("delete from tab where datetime <= (now() - interval 50 day);");
        $stmnt->execute();

    } catch (PDOException $e){
        echo "error";
    }


});


$app->get('/mix1', function (\Slim\Http\Request $request, \Slim\Http\Response $response) {

    $category = $request->getParam('category');
    $region = $request->getParam('region');



    $sql = "select * from tab where category = '$category' or region='$region'";


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

    $category = $request->getParam('category');
    $region = $request->getParam('region');



    $sql = "select * from tab where category = '$category' and region='$region'";


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