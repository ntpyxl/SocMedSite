<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SocMedSite - Register</title>

        <link href="styles.css?v=<?= filemtime('styles.css') ?>" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    </head>
    <body>
        <div class="mx-auto my-6 w-max">
            <h2 class="py-2 text-center text-xl font-bold">SocMedSite Register Page</h2>
            <form id="userRegisterForm" class="p-3 w-max border-2 border-black rounded-xl">
                <div class="p-1">
                    <label for="usernameField">Username</label>
                    <input type="text" id="usernameField" class="px-2 py-1 border border-black rounded-lg" required>
                </div>
                <div class="p-1">
                    <label for="passwordField">Password</label>
                    <input type="password" id="passwordField" class="px-2 py-1 border border-black rounded-lg" required>
                </div>
                <div class="p-1">
                    <label for="verifyPasswordField">Verify Password</label>
                    <input type="password" id="verifyPasswordField" class="px-2 py-1 border border-black rounded-lg" required>
                </div>
                <div class="mt-3 p-1">
                    <label for="firstnameField">Firstname</label>
                    <input type="text" id="firstnameField" class="px-2 py-1 border border-black rounded-lg" required>
                </div>
                <div class="p-1">
                    <label for="lastnameField">Lastname</label>
                    <input type="text" id="lastnameField" class="px-2 py-1 border border-black rounded-lg" required>
                </div>
                <div class="p-1">
                    <input type="submit" id="registerButton" value="Register" class="px-2 border-2 border-black rounded-lg hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out">
                </div>
            </form>
            <div class="p-3">
                Already have an account?
                <button onclick="window.location.href='login.php'" class="ml-2 px-2 border-2 border-black rounded-lg hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out">Login</button>
            </div>
        </div>

        <div id="registerFailMessage" class="mx-auto p-2 w-max max-w-[75vw] border-2 rounded-lg bg-red-400 hidden">
            <h4 class="px-8 py-2 text-center text-lg font-bold">Registration Failed!</h4>
            <p id="failMessage" class="py-2 text-center break-word"></p>
        </div>
        
        <script src="core/script.js"></script>
    </body>
</html>