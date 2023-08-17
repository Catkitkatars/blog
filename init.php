<?php
require_once __DIR__ . '/vendor/autoload.php';

use classes\Connect; 

$GLOBALS['config'] = require 'config.php';
$GLOBALS['connect'] = new Connect($GLOBALS['config']['sqlite']['path']);