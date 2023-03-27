<?php
    include('G:\Program\Soft\MAMP\htdocs\validation-form/checkAuth.php');
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $mysql = new mysqli('localhost','root','root','educationProgram-db');

    $editId = filter_var(trim($_POST['edit_id']), FILTER_SANITIZE_STRING);

    $mysql->query("UPDATE `edits` SET `checkEdits` = '1' WHERE `edit_id` = ".$editId);

    $mysql-> close();
    header('Location: /edit/newEdit.php');
    exit();
?>