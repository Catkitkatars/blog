<?php
namespace app;

use SQLite3;

class Connect {
    public $connect;

    public function __construct($path) {
        $this->connect = new SQLite3($path);
    }
}