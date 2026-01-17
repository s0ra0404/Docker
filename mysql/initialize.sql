CREATE USER IF NOT EXISTS 'Sora'@'localhost' IDENTIFIED BY 'Test';
GRANT ALL PRIVILEGES ON * . * TO 'Sora'@'localhost';

CREATE USER IF NOT EXISTS 'Sora'@'%' IDENTIFIED BY 'Test';
GRANT ALL PRIVILEGES ON * . * TO 'Sora'@'%';

DROP DATABASE IF EXISTS c_database;
CREATE DATABASE IF NOT EXISTS c_database;

use c_database;

-- アイテムの情報
CREATE TABLE IF NOT EXISTS cards (
    card_id INT,
    strength INT,
    image_path VARCHAR(255)
);

insert into cards (card_id, strength, image_path) values (1, 1, 'images/1.png');
insert into cards (card_id, strength, image_path) values (2, 2, 'images/2.png');
insert into cards (card_id, strength, image_path) values (3, 3, 'images/3.png');
insert into cards (card_id, strength, image_path) values (4, 4, 'images/4.png');
insert into cards (card_id, strength, image_path) values (5, 5, 'images/5.png');





-- 自販機ガチャ -- 

-- 飲料の情報 --
CREATE TABLE IF NOT EXISTS drinks (
    drink_id INT,
    drink_name VARCHAR(255),
    image_path VARCHAR(255),
    weight INT
);

insert into drinks (drink_id, drink_name, image_path, weight) values (1, 'Coke', 'images/Drink_4.png', 10);
insert into drinks (drink_id, drink_name, image_path, weight) values (2, 'Tea', 'images/Drink_1.png', 50);
insert into drinks (drink_id, drink_name, image_path, weight) values (4, 'Cider', 'images/Drink_2.png', 100);
insert into drinks (drink_id, drink_name, image_path, weight) values (5, 'Coffee', 'images/Drink_5.png', 300);
insert into drinks (drink_id, drink_name, image_path, weight) values (6, 'BlackTea', 'images/Drink_3.png', 400);

-- プレイヤーの所持している飲料の情報 --
CREATE TABLE IF NOT EXISTS player_drinks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    drink_id INT,
    number_of_drink INT
);

-- ガチャの履歴
CREATE TABLE IF NOT EXISTS drink_gacha_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    drink_id INT
);






-- カードガチャ -- 

-- カードの情報 --
CREATE TABLE IF NOT EXISTS character_cards (
    card_id INT,
    card_rarity VARCHAR(255),
    card_name VARCHAR(255),
    image_path VARCHAR(255),
    weight INT
);

insert into character_cards (card_id, card_rarity, card_name, image_path, weight) values (1, 'SSR', 'King', 'images/piece_king.png', 10);
insert into character_cards (card_id, card_rarity, card_name, image_path, weight) values (2, 'SSR', 'Queen', 'images/piece_queen.png', 50);
insert into character_cards (card_id, card_rarity, card_name, image_path, weight) values (3, 'SR', 'Bishop', 'images/piece_bishop.png', 150);
insert into character_cards (card_id, card_rarity, card_name, image_path, weight) values (4, 'R', 'Knight', 'images/piece_knight.png', 200);
insert into character_cards (card_id, card_rarity, card_name, image_path, weight) values (5, 'N', 'Pawn', 'images/piece_pawn.png', 300);


-- プレイヤーの所持しているカードの情報 --
CREATE TABLE IF NOT EXISTS player_cards (
    card_id INT,
    card_number INT -- 枚数
);

-- ガチャの履歴
CREATE TABLE IF NOT EXISTS card_gacha_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    card_id INT
);

-- カードの編成情報
CREATE TABLE IF NOT EXISTS card_formation (
    card_id_1 INT,
    card_id_2 INT,
    card_id_3 INT,
    card_id_4 INT,
    card_id_5 INT
);




-- Unityガチャ

-- 飲料の情報 --
CREATE TABLE IF NOT EXISTS unity_drinks (
    drink_id INT,
    drink_name VARCHAR(255),
    image_path VARCHAR(255),
    weight INT
);

insert into unity_drinks (drink_id, drink_name, image_path, weight) values (1, 'Coke', 'images/Drink_4.png', 10);
insert into unity_drinks (drink_id, drink_name, image_path, weight) values (2, 'Tea', 'images/Drink_1.png', 50);
insert into unity_drinks (drink_id, drink_name, image_path, weight) values (3, 'Cider', 'images/Drink_2.png', 100);
insert into unity_drinks (drink_id, drink_name, image_path, weight) values (4, 'Coffee', 'images/Drink_5.png', 300);
insert into unity_drinks (drink_id, drink_name, image_path, weight) values (5, 'BlackTea', 'images/Drink_3.png', 400);

-- プレイヤーの所持している飲料の情報
CREATE TABLE IF NOT EXISTS unity_player_drinks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    drink_id INT,
    number_of_drink INT
);

-- ガチャの履歴
CREATE TABLE IF NOT EXISTS unity_gacha_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    drink_id INT
);