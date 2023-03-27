<?php
    include('G:\Program\Soft\MAMP\htdocs\validation-form/checkAuth.php');
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $mysql = new mysqli('localhost','root','root','educationProgram-db');

    $nameDiscipline = filter_var(trim($_POST['disciplineName']), FILTER_SANITIZE_STRING);
    
    if (mb_strlen($nameDiscipline) < 5 || mb_strlen($nameDiscipline) > 140) {
        echo "Недопустимая длиная названия дисциплины";
        exit();
    }

    $mysql->query("INSERT INTO `discipline` (`disp_name`) VALUES ('$nameDiscipline')");
    
    $mysql-> close();

    header('Location: /addition.php');
    exit();
?>