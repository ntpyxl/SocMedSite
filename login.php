<?php require_once "core/functions.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SocMedSite - Login</title>

        <link href="styles.css?v=<?= filemtime('styles.css') ?>" rel="stylesheet">
    </head>
    <body>
        <div class="m-3 w-max">
            <h2 class="py-2 text-center text-xl font-bold">SocMedSite Login Page</h2>
            <form id="userLoginForm" class="p-3 w-max border-2 border-black rounded-xl">
                <div class="p-1">
                    <label for="usernameField">Username</label>
                    <input type="text" id="usernameField" class="px-2 py-1 border border-black rounded-lg" required>
                </div>
                <div class="p-1">
                    <label for="passwordField">Password</label>
                    <input type="text" id="passwordField" class="px-2 py-1 border border-black rounded-lg" required>
                </div>
                <div class="p-1">
                    <input type="submit" id="loginButton" value="Login" class="px-2 border-2 border-black rounded-lg hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out">
                </div>
            </form>
            <div class="p-3">
                No account yet?
                <input type="submit" id="goToRegisterPage" value="Register" onclick="window.location.href='register.php'" class="ml-2 px-2 border-2 border-black rounded-lg hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out">
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="core/script.js"></script>
    </body>
</html>