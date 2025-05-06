<?php 
    require_once "dbConfig.php";

    function registerUser($pdo, $username, $password, $firstname, $lastname) {
        $uacQuery = "INSERT INTO user_accounts (username, userpassword) VALUES (?, ?)";
        $uacStatement = $pdo -> prepare($uacQuery);
        $execute_uacQuery = $uacStatement -> execute([$username, $password]);

        $accQuery = "INSERT INTO users (firstname, lastname) VALUES (?, ?)";
        $accStatement = $pdo -> prepare($accQuery);
        $execute_accQuery = $accStatement -> execute([$firstname, $lastname]);

        if($execute_uacQuery && $execute_accQuery) {
            return "registrationSuccess";
        } else {
            return "registrationFailed";
        }
    }

    function loginUser($pdo, $username, $password) {
        $userAccData = getUserAccDataByUsername($pdo, $username);
        
        if($userAccData == "no match") {
            return "noMatchingUsername";
        } else if ($userAccData == "failed") {
            return "loginFailed";
        }

        if(password_verify($password, $userAccData['userpassword'])) {
            $_SESSION['user_id'] = $userAccData['user_id'];
            $_SESSION['user_firstname'] = getUserInfoDataById($pdo, $userAccData['user_id'])['firstname'];
            return "loginSuccess";
        } else {
            return "incorrectPassword";
        }
    }

    function submitPost($pdo, $postedBy, $postContent) {
        $submitPostQuery = "INSERT INTO posts (posted_by, content) VALUES (?, ?)";
        $submitPostStatement = $pdo -> prepare($submitPostQuery);
        $execute_submitPostStatement = $submitPostStatement -> execute([$postedBy, $postContent]);

        if($execute_submitPostStatement) {
            return "postSubmissionSuccess";
        } else {
            return "postSubmissionFailed";
        }
    }

    function editPost($pdo, $postId, $postedBy, $editedBy, $newPostContent) {
        $editPostQuery = "UPDATE posts SET content = ? WHERE post_id = ?";
        $editPostStatement = $pdo -> prepare($editPostQuery);
        $execute_editPostStatement = $editPostStatement -> execute([$newPostContent, $postId]);

        if($execute_editPostStatement) {
            return "postEditingSuccess";
        } else {
            return "postEditingFailed";
        }
    }

    function getAllPostsByRecency($pdo) {
        $getPostsQuery = "SELECT * FROM posts ORDER BY time_posted DESC;";
        $getPostsStatement = $pdo -> prepare($getPostsQuery);
        $execute_getPostsStatement = $getPostsStatement -> execute();

        if($execute_getPostsStatement) {
            return $getPostsStatement -> fetchAll();
        } else {
            return "failed";
        }
    }

////////////////////////////////////////////////
////////////////////////////////////////////////

    function getUserInfoDataById($pdo, $user_id) {
        $query = "SELECT * FROM users WHERE user_id = ?";
        $statement = $pdo -> prepare($query);
        $executeQuery = $statement -> execute([$user_id]);
        
        if($executeQuery) {
            return $statement -> fetch();
        } else {
            return "failed";
        }
    }

    function getUserAccDataByUsername($pdo, $username) {
        $query = "SELECT * FROM user_accounts WHERE username = ?";
        $statement = $pdo -> prepare($query);
        $executeQuery = $statement -> execute([$username]);
        
        if($executeQuery && $statement -> rowCount() == 1) {
            return $statement -> fetch();
        } else if($executeQuery && $statement -> rowCount() == 0) {
            return "no match";
        } else {
            return "failed";
        }
    }

    function getPostDataById($pdo, $post_id) {
        $query = "SELECT * FROM posts WHERE post_id = ?";
        $statement = $pdo -> prepare($query);
        $executeQuery = $statement -> execute([$post_id]);

        if($executeQuery) {
            return $statement -> fetch();
        } else {
            return "failed";
        }
    }
?>