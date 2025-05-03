<?php 
    require_once "dbConfig.php";

    function registerUser($pdo, $username, $password, $firstname, $lastname) {
        $uacQuery = "INSERT INTO user_accounts (username, userpassword) VALUES (?, ?)";
        $uacStatement = $pdo -> prepare($uacQuery);
        $execute_uacQuery = $uacStatement -> execute([$username, $password]);

        $accQuery = "INSERT INTO users (firstname, lastname) VALUES (?, ?)";
        $accStatement = $pdo -> prepare($accQuery);
        $execute_accQuery = $accStatement -> execute([$firstname, $lastname]);

        if($execute_uacQuery && $execute_accQuery) {
            return "registrationSuccess";
        } else {
            return "registrationFailed";
        }
    }
?>