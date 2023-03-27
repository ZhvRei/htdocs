<?php
    include('G:\Program\Soft\MAMP\htdocs\validation-form/checkAuth.php');
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $mysql = new mysqli('localhost','root','root','educationProgram-db');

    $educationalProgram = filter_var(trim($_POST['disciplineIndicator']), FILTER_SANITIZE_STRING);
    $knowledge = filter_var(trim($_POST['knowledge']), FILTER_SANITIZE_STRING);
    $skills = filter_var(trim($_POST['skills']), FILTER_SANITIZE_STRING);
    $attaiment = filter_var(trim($_POST['attaiment']), FILTER_SANITIZE_STRING);

    $mysql->query("INSERT INTO `indicator-mastering`(`disp_id`, `knowledge`, `skills`, `attaiment`) 
    VALUES ('$educationalProgram','$knowledge','$skills','$attaiment')");

    $mysql-> close();

    header('Location: /addition.php');
    exit();
?>