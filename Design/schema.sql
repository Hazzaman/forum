USE DATABASE forum_db;
DROP TABLE moderators_forums;
DROP TABLE moderators;
DROP TABLE administrators;
DROP TABLE comments;
DROP TABLE threads;
DROP TABLE forums;
DROP TABLE users;

CREATE TABLE users
(
id INT NOT NULL AUTO_INCREMENT,
username VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
email VARCHAR(254) NOT NULL,
created DATE NOT NULL,
PRIMARY KEY (id) 
);

CREATE TABLE forums
(
id INT NOT NULL AUTO_INCREMENT,
title VARCHAR(255) NOT NULL,
created DATE NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE threads
(
id INT NOT NULL AUTO_INCREMENT,
forum_id INT NOT NULL,
title VARCHAR(255) NOT NULL,
created DATE NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (forum_id) REFERENCES forums(id)
);

CREATE TABLE comments
(
id INT NOT NULL AUTO_INCREMENT,
thread_id INT NOT NULL,
user_id INT NOT NULL,
text VARCHAR(10000),
created DATETIME NOT NULL,
modified DATETIME,
PRIMARY KEY (id),
FOREIGN KEY (thread_id) REFERENCES threads(id),
FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE administrators
(
user_id INT NOT NULL,
PRIMARY KEY (user_id),
FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE moderators
(
moderator_id INT NOT NULL AUTO_INCREMENT,
user_id INT NOT NULL,
PRIMARY KEY (moderator_id),
FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE moderators_forums
(
id INT NOT NULL AUTO_INCREMENT,
moderator_id INT NOT NULL,
forum_id INT NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (moderator_id) REFERENCES moderators(moderator_id),
FOREIGN KEY (forum_id) REFERENCES forums(id),
UNIQUE (moderator_id, forum_id)
);

