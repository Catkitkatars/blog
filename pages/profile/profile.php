<?php 

require '../../functions/ob_include.php';

use function functions\ob_include;

$header = ob_include(__DIR__ . '/../../templates/header.phtml', ['some_block' => '']);
$profile = ob_include('../../templates/profile/profile.phtml', []);
$posts = '';
$container = ob_include('../../templates/profile/profile_container.phtml', 
                        ['header' => $header, 'profile' => $profile, 'html' => $posts]);

echo ob_include('../../templates/doctype.phtml', 
    ['icon_path' => '../../svg/x-icon/travel.svg',
    'css_path' => '../../css/main.css', 
    'container' => $container, 
    'scripts' => []]);
