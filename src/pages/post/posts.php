<?php
require __DIR__ . '/../../../init.php';
require __DIR__ . '/../../../vendor/autoload.php';


function init_filter(array $post):array {
    $filter = [
        "sort" => $post['radio_option'] ?? NULL,
        "author" => $post['author_post'] ?? NULL,
        "title" => $post["titile_post"] ?? NULL
    ];

    return $filter;
}

$posts = new app\Post($GLOBALS['connect']->connect);

$response = array(
    'success' => true,
);

if($_POST) {
    $filter = init_filter($_POST);

    $all_posts = $posts->render(__DIR__ . '/../posts/post.phtml', $posts->get_all($filter));

    $response['success'] = true;
    $response['content'] = $all_posts;
}

header('Content-Type: application/json');
echo json_encode($response);