<?php

$header_login_button = ob_include(__DIR__ . '/../../templates/auth/header_login-buttons.phtml',[]);
$header = ob_include(__DIR__ . '/../../templates/header.phtml', ['some_block' => $header_login_button]);

$html = ob_include(__DIR__ . '/../../templates/auth/signup.phtml', []);

$container = ob_include(__DIR__ . '/../../templates/auth/auth_container.phtml', ['header' => $header, 'html' => $html]);

if (!$_POST) {

    echo ob_include(__DIR__ . '/../../templates/doctype.phtml', 
[
    'icon_path' => '../../svg/x-icon/travel.svg',
    'css_path' => '../../css/main.css', 
    'container' => $container, 
    'scripts' => ['../../JS/auth_script/signup.js']
]);
}
else 
{
    $db = $GLOBALS['connect']->connect;

    foreach($_POST as $key => $value) {
       $_POST[$key] = $db->escapeString(trim($_POST[$key]));
    }
    
    $response = array(
        'success' => true,
        'message' => 'Good'
    );

    if(count($_POST) <= 2) {
        
        if(!empty($_POST['login'])) {
            $login = $_POST['login'];

            $sql_search = "SELECT `user_login` FROM `users_table` WHERE `user_login` = '$login'";
            $result = $db->query($sql_search)->fetchArray(SQLITE3_ASSOC);
            if($result) {
                $response['success'] = false;
                $response['message'] = 'login';
            }
        }
        if(!empty($_POST['email'])) {
            if(preg_match("/@/", $_POST['email']) == 0) {
                $response['success'] = false;
                $response['message'] = 'email';
            }
            else
            {
                $email = $_POST['email'];

                $sql_search = "SELECT `user_email` FROM `users_table` WHERE `user_email` = '$email'";
                $result = $db->query($sql_search)->fetchArray(SQLITE3_ASSOC);
                if($result) {
                    $response['success'] = false;
                    $response['message'] = 'email';
                }  
            }
        }
        if(!empty($_POST['password']) && !empty($_POST['password_confirm']) && $_POST['password'] != $_POST['password_confirm']) {
            $response['success'] = false;
            $response['message'] = 'password';
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
   
    if(count($_POST) > 2) {
        $names = [];
        foreach($_POST as $key => $value) {

            if($key == 'login') {
                $check_login = true;
                if($_POST[$key] == ''){
                    $response['success'] = false;
                    array_push($names, $key);
                    $check_login = false;
                }
                if($check_login) {
                    $login = $_POST[$key];

                    $sql_search = "SELECT `user_login` FROM `users_table` WHERE `user_login` = '$login'";
                    $result = $db->query($sql_search)->fetchArray(SQLITE3_ASSOC);
                    if($result) {
                        $response['success'] = false;
                        array_push($names, $key);
                    }
                }
            }
            if($key == 'email'){
                $check_email = true;
                if($_POST[$key] == '') {
                    $response['success'] = false;
                    array_push($names, $key);
                    $check_email = false;
                }
                elseif($check_email && preg_match("/@/", $_POST[$key]) == 0) 
                {
                    $response['success'] = false;
                    array_push($names, $key);
                    $check_email = false; 
                }
                if($check_email) {
                    $email = $_POST[$key];

                    $sql_search = "SELECT `user_email` FROM `users_table` WHERE `user_email` = '$email'";
                    $result = $db->query($sql_search)->fetchArray(SQLITE3_ASSOC);
                    if($result) {
                        $response['success'] = false;
                        array_push($names, $key);
                    }
                }
            }
            if($key == 'password'){
                $check_pass = true;
                if($_POST[$key] != $_POST['password_confirm']) {
                    $response['success'] = false;
                    array_push($names, $key);
                    array_push($names, 'password_confirm');
                    $check_pass = false;
                }
                elseif($check_pass && strlen($_POST[$key]) < 5) 
                {
                    $response['success'] = false;
                    array_push($names, $key);
                    array_push($names, 'password_confirm');
                }
            }
            if($key == 'checkbox') {
                if($_POST[$key] == 'false') {
                    $response['success'] = false;
                    array_push($names, $key);
                }
            }
        }
        $response['message'] = $names;

        if(!$response['success']) {
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        else 
        {   
            $login = $_POST['login'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $name = $_POST['user_name'] ?? 'Your Name';
            $surname = $_POST['user_surname'] ?? 'Your Surname';
            $country = $_POST['country'] ?? 'Your Country';
            $slogan = $_POST['slogan'] ?? 'Your Slogan';


            $sql_insert_new_user = "INSERT INTO `users_table` 
            (`user_login`,`user_email`,`user_password`,`user_name`,`user_surname`,`user_country`,`user_slogan`)
            VALUES 
            ('$login', '$email', '$password', '$name', '$surname', '$country', '$slogan')";

            $db->query($sql_insert_new_user);

            $response['message'] = $_POST;
            echo json_encode($response);
        }
    }
}
