<?php

namespace App\Image;

class Resize {
    private $image;
    private $type;

    public function __construct($file) {
        $this->image = imagecreatefromstring(file_get_contents($file));

        $info = pathinfo($file);
        $this->type = $info['extension'] == 'jpg' ? 'jpeg' : $info['extension']; 
    }

    public function resize($new_width, $new_height = -1, $type = 'percentage') {

        $this->image = imagescale($this->image, $new_width, $new_height);
    }

    public function print($quality = 100) {
        header('Content-Type: image/' . $this->type);
        $this->output(null, $quality);
        exit();
    }

    public function save($local_file, $quality = 100, $type = null) {
        $this->output($local_file, $quality, $type);
    }

    private function output($local_file, $quality = 100, $type = null) {
        $this->type = $type ?? $this->type;
        
        switch($this->type) {
            case 'jpeg':
                imagejpeg($this->image, $local_file, $quality);
                break;
            case 'jpg':
                imagejpeg($this->image, $local_file, $quality);
                break;

            case 'png':
                imagepng($this->image, $local_file, 10 * ($quality/100));
                break;

            case 'bmp':
                imagewbmp($this->image, $local_file, $quality);
                break;

            case 'gif':
                imagegif($this->image, $local_file);
                break;
            
            case 'webp':
                imagepalettetotruecolor($this->image);
                imagewebp($this->image, $local_file, $quality);
                break;
        }
        imagedestroy($this->image);
    }
}