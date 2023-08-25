<?php 
use classes\Post;

$post = new Post($GLOBALS['connect']->connect);

$post = $post->get_one_post($GLOBALS['config']['GET_ID']);


$imgs = array_reverse(explode(', ', $post['pictures']));

$imgs_html = '';

foreach($imgs as $img) {
    $imgs_html .= ob_include('templates/post/slides.phtml', 
                            ['user_name' => $post['user_name'], 
                            'post_id' => $post['id'], 
                            'img' => $img]);
}


if(!empty($_SESSION['login'])) {
    $header_login_auth = ob_include('templates/auth/header_login-auth.phtml', ['login' => $_SESSION['login']]);
    $header = ob_include('templates/header.phtml', ['some_block' => $header_login_auth]);
    $button_add = ob_include('templates/post/post_button_add.phtml',[]);

    $post = ob_include('templates/post/post_page.phtml', 
                        ['name' => $post["name"],
                        'imgs' =>  $imgs_html, 
                        'user_name' => $post["user_name"], 
                        'text' => $post["text"], 
                        'date_create' => $post["date_create"] , 
                        'id' => $post["id"]]);

    $container = ob_include('templates/post/post_page_container.phtml', ['header' => $header, 'post' => $post]);
}
else 
{
    $header_login_button = ob_include('templates/auth/header_login-buttons.phtml',[]);
    $header = ob_include('templates/header.phtml', ['some_block' => $header_login_button]);

    $post = ob_include('templates/post/post_page.phtml', 
                        ['name' => $post["name"],
                        'imgs' =>  $imgs_html, 
                        'user_name' => $post["user_name"], 
                        'text' => $post["text"], 
                        'date_create' => $post["date_create"] , 
                        'id' => $post["id"]]);

    $container = ob_include('templates/post/post_page_container.phtml', ['header' => $header, 'post' => $post]);
}

echo ob_include('templates/doctype.phtml', 
                [
                'icon_path' => '/svg/x-icon/travel.svg',
                'css_path' => '/css/main.css', 
                'container' => $container, 
                'scripts' => [
                    'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js',
                    '/JS/post_script/slides_for_post_page.js'
                ]
                ]);
