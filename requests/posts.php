<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../init.php';

use classes\Post;

function init_filter(array $post):array {
    $filter = [
        "sort" => $post['radio_option'] ?? NULL,
        "author" => $post['author_post'] ?? NULL,
        "title" => $post["titile_post"] ?? NULL
    ];

    return $filter;
}

$posts = new Post($GLOBALS['connect']->connect);

$response = array(
    'success' => true,
);

if($_POST) {
    $filter = init_filter($_POST);

    $all_posts = $posts->render('templates/post/post.phtml', $posts->get_all($filter));

    $response['success'] = true;
    $response['content'] = $all_posts;
}

header('Content-Type: application/json');
echo json_encode($response);