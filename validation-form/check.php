<?php

    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $mysql = new mysqli('localhost','root','root','educationProgram-db');

    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    
    if (mb_strlen($login) < 5 || mb_strlen($login) > 90) {
        echo "Недопустимая длиная логина";
        exit();
    } else if (mb_strlen($name) < 3 || mb_strlen($name) > 50) {
        echo "Недопустимая длиная имени";
        exit();
    } else if (mb_strlen($pass) < 2 || mb_strlen($pass) > 10) {
        echo "Недопустимая длиная пароля (от 3 до 10 символов)";
        exit();
    }

    $pass = md5($pass."asfkdhfkj31lk1!");   

    $mysql->query("INSERT INTO `users-auth` (`login`, `pass`, `name`) VALUES ('$login', '$pass', '$name')");
    
    $mysql-> close();

    header('Location: /');
    exit();
?>