<?php 
    require_once "dbConfig.php";
    require_once "functions.php";

    if(isset($_POST['userRegisterRequest'])) {
        $username = $_POST['username'];
        $password = $_POST['password']; // TODO: HASH PASSWORD
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        $function = registerUser($pdo, $username, $password, $firstname, $lastname);
        echo $function;
    }
?>