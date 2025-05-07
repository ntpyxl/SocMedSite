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
                $function = registerUser($pdo, $username, $password, $firstname, $lastname);
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

    if(isset($_POST['submitPostRequest'])) {
        $postedBy = $_SESSION['user_id'];
        $postContent = $_POST['postContent'];

        $function = submitPost($pdo, $postedBy, $postContent);
        echo $function;
    }

    if(isset($_POST['editPostRequest'])) {
        $postId = $_POST['post_id'];
        $postedBy = getPostDataById($pdo, $postId)['posted_by'];
        
        $editedBy = $_SESSION['user_id'];
        $newPostContent = $_POST['newPostContent'];

        $function = editPost($pdo, $postId, $postedBy, $editedBy, $newPostContent);
        echo $function;
    }
    
    if(isset($_POST['deletePostRequest'])) {
        $postId = $_POST['post_id'];

        $function = deletePost($pdo, $postId);
        echo $function;
    }

    if(isset($_POST['submitCommentRequest'])) {
        $commentedBy = $_SESSION['user_id'];
        $postId = $_POST['post_id'];
        $commentContent = $_POST['comment_content'];

        $function = submitComment($pdo, $commentedBy, $postId, $commentContent);
        echo $function;
    }

    if(isset($_POST['editCommentRequest'])) {
        $postId = $_POST['post_id'];

        $function = editComment($pdo, $postId);
        echo $function;
    }

    if(isset($_POST['deleteCommentRequest'])) {
        $postId = $_POST['post_id'];

        $function = deleteComment($pdo, $postId);
        echo $function;
    }
?>