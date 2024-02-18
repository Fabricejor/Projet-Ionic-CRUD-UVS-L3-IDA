<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST,PUT, GET,DELETE,OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
require "database.php";
$student = [];
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $rawPostData = file_get_contents('php://input');
    $postData = json_decode($rawPostData, true);

    if ($postData) {
        $fisrtName = $postData["fisrtname"];
        $lastName = $postData["lastname"];
        $gender = $postData["gender"];
        $age = $postData["age"];
        $email = $postData["email"];
        $update = false;
        if(isset($postData['update'])){
            $update= $postData['update'];
            $studentId=$postData['studentId'];
        }
        if ($update) {
            $query = "UPDATE `student` SET `fisrt_name` = '$fisrtName', `last_name` = '$lastName', `gender` = '$gender', `age` = '$age', `mail` = '$email' WHERE `student`.`id` = '$studentId'";
        
        } else {
        $query = "INSERT INTO student (fisrt_name,last_name,gender,age,mail) VALUES ('$fisrtName','$lastName','$gender','$age','$email')";
        }

        if (mysqli_query($conn, $query)) {
            echo "Data inserted successfully";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $student=[];
    if (isset($_GET['studentId']) ) {
        $studentId = $_GET['studentId'];
        echo $studentId;
        $query = "SELECT * FROM student where id='".$studentId."'";
        if ($is_query_run = mysqli_query($conn, $query)) {
            while ($query_executed = mysqli_fetch_assoc($is_query_run)) {
                # code...
                $student[] = $query_executed;
            }
        }
    }else if (isset($_GET['deleteId'])) {
        $studentId = $_GET['deleteId'];
        $studentId = (int)$studentId;
        $query = "DELETE FROM student WHERE id ='".intval($studentId)."'";
        if (mysqli_query($conn, $query)) {
            echo " deleted successfully  ";
            echo var_dump($studentId);
        }
    } else {
        $query = "SELECT * FROM student";
        if ($is_query_run = mysqli_query($conn, $query)) {
            while ($query_executed = mysqli_fetch_assoc($is_query_run)) {
                # code...
                $student[] = $query_executed;
            }
            echo json_encode($student);
        }
    }
}
// echo 'testing';
