<?php
require_once "core/functions.php";
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SocMedSite</title>

        <link href="styles.css?v=<?= filemtime('styles.css') ?>" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    </head>
    <body class="py-3">
        <div class="grid grid-cols-12 gap-6 px-5 py-3">
            <div class="grid col-span-12 lg:col-span-2 p-3 border-2 border-black">
                <div>
                    <h5 class="text-2xl font-semibold">Hello, <?php echo $_SESSION['user_firstname'] ?>!</h5>
                    <button onclick="window.location.href='core/logout.php';" class="w-24 h-8 mt-2 px-2 border-2 border-black rounded-lg font-semibold hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out">LOG OUT</button>

                    <div id="loginSuccessMessage" class="mt-5 p-2 h-max border-2 rounded-lg bg-green-400 hidden">
                        <h4 class="py-2 text-center text-lg font-bold">Logged In Successfully!</h4>
                    </div>

                    <div id="postSuccessMessage" class="mt-5 p-2 h-max border-2 rounded-lg bg-green-400 hidden">
                        <h4 class="py-2 text-center text-lg font-bold">Post Submitted Successfully!</h4>
                    </div>

                    <div id="postFailedMessage" class="mt-5 p-2 h-max border-2 rounded-lg bg-red-400 hidden">
                        <h4 class="py-2 text-center text-lg font-bold">Post Submission Failed!</h4>
                    </div>

                    <div id="editPostSuccessMessage" class="mt-5 p-2 h-max border-2 rounded-lg bg-green-400 hidden">
                        <h4 class="py-2 text-center text-lg font-bold">Post Edited Successfully!</h4>
                    </div>

                    <div id="editPostFailedMessage" class="mt-5 p-2 h-max border-2 rounded-lg bg-red-400 hidden">
                        <h4 class="py-2 text-center text-lg font-bold">Post Editing Failed!</h4>
                        <p id="failMessage" class="py-2 text-center break-word"></p>
                    </div>

                    <?php 
                    if(isset($_GET['loginSuccess'])) {
                        echo "<script>$('#loginSuccessMessage').removeClass('hidden');</script>";
                    }

                    if(isset($_GET['postSubmissionSuccess'])) {
                        echo "<script>$('#postSuccessMessage').removeClass('hidden');</script>";
                    }

                    if(isset($_GET['postEditSuccess'])) {
                        echo "<script>$('#editPostSuccessMessage').removeClass('hidden');</script>";
                    }
                    ?>
                </div>
                
            </div>
            <div class="grid col-span-12 lg:col-span-6 p-3 border-2 border-black">
                <div>
                    <h3 class="text-xl font-semibold">What's on your thought?</h3>
                    <form id="postForm" class="mt-2">
                        <textarea id="postContent" class="w-full px-3 py-2 border-2 border-black resize-none focus:bg-cyan-100" rows="3"></textarea>
                        <input type="submit" id="submitPost" value="Post!" class="mt-2 px-5 py-1 border-2 border-black rounded-lg text-lg font-bold hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out">
                    </form>
                </div>

                <hr class="mt-6 mb-4 border-t-2 rounded-full w-11/12 mx-auto">

                <div>
                    <?php
                    $allPostsSortedByRecency = getAllPostsByRecency($pdo);
                    foreach($allPostsSortedByRecency as $post) {
                    ?>
                        <div class="my-2 p-3 border-2 border-black post">
                            <p class="hidden post_id"><?php echo $post['post_id'] ?></p>
                            <div class="flex justify-between items-center">
                                <div class="break-words max-w-full">
                                    <?php 
                                    $userData = getUserInfoDataById($pdo, $post['posted_by']);
                                    ?>
                                    <p class="font-semibold">Posted by: <br class="md:hidden"><?php echo $userData['firstname'] . ' ' . $userData['lastname'] ?></p>
                                </div>
                                <div class="flex mt-2 sm:mt-0">
                                    <button class="mx-1 px-4 py-2 md:py-1 border-2 border-black rounded-lg font-semibold hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out editPostButton">Edit</button>
                                    <button class="mx-1 px-4 py-2 md:py-1 border-2 border-black rounded-lg font-semibold hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out deletePostbutton">Delete</button>
                                </div>
                            </div>
                            <div class="px-1 py-3 displayOnlyPostContent">
                                <?php echo $post['content'] ?>
                            </div>

                            <textarea rows="4" class="w-full my-3 px-3 py-1 border-2 border-black resize-none focus:bg-cyan-100 hidden editablePostContent"><?php echo $post['content'] ?></textarea>

                            <div class="p-1 hidden confirmationSection">
                                <hr class="mb-3 border-t-2 rounded-full w-11/12 mx-auto">

                                <p class="font-semibold confirmMessage"></p>
                                <button class="mt-2 px-4 py-2 md:py-1 border-2 border-black rounded-lg font-semibold hover:bg-red-300 cursor-pointer hover:scale-105 transition duration-100 ease-out confirmSec_Y">Yes</button>
                                <button class="mt-2 px-4 py-2 md:py-1 border-2 border-black rounded-lg font-semibold hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out confirmSec_N">No</button>
                            </div>

                            <div class="py-1 font-semibold commentSection">
                                COMMENTS
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="grid col-span-12 lg:col-span-3 p-3 border-2 border-black">
                <h2 class="text-center text-2xl font-semibold">RECENT ACTIVITIES</h2>
            </div>
        </div>

        <script src="core/script.js"></script>
    </body>
</html>