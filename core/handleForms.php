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
                if($function == "registrationSuccess") {
                    $recentUserId = getRecentUserId($pdo)['user_id'];
                    logAction($pdo, 1, $recentUserId, $recentUserId, 1, $recentUserId);
                }
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
        if($function == "postSubmissionSuccess") {
            logAction($pdo, 1, $postedBy, getRecentPostId($pdo)['post_id'], 2, $postedBy);
        }
        echo $function;
    }

    if(isset($_POST['editPostRequest'])) {
        $postId = $_POST['post_id'];
        $postedBy = getPostDataById($pdo, $postId)['posted_by'];
        $newPostContent = $_POST['new_post_content'];

        $function = editPost($pdo, $postId, $newPostContent);
        if($function == "postEditingSuccess") {
            logAction($pdo, 2, $_SESSION['user_id'], $postId, 2, $postedBy);
        }
        echo $function;
    }
    
    if(isset($_POST['deletePostRequest'])) {
        $postId = $_POST['post_id'];
        $postedBy = getPostDataById($pdo, $postId)['posted_by'];

        $function = deletePost($pdo, $postId);
        if($function == "postDeletionSuccess") {
            logAction($pdo, 3, $_SESSION['user_id'], $postId, 2, $postedBy);
        }
        echo $function;
    }

    if(isset($_POST['submitCommentRequest'])) {
        $commentedBy = $_SESSION['user_id'];
        $postId = $_POST['post_id'];
        $commentContent = $_POST['comment_content'];

        $function = submitComment($pdo, $commentedBy, $postId, $commentContent);
        if($function == "commentSubmissionSuccess") {
            logAction($pdo, 1, $commentedBy, getRecentCommentId($pdo)['comment_id'], 3, $commentedBy);
        }
        echo $function;
    }

    if(isset($_POST['editCommentRequest'])) {
        $commentId = $_POST['comment_id'];
        $commentedBy = getCommentDataById($pdo, $commentId)['commented_by'];
        $newCommentContent = $_POST['new_comment_content'];

        $function = editComment($pdo, $commentId, $newCommentContent);
        if($function == "commentEditingSuccess") {
            logAction($pdo, 2, $_SESSION['user_id'], getRecentCommentId($pdo)['comment_id'], 3, $commentedBy);
        }
        echo $function;
    }

    if(isset($_POST['deleteCommentRequest'])) {
        $commentId = $_POST['comment_id'];
        $commentedBy = getCommentDataById($pdo, $commentId)['commented_by'];

        $function = deleteComment($pdo, $commentId);
        if($function == "commentDeletionSuccess") {
            logAction($pdo, 3, $_SESSION['user_id'], $commentId, 3, $commentedBy);
        }
        echo $function;
    }
?>