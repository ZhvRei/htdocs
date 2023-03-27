<?php
    include('G:\Program\Soft\MAMP\htdocs\validation-form/checkAuth.php');   
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $mysql = new mysqli('localhost','root','root','educationProgram-db');

    $code = filter_var(trim($_POST['code']), FILTER_SANITIZE_STRING);
    $educationProgramName = filter_var(trim($_POST['educationProgramName']), FILTER_SANITIZE_STRING);

    $mysql->query("INSERT INTO `competency-passport`(`code`, `name`) VALUES ('$code','$educationProgramName')");

    $mysql-> close();

    header('Location: /addition.php');
    exit();
?>