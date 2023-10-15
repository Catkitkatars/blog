<?php
namespace app;

use DateTime;

class Post {

    private $connect;

    public function __construct($connect) {
        $this->connect = $connect;
    }

    public function get_all($filter) {
        $sql = $this->filter_handler($filter);
        
        $posts = [];

        $selected_posts = $this->connect->query($sql);

        while($post = $selected_posts->fetchArray(SQLITE3_ASSOC)) {
            array_push($posts, $post);
        }

        return $posts;
    }
    public function get_one_post($id) {
        $id = $this->connect->escapeString(trim($id));

        $sql = "SELECT * FROM `posts` WHERE `id` = $id";

        $selected_post = $this->connect->query($sql)->fetchArray(SQLITE3_ASSOC);

        return $selected_post;
    }

    private function filter_handler($filter) {
        $where = [];
        $order_by = '';

        if($filter['sort'] != NULL) {
            if($filter['sort'] == 'last_added') {
                $order_by = " ORDER BY `date_create` DESC";
            }
            elseif($filter['sort'] == 'first_added') {
                $order_by = " ORDER BY `date_create` ASC";
            }
        }
        if($filter["author"] != NULL) {
            $sql = sprintf(' LOWER(`user_name`) = \'%s\'', $this->connect->escapeString(trim(strtolower($filter['author']))));
            array_push($where, $sql);
        }
        if($filter["title"] != NULL) {
            $sql = sprintf(' LOWER(`name`) LIKE \'%%%s%%\'', $this->connect->escapeString(trim(strtolower($filter['title']))));
            array_push($where, $sql);
        }

        $sql = "SELECT * FROM `posts`";

        if($where) {
            $sql .= " WHERE" . implode(" AND ", $where);
        }
        if($order_by) {
            $sql .= $order_by;
        }

        return $sql;
    }

    public function add_new($datas, $path){
        $user = $this->connect->escapeString(trim($datas['user']));
        $title = $this->connect->escapeString(trim($datas['title']));
        $text = $this->connect->escapeString(trim($datas['text']));

        $date = new DateTime();
        $now = $date->format('Y-m-d H:i');

        $this->connect->exec('BEGIN');

        $sql = "INSERT INTO `posts` (`name`, `text`, `user_name`, `date_create`) 
        VALUES ('$title', '$text', '$user', '$now')";

        $this->connect->exec($sql);

        $inserted_id = $this->connect->lastInsertRowID();

        $this->connect->exec('COMMIT');

        $path = $path . $user;
        $image_handler = new ImageHandler($path);
        $imgs = '';

        foreach($datas['img'] as $img) {
            $image_handler->process_and_save($img, $inserted_id);
        }

        $imgs = implode(', ',$image_handler->img_names);

        $sql_insert_img = "UPDATE posts SET pictures = '$imgs' WHERE id = '$inserted_id'";

        $this->connect->query($sql_insert_img);
    }

    public function delete_post() {

    }
    public function edit_post() {

    }
    public function render($template_path, $posts) {
        $post_array = [];

        foreach ($posts as $key => $value) {
            $imgs = array_reverse(explode(', ',$posts[$key]['pictures']));

            $imgs_html = '';

            foreach($imgs as $img) {
                $imgs_html .= ob_include(__DIR__ . '/../pages/posts/slides.phtml', 
                ['user_name' => $posts[$key]['user_name'],
                'post_id' => $posts[$key]['id'],
                'img' => $img]);
            }


            $html = ob_include($template_path, 
            ['post_id' => $posts[$key]['id'], 
            'post_name' =>$posts[$key]['name'], 
            'post_text' => $posts[$key]['text'],
            'slides' => $imgs_html,
            'user_name' => $posts[$key]['user_name'], 
            'date_create' => $posts[$key]['date_create'] 
            ]);
            array_push($post_array, $html);
        }

        return $post_array;
    }

}

// разобраться со случаем когда мы в качествте title передаем %/ например когда передаем 100%