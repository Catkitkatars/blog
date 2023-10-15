<?php 
use classes\Post; 

if (!$_POST) {
    $header_login_auth = ob_include('templates/auth/header_login-auth.phtml', ['login' => $_SESSION['login']]);
    $header = ob_include('templates/header.phtml', ['some_block' => $header_login_auth]);

    $html = ob_include('templates/post/post_form_add.phtml', []);
    $container = ob_include('templates/post/post_container_add.phtml', ['header' => $header, 'html' => $html]);

    echo ob_include('templates/doctype.phtml', 
                    ['icon_path' => '/svg/x-icon/travel.svg',
                    'css_path' => '/css/main.css', 
                    'container' => $container, 
                    'scripts' => ['/JS/post_script/input_text_counter.js', '/JS/post_script/img_actions.js', '/JS/post_script/img_viewing.js']]);
}
else 
{

    $datas = [];

    $datas['user'] = $_SESSION['login'] ?? NULL;
    $datas['title'] = $_POST['title'] ?? NULL;
    $datas['text'] = $_POST['text'] ?? NULL;
    $datas['img'] = $_POST['uploaded_files'] ?? NULL;

    foreach($datas as $data) {
        if(!$data){
            header('Content-Type: application/json');
            echo json_encode($request);
            die();
        }
    }

    $path = '/../img/users_posts/';
    $post = new Post($GLOBALS['connect']->connect);
    $a = $post->add_new($datas, $path);


    header('Content-Type: application/json');
    echo json_encode($a);
}

