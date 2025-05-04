<?php 
    require_once "dbConfig.php";
    require_once "functions.php";

    if(isset($_POST['userRegisterRequest'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $verifyPassword = $_POST['verifyPassword']; 
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        if(getUserAccDataByUsername($pdo, $username) == "no match") {
            if($_POST['password'] == $_POST['verifyPassword']) {
                $function = registerUser($pdo, $username, $password, $verifyPassword, $firstname, $lastname);
                echo $function;
            } else {
                echo "passwordNotVerified";
            }
        } else {
            echo "usernameExists";
        }
    }

    if(isset($_POST['userLoginRequest'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $function = loginUser($pdo, $username, $password);
        echo $function;
    }
?>