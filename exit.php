<?php
    setcookie('user', $user['name'], time() - 36000, "/"); 
    setcookie('user', $user['user_id'], time() - 36000, "/"); 
    header('Location: /');
?>