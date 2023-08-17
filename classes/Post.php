<?php
namespace classes;

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
            $sql = sprintf(' LOWER(`post_name`) LIKE \'%%%s%%\'', $this->connect->escapeString(trim(strtolower($filter['title']))));
            array_push($where, $sql);
        }

        $sql = "SELECT * FROM `post_table`";

        if($where) {
            $sql .= " WHERE" . implode(" AND ", $where);
        }
        if($order_by) {
            $sql .= $order_by;
        }

        return $sql;
    }

    public function add_post($data){

    }
    public function delete_post() {

    }
    public function edit_post() {

    }
    public function render($template_path, $posts) {
        $post_array = [];

        foreach ($posts as $key => $value) {
            $html = ob_include($template_path, 
            ['post_id' => $posts[$key]['id'], 
            'post_name' =>$posts[$key]['post_name'], 
            'post_text' => $posts[$key]['post_text'],
            'user_name' => $posts[$key]['user_name'], 
            'date_create' => $posts[$key]['date_create'] 
            ]);
            array_push($post_array, $html);
        }

        return $post_array;
    }

}

// разобраться со случаем когда мы в качествте title передаем %/ например когда передаем 100%