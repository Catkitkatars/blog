<?php

if(!empty($_SESSION['login'])) {
    $header_login_auth = ob_include('templates/auth/header_login-auth.phtml', ['login' => $_SESSION['login']]);
    $header = ob_include('templates/header.phtml', ['some_block' => $header_login_auth]);
    $button_add = ob_include('templates/post/post_button_add.phtml',[]);
    $container = ob_include('templates/post/post_main_container.phtml', ['header' => $header, 'button_add' => $button_add, 'html' => '']);
}
else 
{
    $header_login_button = ob_include('templates/auth/header_login-buttons.phtml',[]);
    $header = ob_include('templates/header.phtml', ['some_block' => $header_login_button]);
    $container = ob_include('templates/post/post_main_container.phtml', ['header' => $header, 'button_add' => '', 'html' => '']);
}


echo ob_include('templates/doctype.phtml', ['icon_path' => 'svg/x-icon/travel.svg','css_path' => 'css/main.css', 'container' => $container, 'scripts' => ['JS/post_script/post.js']]);
