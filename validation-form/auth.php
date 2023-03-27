<?php

    ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

    $mysql = new mysqli('localhost','root','root','educationprogram-db');

    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);

    $pass = md5($pass."asfkdhfkj31lk1!"); 

    $result = $mysql->query("SELECT * FROM `users-auth` WHERE `login` = '$login' AND `pass` = '$pass'");
    $user = $result->fetch_assoc();
    
    if (empty($user)) {
        echo "Пользователь не найден. Чтобы вернуться на главную страницу нажмите <a href='/'>здесь</a>";
        exit();
    }

    setcookie('user', $user['name'], time() + 36000, "/");
    setcookie('user_id', $user['user_id'], time() + 36000, "/");

    $mysql-> close();

    header('Location: /');
?>

