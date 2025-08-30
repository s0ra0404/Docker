CREATE USER IF NOT EXISTS 'data_sora'@'localhost' IDENTIFIED BY 'data';
GRANT ALL PRIVILEGES ON * . * TO 'data_sora'@'localhost';

CREATE USER IF NOT EXISTS 'data_sora'@'%' IDENTIFIED BY 'data';
GRANT ALL PRIVILEGES ON * . * TO 'data_sora'@'%';

DROP DATABASE IF EXISTS score_db;
CREATE DATABASE IF NOT EXISTS score_db;

use score_db;

DROP TABLE IF EXISTS score_table;
CREATE TABLE IF NOT EXISTS score_table (
    id INT PRIMARY KEY,
    player_name VARCHAR(255),
    score INT
);


insert into score_table (id, player_name, score) values (1, 'AKIRA', 1000);
insert into score_table (id, player_name, score) values (2, 'DAIKI', 1400);
insert into score_table (id, player_name, score) values (3, 'SORA', 2300);
insert into score_table (id, player_name, score) values (4, 'HIROTO', 3000);