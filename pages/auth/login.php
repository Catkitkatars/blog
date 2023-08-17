<?php 

$header_login_button = ob_include(__DIR__ . '/../../templates/auth/header_login-buttons.phtml',[]);
$header = ob_include(__DIR__ . '/../../templates/header.phtml', ['some_block' => $header_login_button]);

$html = ob_include(__DIR__ . '/../../templates/auth/login.phtml', []);

$container = ob_include(__DIR__ . '/../../templates/auth/auth_container.phtml', ['header' => $header, 'html' => $html]);


if (!$_POST) {
    echo ob_include(__DIR__ . '/../../templates/doctype.phtml', 
    [
        'icon_path' => '../../svg/x-icon/travel.svg',
        'css_path' => '../../css/main.css', 
        'container' => $container, 
        'scripts' => ['../../JS/auth_script/login.js']
    ]);
}
else 
{
    $db = $GLOBALS['connect']->connect;

    $response = array(
        'success' => true,
        'message' => 'ok'
    );

    $login = trim($db->escapeString($_POST['login'])) ?? false;
    $password = trim($db->escapeString($_POST['password'])) ?? false;

    if(!$login || !$password) {
        $response['success'] = false;
        $response['message'] = ['login', 'password'];
    }
    if($login && $password) {
        $sql_search = "SELECT `user_login`, `user_password`
                        FROM  `users_table`
                        WHERE `user_login` = '$login' AND `user_password` = '$password'";

        $result = $db->query($sql_search)->fetchArray(SQLITE3_ASSOC);

        if($result) {
            $response['success'] = true;
            $_SESSION['login'] = $login;
        }
        else 
        {
            $response['success'] = false;
            $response['message'] = ['login', 'password'];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}