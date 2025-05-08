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
        $query = "INSERT INTO posts (posted_by, content) VALUES (?, ?)";
        $statement = $pdo -> prepare($query);
        $executeStatement = $statement -> execute([$postedBy, $postContent]);

        if($executeStatement) {
            return "postSubmissionSuccess";
        } else {
            return "postSubmissionFailed";
        }
    }

    function editPost($pdo, $postId, $newPostContent) {
        $query = "UPDATE posts SET content = ? WHERE post_id = ?";
        $statement = $pdo -> prepare($query);
        $executeStatement = $statement -> execute([$newPostContent, $postId]);

        if($executeStatement) {
            return "postEditingSuccess";
        } else {
            return "postEditingFailed";
        }
    }

    function deletePost($pdo, $postId) {
        $delPostQuery = "DELETE FROM posts WHERE post_id = ?";
        $delPostStatement = $pdo -> prepare($delPostQuery);
        $execute_delPostStatement = $delPostStatement -> execute([$postId]);

        $delCommentsQuery = "DELETE FROM comments WHERE on_post_id = ?";
        $delCommentsStatement = $pdo -> prepare($delCommentsQuery);
        $execute_delCommentsStatement = $delCommentsStatement -> execute([$postId]);

        if($execute_delPostStatement && $execute_delCommentsStatement) {
            return "postDeletionSuccess";
        } else {
            return "postDeletionFailed";
        }
    }

    function submitComment($pdo, $commentedBy, $postId, $commentContent) {
        $query = "INSERT INTO comments (commented_by, on_post_id, content) VALUES (?, ?, ?)";
        $statement = $pdo -> prepare($query);
        $executeStatement = $statement -> execute([$commentedBy, $postId, $commentContent]);

        if($executeStatement) {
            return "commentSubmissionSuccess";
        } else {
            return "commentSubmissionFailed";
        }
    }

    function editComment($pdo, $commentId, $newCommentContent) {
        $query = "UPDATE comments SET content = ? WHERE comment_id = ?";
        $statement = $pdo -> prepare($query);
        $executeStatement = $statement -> execute([$newCommentContent, $commentId]);

        if($executeStatement) {
            return "commentEditingSuccess";
        } else {
            return "commentEditingFailed";
        }
    }

    function deleteComment($pdo, $commentId) {
        $query = "DELETE FROM comments WHERE comment_id = ?";
        $statement = $pdo -> prepare($query);
        $executeStatement = $statement -> execute([$commentId]);

        if($executeStatement) {
            return "commentDeletionSuccess";
        } else {
            return "commentDeletionFailed";
        }
    }

    function getAllPostsByRecency($pdo) {
        $query = "SELECT * FROM posts ORDER BY time_posted DESC;";
        $statement = $pdo -> prepare($query);
        $executeStatement = $statement -> execute();

        if($executeStatement) {
            return $statement -> fetchAll();
        } else {
            return "failed";
        }
    }

    function getAllCommentsByRecencyByPostId($pdo, $post_id) {
        $query = "SELECT * FROM comments WHERE on_post_id = ? ORDER BY time_commented DESC;";
        $statement = $pdo -> prepare($query);
        $executeStatement = $statement -> execute([$post_id]);

        if($executeStatement) {
            return $statement -> fetchAll();
        } else {
            return "failed";
        }
    }

    function getAllLogsByRecency($pdo) {
        $query = "SELECT 
                    log_id,
                    actions.action_name,
                    done_by,
                    content_affected,
                    content_form.content_form_name,
                    content_owner_id,
                    time_logged
                FROM logs
                INNER JOIN actions ON logs.action_id = actions.action_id
                INNER JOIN content_form ON logs.content_form_id = content_form.content_form_id
                ORDER BY time_logged DESC;";
        $statement = $pdo -> prepare($query);
        $executeStatement = $statement -> execute();

        if($executeStatement) {
            return $statement -> fetchAll();
        } else {
            return "failed";
        }
    }

    function logAction($pdo, $action, $doneBy, $contentAffected, $contentForm, $contentOwner) {
        $query = "INSERT INTO logs (action_id, done_by, content_affected, content_form_id, content_owner_id) VALUES (?, ?, ?, ?, ?)";
        $statement = $pdo -> prepare($query);
        $executeStatement = $statement -> execute([$action, $doneBy, $contentAffected, $contentForm, $contentOwner]);

        if($executeStatement) {
            return "logActionSuccess";
        } else {
            return "logActionFailed";
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

    function getCommentDataById($pdo, $comment_id) {
        $query = "SELECT * FROM comments WHERE comment_id = ?";
        $statement = $pdo -> prepare($query);
        $executeQuery = $statement -> execute([$comment_id]);

        if($executeQuery) {
            return $statement -> fetch();
        } else {
            return "failed";
        }
    }

    function getRecentPostId($pdo) {
        $query = "SELECT post_id FROM posts ORDER BY time_posted DESC LIMIT 1";
        $statement = $pdo -> prepare($query);
        $executeQuery = $statement -> execute();

        if($executeQuery) {
            return $statement -> fetch();
        } else {
            return "failed";
        }
    }

    function getRecentCommentId($pdo) {
        $query = "SELECT comment_id FROM comments ORDER BY time_commented DESC LIMIT 1";
        $statement = $pdo -> prepare($query);
        $executeQuery = $statement -> execute();

        if($executeQuery) {
            return $statement -> fetch();
        } else {
            return "failed";
        }
    }

    function getRecentUserId($pdo) {
        $query = "SELECT user_id FROM users ORDER BY date_registered DESC LIMIT 1";
        $statement = $pdo -> prepare($query);
        $executeQuery = $statement -> execute();

        if($executeQuery) {
            return $statement -> fetch();
        } else {
            return "failed";
        }
    }
?>