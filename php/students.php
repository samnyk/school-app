<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;




$app->get('/getstudents', function (Request $request, Response $response) {
    session_start();
    if (!$_SESSION['user']) {
        $data = array('session' => false, 'user' => null);
        $response->write(json_encode($data));
    } else {
        $db_handle= new mysqltodb();
            $result= $db_handle->getAll('student',false);
            return $response->write(json_encode($result));

    }
});


$app->post('/addstudents', function (Request $request, Response $response) {
    $sent_data = $request->getParsedBody();

    session_start();
    if (!$_SESSION['user']) {
        $data = array('session' => false, 'user' => null);
        $response->write(json_encode($data));
    } else {
        $db_handle= new mysqltodb();
        $email = $sent_data['email'];

        $phone = $sent_data['phone'];
        $name = $sent_data['name'];
        $img = $sent_data['image'];
        $rows = array('name','phone','email','image');
        $info = array($name,$phone,$email,$img);
        $details=array($rows,$info);
        if (!$sent_data['courseId']==0){
            $course_id=array_keys($sent_data['courseId']);
            foreach ($course_id as $id){
                $row = array('student','course');
                $column =array($email,(string)$id);
                $student_course_details= array($row,$column);
                $student_course_result = $db_handle->addToTable('studentcourse',$student_course_details);
            }
        }

        $email_check=$db_handle->checkEmail('student',$email);
        if ($email_check== 'exists'){
            $response->write(json_encode(array('error')));
        }else{
            $user_result= $db_handle->addToTable('student',$details);
            $response->write('done');
        }




    }
});


$app->post('/deletestudent', function (Request $request, Response $response) {
    $sent_data = $request->getParsedBody();
    $id = $sent_data['id'];
    $mail = $sent_data['mail'];
    session_start();
    if (!$_SESSION['user']) {
        $data = array('session' => false, 'user' => null);
        $response->write(json_encode($data));
    } else {
        $db_handle= new mysqltodb();
        $student_course_delete = $db_handle->deleteAll('studentcourse',$mail);
        $result= $db_handle->deleteFrom('student',$id);
        $response->write(json_encode($result));

    }


});
$app->post('/editstudent', function (Request $request, Response $response) {
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
        $phone = $user_data_to_update['phone'];
        $name = $user_data_to_update['name'];
        $img = $user_data_to_update['image'];
        $old_mail = $user_data_to_update['oldmail'];
        $email_check=$db_handle->checkEmail('student',$email);

        if ($email_check== 'exists'){
            $response->write(json_encode(array('error')));
        }else{
            $rows = array('name','phone','email','image','id');
            $info = array($name,$phone,$email,$img,$user_id);
            $details=array($rows,$info);
            $student_course_delete = $db_handle->deleteAll('studentcourse',$old_mail);
            if (array_keys($user_data_to_update['courseId'])>0){
                $course_id=array_keys($user_data_to_update['courseId']);
                foreach ($course_id as $id){
                    $row = array('student','course');
                    $column =array($email,(string)$id);
                    $student_course_details= array($row,$column);
                    $student_course_result = $db_handle->addToTable('studentcourse',$student_course_details);
                }
            }

            $result= $db_handle->editTable('student',$details);
            $response->write(json_encode(array($result,$student_course_result,$student_course_delete)));
        }


    }


});


$app->post('/getcoursesforstudent', function (Request $request, Response $response) {
    $sent_data = $request->getParsedBody();
    $id = $sent_data['email'];
    session_start();
    if (!$_SESSION['user']) {
        $data = array('session' => false, 'user' => null);
        $response->write(json_encode($data));
    } else {
        $db_handle= new mysqltodb();
        $where = array('WHERE student =',$id);
        $result= $db_handle->getCourseList('studentcourse',$where);

        $response->write(json_encode($result));

    }
});