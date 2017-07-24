<?php


class mysqltodb extends Connection {


    public function checkEmail($table,$mail){
        $sql ="SELECT * FROM $table WHERE email ='$mail'";
        $result = mysqli_query($this->connect(),$sql);
        if ($result->num_rows > 0){
            return 'exists';
        }else{
            return 'not exists';
        }
    }

    public function deleteAll($tableName,$id){
        $sql="DELETE FROM ".$tableName." WHERE student ='$id'";
        $result = mysqli_query($this->connect(),$sql);
        if ($result){
            return 'success';
        }else{
            return 'failed';
        }
    }
    public function countCourses($course){
        $sql ="SELECT * FROM studentcourse WHERE course=$course";
        $result = mysqli_query($this->connect(),$sql);
       return $result->num_rows;
    }


    public function getCourseList($var,$where){
        $sql ="SELECT * FROM " .$var." ". $where[0] .' "'.$where[1].'"';
        $result = mysqli_query($this->connect(),$sql);
        $num_rows = $result->num_rows;
        if ($num_rows>0){
            $result_array = array();
            while ($row = mysqli_fetch_all($result)) {
                $result_array = $row;
            }
            if (mysqli_num_rows($result) > 0) {
                $newArray = array();
                foreach ($result_array as $rslt){
                    $where = array('WHERE id =',$rslt[1]);
                    $itm = $this->getAll('course',$where);

                    array_push($newArray,$itm);

                }
                return $newArray;
            } else {
                return 'MySql error';
            }
        }else{
            return array('error');
        }
    }

    public function getAll($var,$where){
        if ($where){
            $sql ="SELECT * FROM " .$var." ". $where[0] .' "'.$where[1].'"';
            $result = mysqli_query($this->connect(),$sql);
            $numrows = $result->num_rows;
            if ($numrows>0){
                $result_array = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $result_array[] = $row;
                }
                if (mysqli_num_rows($result) > 0) {
                    return $result_array;
                } else {
                    return 'MySql error';
                }
            }else{
                return array('error');
            }
        }else{
            $sql ="SELECT * FROM ".$var;
            $result = mysqli_query($this->connect(),$sql);
            $numrows = $result->num_rows;
            if ($numrows>0){
                $result_array = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $result_array[] = $row;
                }
                if (mysqli_num_rows($result) > 0) {
                    return $result_array;
                } else {
                    return 'MySql error';
                }
            }else{
                return array('error');
            }
        }

    }

    public function addToTable($tableName,$updateDetails){
        if ($tableName=='administrator'){
            $sql = "INSERT INTO ".$tableName." "."({$updateDetails[0][0]},{$updateDetails[0][1]},{$updateDetails[0][2]},{$updateDetails[0][3]},{$updateDetails[0][4]},{$updateDetails[0][5]}) VALUES (".' "'.$updateDetails[1][0].'"'.",".' "'.$updateDetails[1][1].'"'.",".' "'.$updateDetails[1][2].'"'.",".' "'.$updateDetails[1][3].'"'.",".' "'.$updateDetails[1][4].'"'.",".' "'.$updateDetails[1][5].'"'.")";
            $result = mysqli_query($this->connect(),$sql);
            if ($result){
                return 'success';
            }else{
                return 'failed';
            }
        }elseif ($tableName=='student'){
            $sql ="INSERT INTO ".$tableName." "."({$updateDetails[0][0]},{$updateDetails[0][1]},{$updateDetails[0][2]},{$updateDetails[0][3]}) VALUES (".' "'.$updateDetails[1][0].'"'.",".' "'.$updateDetails[1][1].'"'.",".' "'.$updateDetails[1][2].'"'.",".' "'.$updateDetails[1][3].'"'.")";
            $result = mysqli_query($this->connect(),$sql);
            if ($result){
                return 'success';
            }else{
                return 'failed';
            }
        }else if ($tableName=='course'){
            $sql ="INSERT INTO ".$tableName." "."({$updateDetails[0][0]},{$updateDetails[0][1]},{$updateDetails[0][2]}) VALUES (".' "'.$updateDetails[1][0].'"'.",".' "'.$updateDetails[1][1].'"'.",".' "'.$updateDetails[1][2].'"'.")";
            $result = mysqli_query($this->connect(),$sql);
            if ($result){
                return 'success';
            }else{
                return 'failed';
            }
        }else if ($tableName=='studentcourse'){
            $sql ="INSERT INTO ".$tableName." "."({$updateDetails[0][0]},{$updateDetails[0][1]}) VALUES (".' "'.$updateDetails[1][0].'"'.",".' "'.$updateDetails[1][1].'"'.")";
            $result = mysqli_query($this->connect(),$sql);
            if ($result){
                return 'success';
            }else{
                return 'failed';
            }
        }

    }

    public function deleteFrom($tableName,$deleteDetails){
        $sql = "DELETE FROM ". $tableName." "." WHERE id='{$deleteDetails}'";
        $result = mysqli_query($this->connect(),$sql);
        if ($result){
            return 'success';
        }else{
            return 'failed';
        }
    }


    public function editTable($tableName,$updateDetails){

        if($tableName=='administrator'){
            $name = "{$updateDetails[0][0]}=".'"'.$updateDetails[1][0].'"'.",";
            $phone= "{$updateDetails[0][1]}=".'"'.$updateDetails[1][1].'"'.",";
            $role = "{$updateDetails[0][2]}=".'"'.$updateDetails[1][2].'"'.",";
            $email = "{$updateDetails[0][3]}=".'"'.$updateDetails[1][3].'"'.",";
            $image = "{$updateDetails[0][4]}=".'"'.$updateDetails[1][4].'"'.",";
            $pass = "{$updateDetails[0][5]}=".'"'.$updateDetails[1][5].'"';
            $id = "{$updateDetails[0][6]}=".'"'.$updateDetails[1][6].'"';

            $sql = "UPDATE ".$tableName." "."SET ".$name.$phone.$role.$email.$image.$pass." WHERE ".$id;
            $result = mysqli_query($this->connect(),$sql);
            if ($result){
                return 'success';
            }else{
                return 'failed';
            }
        }elseif ($tableName=='student'){
            $name = "{$updateDetails[0][0]}=".'"'.$updateDetails[1][0].'"'.",";
            $phone= "{$updateDetails[0][1]}=".'"'.$updateDetails[1][1].'"'.",";
            $email = "{$updateDetails[0][2]}=".'"'.$updateDetails[1][2].'"'.",";
            $image = "{$updateDetails[0][3]}=".'"'.$updateDetails[1][3].'"';
            $id = "{$updateDetails[0][4]}=".'"'.$updateDetails[1][4].'"';

            $sql = "UPDATE ".$tableName." "."SET ".$name.$phone.$email.$image." WHERE ".$id;

            $result = mysqli_query($this->connect(),$sql);
            if ($result){
                return 'success';
            }else{
                return 'failed';
            }
        }else if ($tableName=='course'){

            $name = "{$updateDetails[0][0]}=".'"'.$updateDetails[1][0].'"'.",";
            $desc= "{$updateDetails[0][1]}=".'"'.$updateDetails[1][1].'"'.",";
            $image = "{$updateDetails[0][2]}=".'"'.$updateDetails[1][2].'"';
            $id = "{$updateDetails[0][3]}=".'"'.$updateDetails[1][3].'"';
            $sql = "UPDATE ".$tableName." "."SET ".$name.$desc.$image." WHERE ".$id;
            $result = mysqli_query($this->connect(),$sql);
            if ($result){
                return 'success';
            }else{
                return 'failed';
            }
        }


    }

}

