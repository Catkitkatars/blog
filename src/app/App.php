<?php 

namespace app;

class App {

    private $handlers_dir;

    public function __construct($handlers_dir) {

        $this->handlers_dir = $handlers_dir;

    }

    public function run($path, $param) {
        // require "";
    }
}


// GET /posts/123
// POST /posts 

// http/posts/get.php
// http/postp/post.php

// GET /posts/123/edit
// http/posts/edit/get.php 