<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



$app->get('/getcourses', function (Request $request, Response $response) {
    session_start();
    if (!$_SESSION['user']) {
        $data = array('session' => false, 'user' => null);
        $response->write(json_encode($data));
    } else {
        $db_handle= new mysqltodb();
        $result= $db_handle->getAll('course',false);
        return $response->write(json_encode($result));
    }
});

$app->post('/addcourses', function (Request $request, Response $response) {
    $sent_data = $request->getParsedBody();

    session_start();
    if (!$_SESSION['user']) {
        $data = array('session' => false, 'user' => null);
        $response->write(json_encode($data));
    } else {
        $db_handle= new mysqltodb();


        $name = $sent_data['name'];
        $desc = $sent_data['desc'];
        $img = $sent_data['image'];
        $rows = array('name','description','image');
        $info = array($name,$desc,$img);
        $details=array($rows,$info);
        $result= $db_handle->addToTable('course',$details);

        $response->write(json_encode($result));


    }
});

$app->post('/deletecourse', function (Request $request, Response $response) {
    $sent_data = $request->getParsedBody();
    $id = $sent_data['id'];
    session_start();
    if (!$_SESSION['user']) {
        $data = array('session' => false, 'user' => null);
        $response->write(json_encode($data));
    } else {
        $db_handle= new mysqltodb();
        $result= $db_handle->deleteFrom('course',$id);
        $response->write(json_encode($result));

    }


});


$app->post('/countcourses', function (Request $request, Response $response) {
    $sent_data = $request->getParsedBody();
    $id = $sent_data['id'];
    session_start();
    if (!$_SESSION['user']) {
        $data = array('session' => false, 'user' => null);
        $response->write(json_encode($data));
    } else {
        $db_handle= new mysqltodb();
        $result= $db_handle->countCourses($id);
        $response->write(json_encode($result));

    }


});


$app->post('/editcourse', function (Request $request, Response $response) {
    $sent_data = $request->getParsedBody();
    $course_id = $sent_data['id'];
    $user_data_to_update = $sent_data['newData'];
    session_start();
    if (!$_SESSION['user']) {
        $data = array('session' => false, 'user' => null);
        $response->write(json_encode($data));
    } else {
        $db_handle= new mysqltodb();

        $desc = $user_data_to_update['desc'];
        $name = $user_data_to_update['name'];
        $img = $user_data_to_update['image'];
        $rows = array('name','description','image','id');
        $info = array($name,$desc,$img,$course_id);
        $details=array($rows,$info);
        
        $result= $db_handle->editTable('course',$details);
        $response->write(json_encode(array($result)));

    }


});