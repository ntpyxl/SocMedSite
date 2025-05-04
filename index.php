<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SocMedSite</title>

        <link href="styles.css?v=<?= filemtime('styles.css') ?>" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    </head>
    <body>
        HELLO !
        <?php 
        echo $_SESSION['user_id'];
        echo $_SESSION['user_firstname'];
        ?>

        <script src="core/script.js"></script>
    </body>
</html>