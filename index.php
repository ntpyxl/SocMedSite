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
                    <h5 class="text-2xl font-semibold">Hello, <?php echo $_SESSION['user_firstname']; ?>!</h5>
                    <button onclick="window.location.href='core/logout.php';" class="w-24 h-8 mt-2 px-2 border-2 border-black rounded-lg font-semibold hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out">LOG OUT</button>

                    <div id="message" class="mt-5 p-2 h-max border-2 rounded-lg bg-red-400 hidden">
                        <h4 id="mainMessage" class="py-2 text-center text-lg font-bold">Post Editing Failed!</h4>
                        <p id="subMessage" class="py-2 text-center break-word hidden"></p>
                    </div>

                    <?php 
                    if(isset($_GET['loginSuccess'])) {
                        echo "<script>
                            $('#mainMessage').text('Successfully Logged In!');
                            $('#subMessage').addClass('hidden');
                            $('#message').addClass('bg-green-400');
                            $('#message').removeClass('bg-red-400');
                            $('#message').removeClass('hidden');
                        </script>";
                    }
                    if(isset($_GET['postSubmissionSuccess'])) {
                        echo "<script>
                            $('#mainMessage').text('Successfully Submitted Post!');
                            $('#subMessage').addClass('hidden');
                            $('#message').addClass('bg-green-400');
                            $('#message').removeClass('bg-red-400');
                            $('#message').removeClass('hidden');
                        </script>";
                    }
                    if(isset($_GET['postEditSuccess'])) {
                        echo "<script>
                            $('#mainMessage').text('Successfully Edited Post!');
                            $('#subMessage').addClass('hidden');
                            $('#message').addClass('bg-green-400');
                            $('#message').removeClass('bg-red-400');
                            $('#message').removeClass('hidden');
                        </script>";
                    }
                    if(isset($_GET['postDeleteSuccess'])) {
                        echo "<script>
                            $('#mainMessage').text('Successfully Deleted Post!');
                            $('#subMessage').addClass('hidden');
                            $('#message').addClass('bg-green-400');
                            $('#message').removeClass('bg-red-400');
                            $('#message').removeClass('hidden');
                        </script>";
                    }
                    if(isset($_GET['commentSubmissionSuccess'])) {
                        echo "<script>
                            $('#mainMessage').text('Successfully Submitted Comment!');
                            $('#subMessage').addClass('hidden');
                            $('#message').addClass('bg-green-400');
                            $('#message').removeClass('bg-red-400');
                            $('#message').removeClass('hidden');
                        </script>";
                    }
                    ?>
                </div>
                
            </div>
            <div class="grid col-span-12 lg:col-span-5 p-3 border-2 border-black">
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
                        <div id="post" class="my-2 p-3 border-2 border-black">
                            <p id="post_id" class="hidden"><?php echo $post['post_id']; ?></p>
                            <div class="flex justify-between items-center">
                                <div class="break-words max-w-full">
                                    <?php 
                                    $posterData = getUserInfoDataById($pdo, $post['posted_by']);
                                    ?>
                                    <p class="font-semibold">Posted by: <br class="md:hidden"><?php echo $posterData['firstname'] . ' ' . $posterData['lastname'] ?></p>
                                </div>
                                <?php
                                if($_SESSION['user_id'] == $post['posted_by']) {
                                ?>
                                    <div class="flex mt-2 sm:mt-0">
                                        <button id="editPostButton" class="mx-1 px-4 py-2 md:py-1 border-2 border-black rounded-lg font-semibold hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out">Edit</button>
                                        <button id="deletePostbutton" class="mx-1 px-4 py-2 md:py-1 border-2 border-black rounded-lg font-semibold hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out">Delete</button>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div id="displayOnlyPostContent" class="px-1 py-3 font-normal">
                                <?php echo $post['content']; ?>
                            </div>

                            <textarea id="editablePostContent" rows="4" class="w-full my-3 px-3 py-1 border-2 border-black resize-none focus:bg-cyan-100 hidden"><?php echo $post['content'] ?></textarea>

                            <div id="confirmationSection" class="p-1 hidden">
                                <hr class="mb-3 border-t-2 rounded-full w-11/12 mx-auto">

                                <p id="confirmMessage" class="font-semibold"></p>
                                <button id="confirmSec_Y" class="mt-2 px-4 py-2 md:py-1 border-2 border-black rounded-lg font-semibold hover:bg-red-300 cursor-pointer hover:scale-105 transition duration-100 ease-out">Yes</button>
                                <button id="confirmSec_N" class="mt-2 px-4 py-2 md:py-1 border-2 border-black rounded-lg font-semibold hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out ">No</button>
                            </div>

                            <hr class="mt-3 border-t-2 rounded-full w-full mx-auto">

                            <div id="commentSection" class="py-1 font-semibold ">
                                COMMENTS
                                <form id="commentForm" class="flex flex-col lg:flex-row mt-2">
                                    <textarea id="commentContent" class="w-full px-3 py-2 border-2 border-black font-normal resize-none focus:bg-cyan-100" rows="1"></textarea>
                                    <input type="submit" id="submitComment" value="Comment!" class="ml-0 lg:ml-5 mt-2 px-3 py-2 lg:py-0 border-2 border-black rounded-lg text-lg font-bold hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out">
                                </form>

                                <div id="mainCommentSection" class="p-2">
                                    <?php
                                    $allPostCommentsSortedByRecency = getAllCommentsByRecencyByPostId($pdo, $post['post_id']);
                                    foreach($allPostCommentsSortedByRecency as $comment) {
                                    ?>
                                        <div class="border-2 border-black p-2 comment">
                                            <div class="flex justify-between items-center">
                                                <div class="break-words max-w-full">
                                                    <?php 
                                                    $commenterData = getUserInfoDataById($pdo, $comment['commented_by']);
                                                    ?>
                                                    <p class="font-semibold">Commented by: <br class="md:hidden"><?php echo $commenterData['firstname'] . ' ' . $commenterData['lastname'] ?></p>
                                                </div>
                                                <?php
                                                if($_SESSION['user_id'] == $comment['commented_by']) {
                                                ?>
                                                    <div class="flex mt-2 sm:mt-0">
                                                        <button id="editCommentButton" class="mx-1 px-4 py-2 md:py-1 border-2 border-black rounded-lg font-semibold hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out">Edit</button>
                                                        <button id="deleteCommentbutton" class="mx-1 px-4 py-2 md:py-1 border-2 border-black rounded-lg font-semibold hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out">Delete</button>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>

                                            <div id="displayOnlyCommentContent" class="px-1 py-1 font-normal">
                                                <?php echo $comment['content']; ?>
                                            </div>

                                            <textarea id="editableCommentContent" rows="4" class="w-full my-3 px-3 py-1 border-2 border-black resize-none focus:bg-cyan-100 hidden"><?php echo $post['content'] ?></textarea>

                                            <div id="confirmationSection" class="p-1 hidden">
                                                <hr class="mb-3 border-t-2 rounded-full w-11/12 mx-auto">

                                                <p id="confirmMessage" class="font-semibold"></p>
                                                <button id="confirmSec_Y" class="mt-2 px-4 py-2 md:py-1 border-2 border-black rounded-lg font-semibold hover:bg-red-300 cursor-pointer hover:scale-105 transition duration-100 ease-out">Yes</button>
                                                <button id="confirmSec_N" class="mt-2 px-4 py-2 md:py-1 border-2 border-black rounded-lg font-semibold hover:bg-cyan-200 cursor-pointer hover:scale-105 transition duration-100 ease-out ">No</button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="grid col-span-12 lg:col-span-4 p-3 border-2 border-black">
                <h2 class="text-center text-2xl font-semibold">RECENT ACTIVITIES</h2>
            </div>
        </div>

        <script src="core/script.js"></script>
    </body>
</html>