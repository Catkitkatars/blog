<?php 
use app\Post; 

if (!$_POST) {
    $header_login_auth = ob_include(__DIR__ . '/../auth/header_login-auth.phtml', ['login' => $_SESSION['login']]);
    $header = ob_include(__DIR__ . '/../index/header.phtml', ['some_block' => $header_login_auth]);

    $html = ob_include(__DIR__ . '/post_form_add.phtml', []);
    $container = ob_include(__DIR__ . '/post_container_add.phtml', ['header' => $header, 'html' => $html]);

    echo ob_include(__DIR__ . '/../index/doctype.phtml', 
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

    $path = '/../../web/img/users_posts/';
    $post = new Post($GLOBALS['connect']->connect);
    $a = $post->add_new($datas, $path);
    // Переход на добавленный пост

    header('Content-Type: application/json');
    echo json_encode($a);
}

