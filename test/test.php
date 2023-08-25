<?php

use classes\Post;

$db = new SQLite3('database/main.db');
$date = new DateTime();

$now = $date->format('Y-m-d H:i');

$sql_create_post_table = "CREATE TABLE posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name text, 
    text text,
    pictures text,
    user_name text,
    date_create text)";

$sql_insert_post_table = "INSERT INTO `posts` (`name`, `text`, `pictures`, `user_name`, `date_create`) 
VALUES ('Experience in Canada', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab quod nulla vel vitae quasi dicta veritatis ducimus deserunt 
libero aspernatur optio corrupti voluptates, doloribus omnis, assumenda voluptate mollitia, fuga delectus explicabo distinctio. Aspernatur ut,
 provident iste deleniti enim consequuntur fugiat laboriosam, officia officiis, natus nobis maxime optio excepturi mollitia?', 'IsJswmNAJBV7ArL0oGXF.jpg, 4oIg5WBe0FVtLXDMbjHP.jpg', 'Daddy', '$now')";



$sql_select_all_post_table = "SELECT * FROM `posts`";

$sql_select_from_date = "SELECT * FROM `post_table` 
                        ORDER BY `date_create` ASC";

$sql_delete_post_table = "DELETE FROM `posts` WHERE `id` = '2'";


// USERS TABLE ===========================================

$sql_create_users_table = 
    "CREATE TABLE users_table (
    user_id integer primary key autoincrement,
    user_login text,
    user_email text,
    user_password text, 
    user_name text,
    user_surname text,
    user_country text,
    user_slogan text)";

$sql_insert_user_in_users_table = 
    "INSERT INTO `users_table` (`user_login`,`user_email`,`user_password`,`user_name`,`user_surname`,`user_country`,`user_slogan`)
    VALUES ('Alex123', 'alex123@mail.com', '123456', 'Alex', 'Smith', 'Canada', 'the world is mine!')";



$sql_select_all_from_users_table = "SELECT * FROM `users_table`";

// $db->query($sql_delete_post_table);
// $db->query($sql_insert_user_in_users_table);
$result = $db->query($sql_select_all_post_table);
while($elem = $result->fetchArray(SQLITE3_ASSOC)){
    var_dump($elem);
    echo '<br><br>';
}



//========================================================



// $db->query($sql_create_post_table);
// $db->query($sql_insert_post_table);
// $result = $db->query($sql_select_all_post_table);

// while($elem = $result->fetchArray(SQLITE3_ASSOC)) {
//     var_dump($elem);
// }



// $a = empty($email) || preg_match("/^\S+@\S+\.\S+$/", $email);


// require __DIR__ . '/../vendor/autoload.php';
// require __DIR__ . '/../init.php';

// $filter = [
//     "sort" => "last_added",
//     "author" => NULL,
//     "title" => 'Tur'
// ];

// $posts = new Post($GLOBALS['connect']->connect);

// var_dump($posts->get_all($filter));
