CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(128) NOT NULL,
    lastname VARCHAR(128) NOT NULL,
    date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE user_accounts (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(64) NOT NULL,
    userpassword VARCHAR(256) NOT NULL
);

CREATE TABLE posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    posted_by INT NOT NULL,
    content VARCHAR(4096) NOT NULL,
    time_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    commented_by INT NOT NULL,
    on_post_id INT NOT NULL,
    content VARCHAR(2048) NOT NULL,
    time_commented TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    action_id INT NOT NULL,
    done_by INT NOT NULL,
    content_affected VARCHAR(512) NOT NULL,
    add_remarks VARCHAR(512),
    time_logged TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE actions (
    action_id INT PRIMARY KEY,
    action_name VARCHAR(128)
);

insert into actions (action_id, action_name) values
(1, "CREATED"),
(2, "UPDATED"),
(3, "DELETED");