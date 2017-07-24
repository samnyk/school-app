<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->get('/', function (Request $request, Response $response) {
    $file = 'home.html';
    return $response->write(file_get_contents($file));
});


$app->post('/login', function (Request $request, Response $response) {
    $connection = new Connection();
    $conn = $connection->connect();
    $data = array('session'=>false,'user'=>null);
    $datas = $request->getParsedBody();
    $user_email = $datas['email'];
    $user_password = $datas['password'];



    $user_email = mysqli_real_escape_string($conn,$user_email);
    $user_password= mysqli_real_escape_string($conn,$user_password);


    $query = "SELECT * FROM administrator WHERE email ='{$user_email}' AND password = '{$user_password}'LIMIT 1";

    $result = mysqli_query($conn,$query);
    $user = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0){
        session_start();
        $_SESSION['user'] = $user;
        $data['session'] = true;
        $data['user'] = $user;

        return $response->write(json_encode($data));

    }else{
        return $response->write('MySql error');

    }

    mysqli_close($conn);


});

$app->post('/logout', function (Request $request, Response $response) {
    session_start();
    unset($_SESSION['user']);
    session_destroy();
});

$app->get('/checksession', function (Request $request, Response $response) {
    session_start();

    if(!$_SESSION['user']) {
        $data = array('session'=>false,'user'=>null);
        $response->write(json_encode($data));
    }else{
        $data = array('session'=>true,'user'=>$_SESSION['user']);
        $response->write(json_encode($data));
    }
});