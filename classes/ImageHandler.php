<?php 
namespace classes;

use Imagick;

class ImageHandler {

    public $path;
    public $img_names = [];
    public $image_magick;

    public function __construct($path) {
        $this->path = $path;
        $this->image_magick = new Imagick();
    }   

    public function process_and_save($img, $id) {
        $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $img));
    
        $this->image_magick->readImageBlob($image_data);
        $this->image_magick->setImageCompressionQuality(70);

        $dir = NULL;

        if($id) {
            $dir = __DIR__ . $this->path . '/' . $id;
        }
        else 
        {
            $dir = __DIR__ . $this->path;
        }

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
            $dir = realpath($dir);
        }
        else 
        {
            $dir = realpath($dir); 
        }

        $img_name = $this->random_name(20) . '.jpg';

        $img_dir = $dir . '/' . $img_name;

        $this->image_magick->writeImage($img_dir);

        $this->image_magick->clear();
        $this->image_magick->destroy();
        array_push($this->img_names, $img_name);
    } 

    private function random_name($length) {
        $str = random_bytes($length);
        $str = base64_encode($str);
        $str = str_replace(["+", "/", "="], "", $str);
        $str = substr($str, 0, $length);
        return $str;
    }
}