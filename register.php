<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SocMedSite - Register</title>

        <link href="styles.css?v=<?= filemtime('styles.css') ?>" rel="stylesheet">
    </head>
    <body>
        <div class="m-3 w-max">
            <h2 class="py-2 text-center text-xl font-bold">SocMedSite Register Page</h2>
            <form id="userRegisterForm" class="p-3 w-max border-2 border-black rounded-xl">
                <div class="p-1">
                    <label for="usernameField">Username</label>
                    <input type="text" id="usernameField" class="px-2 py-1 border border-black rounded-lg" required>
                </div>
                <div class="p-1">
                    <label for="passwordField">Password</label>
                    <input type="text" id="passwordField" class="px-2 py-1 border border-black rounded-lg" required>
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
                <input type="submit" id="goToLoginPage" value="Login" onclick="window.location.href='login.php'" class="ml-2 px-2 border-2 border-black rounded-lg hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out">
            </div>
        </div>

        <h2 id="registrationMessage"></h2>
        
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="core/script.js"></script>
    </body>
</html>