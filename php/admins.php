<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;




$app->get('/getadmins', function (Request $request, Response $response) {
    session_start();
    if (!$_SESSION['user']) {
        $data = array('session' => false, 'user' => null);
        $response->write(json_encode($data));
    } else {
        $db_handle= new mysqltodb();

        if ($_SESSION['user']['role'] == 'owner') {
            $result= $db_handle->getAll('administrator',false);
            return $response->write(json_encode($result));
        } else {
            $where = array('WHERE role <> ','owner');
            $result= $db_handle->getAll('administrator',$where);
            return $response->write(json_encode($result));
        }

    }
});


$app->post('/editadmin', function (Request $request, Response $response) {
    $sent_data = $request->getParsedBody();
    $user_id = $sent_data['id'];
    $user_data_to_update = $sent_data['newData'];
    session_start();
    if (!$_SESSION['user']) {
        $data = array('session' => false, 'user' => null);
        $response->write(json_encode($data));
    } else {

        $db_handle= new mysqltodb();

        $email = $user_data_to_update['email'];
        $role = $user_data_to_update['role'];
        $phone = $user_data_to_update['phone'];
        $name = $user_data_to_update['name'];
        $img = $user_data_to_update['image'];
        $pwd = $user_data_to_update['password'];
        $email_check=$db_handle->checkEmail('administrator',$email);

        if ($email_check== 'exists'){
            $response->write(json_encode(array('error')));
        }else{
            $rows = array('name','phone','role','email','image','password','id');
            $info = array($name,$phone,$role,$email,$img,$pwd,$user_id);
            $details=array($rows,$info);

            $result= $db_handle->editTable('administrator',$details);
            $response->write($result);
        }


    }


});


$app->post('/deleteuser', function (Request $request, Response $response) {
    $sent_data = $request->getParsedBody();
    $id = $sent_data['id'];
    session_start();
    if (!$_SESSION['user']) {
        $data = array('session' => false, 'user' => null);
        $response->write(json_encode($data));
    } else {
        $db_handle= new mysqltodb();
        $result= $db_handle->deleteFrom('administrator',$id);
        $response->write(json_encode($result));

    }


});


$app->post('/addadmin', function (Request $request, Response $response) {
    $sent_data = $request->getParsedBody();
    $user_data_to_update = $sent_data;
    session_start();
    if (!$_SESSION['user']) {
        $data = array('session' => false, 'user' => null);
        $response->write(json_encode($data));
    } else {
        $db_handle= new mysqltodb();


        $email = $user_data_to_update['email'];
        $role = $user_data_to_update['role'];
        $phone = $user_data_to_update['phone'];
        $name = $user_data_to_update['name'];
        $img = $user_data_to_update['image'];
        $pwd = $user_data_to_update['password'];
        $email_check=$db_handle->checkEmail('administrator',$email);

        if ($email_check== 'exists'){
            $response->write(json_encode(array('error')));
        }else{
            $rows = array('name','phone','role','email','image','password');
            $info = array($name,$phone,$role,$email,$img,$pwd);
            $details=array($rows,$info);
            $result= $db_handle->addToTable('administrator',$details);

            $response->write(json_encode($result));
        }



    }


});

