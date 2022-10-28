CREATE DATABASE php_login_management_test;
CREATE TABLE users(
    id VARCHAR(255) NOT NULL PRIMARY KEY ,
    name VARCHAR(255) NOT NULL ,
    password VARCHAR(255) NOT NULL
)ENGINE InnoDB;

CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY ,
    user_id VARCHAR(255) NOT NULL
)ENGINE InnodB;

ALTER TABLE sessions add
    CONSTRAINT fk_session_user
FOREIGN KEY (user_id)
REFERENCES users(id);

SELECT * FROM sessions;
SHOW TABLES;

SELECT * FROM users;
