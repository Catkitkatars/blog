<?php
require_once __DIR__ . '/vendor/autoload.php';

$GLOBALS['config'] = require 'config.php';
$GLOBALS['connect'] = new app\Connect($GLOBALS['config']['sqlite']['path']);