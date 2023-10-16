<?php

if(!empty($_SESSION['login'])) {
    $header_login_auth = ob_include(__DIR__ . '/auth/header_login-auth.phtml', ['login' => $_SESSION['login']]);
    $header = ob_include(__DIR__ . '/index/header.phtml', ['some_block' => $header_login_auth]);
    $button_add = ob_include(__DIR__ . '/posts/post_button_add.phtml',[]);

    $container = ob_include(__DIR__ . '/posts/post_main_container.phtml', ['header' => $header, 'button_add' => $button_add, 'html' => '']);
}
else 
{
    $header_login_button = ob_include(__DIR__ . '/auth/header_login-buttons.phtml',[]);
    $header = ob_include(__DIR__ . '/index/header.phtml', ['some_block' => $header_login_button]);

    $container = ob_include(__DIR__ . '/posts/post_main_container.phtml', ['header' => $header, 'button_add' => '', 'html' => '']);
}


echo ob_include(__DIR__ . '/index/doctype.phtml', 
                ['icon_path' => 'svg/x-icon/travel.svg',
                'css_path' => 'css/main.css', 
                'container' => $container, 
                'scripts' => [
                            'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js',
                            'JS/post_script/post.js']]);
