<?php
    include('G:\Program\Soft\MAMP\htdocs\validation-form/checkAuth.php');
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $mysql = new mysqli('localhost','root','root','educationProgram-db');

    $educationalProgram = filter_var(trim($_POST['educationalProgram']), FILTER_SANITIZE_STRING);
    $disciplineId = filter_var(trim($_POST['disciplineList']), FILTER_SANITIZE_STRING);
    $educator = filter_var(trim($_POST['educator']), FILTER_SANITIZE_STRING);

    $mysql->query("INSERT INTO `disciplines_list`(`pass_id`, `disp_id`) VALUES ('$educationalProgram','$disciplineId')");
    $mysql->query("INSERT INTO `teaching-disciplines`(`user_id`, `disp_id`, `pass_id`) VALUES ('$educator','$disciplineId','$educationalProgram')");
    
    $mysql-> close();

    header('Location: /addition.php');
    exit();
?>