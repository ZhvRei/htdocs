<?php
    include('G:\Program\Soft\MAMP\htdocs\validation-form/checkAuth.php');
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $mysql = new mysqli('localhost','root','root','educationProgram-db');

    $disciplineId = filter_var(trim($_POST['disciplineIndicator']), FILTER_SANITIZE_STRING);
    $knowledge = filter_var(trim($_POST['knowledge']), FILTER_SANITIZE_STRING);
    $skills = filter_var(trim($_POST['skills']), FILTER_SANITIZE_STRING);
    $attaiment = filter_var(trim($_POST['attaiment']), FILTER_SANITIZE_STRING);
    $educationalProgramId = filter_var(trim($_POST['educationalProgram']), FILTER_SANITIZE_STRING);
    
    $resultSupervisor = $mysql->query("SELECT `user_id` FROM `supervised-educational-programs` WHERE `pass_id` = ".$educationalProgramId);
    // if (!$resultSupervisor) {
    //     die("Ошибка соединения");
    // }
    
    echo "SELECT `user_id` FROM `supervised-educational-programs` WHERE `pass_id` = ".$educationalProgramId;

    $supervisorId = mysqli_fetch_array($resultSupervisor);
    $id =  $supervisorId['user_id'];

    if (is_null($id)) {
        echo "Руководитель по данному направлению не назначен";
        exit();
    }

    if (empty($_COOKIE['user_id'])) {
        echo "Время авторизации вышло.";
        exit();
    } else {
        $educatorId = $_COOKIE['user_id'];
    }
    
    $mysql->query("INSERT INTO `edits`(`supervisor_id`, `disp_id`, `educator_id`, `knowledge`, `skills`, `attaiment`) 
    VALUES ('$id','$disciplineId', '$educatorId', '$knowledge','$skills','$attaiment')");

    $mysql-> close();

    header('Location: /addition.php');
    exit();
?>