<?php
$images = $_FILES['images'];

foreach ($images as $image) {
    var_dump($image);
}
?>