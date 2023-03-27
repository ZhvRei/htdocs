<?php
if($_COOKIE['user'] == '') {
    echo "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css'>
    <link rel='stylesheet' href='css/style.css'>
    <div class='container mt-4'>
    <a href='/' class='btn btn-outline-primary' role='button' aria-pressed='true'>Назад</a>";
    echo "<br /> Время авторизации истекло, пожалуйста, вернитесь на главную страницу для повторного прохождения аутентификации";
    exit();
}
?>