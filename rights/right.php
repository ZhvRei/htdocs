<?php
    function has_right($right){

        // прописываем все права
        switch ($right) {
            case "admin":
                $rightOfAccess = array ("admin");
                break;
            case "supervisor":
                $rightOfAccess = array ("supervisor");
                break;
            case "educator":
                $rightOfAccess = array ("educator");
                break;
        }
        
        
        $mysql = new mysqli('localhost','root','root','educationProgram-db');
        $resultUserInfo = $mysql->query
			("SELECT role.rightOfAccess FROM `users-auth` users
			LEFT JOIN `role` role ON role.user_id = users.user_id 
			WHERE users.user_id = ".$_COOKIE['user_id']);

        if ($resultUserInfo <> false) {
            $rightUser = mysqli_fetch_array($resultUserInfo);
        } 
        
        return in_array($rightUser['rightOfAccess'], $rightOfAccess);
    }
?>