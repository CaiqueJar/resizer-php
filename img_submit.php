<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Image\Resize;


$images = $_FILES['imgs'];
$upload_dir = 'uploads/';


$images_names = [];

for ($i = 0; $i < count($images["name"]); $i++) {
    $filename = basename($images["name"][$i]);
    $images_names[] = $filename;
    $target_path = $upload_dir . $filename;

    // Move the file from the temporary directory to the target directory
    if (move_uploaded_file($images["tmp_name"][$i], $target_path)) {
        echo "File $filename has been uploaded successfully.<br>";
    } else {
        echo "Error uploading file $filename.<br>";
    }
}

foreach ($images_names as $filename) {
    $obResize = new Resize(__DIR__ . "/{$upload_dir}{$filename}");
    $obResize->resize(100, -1);
    
    // $obResize->print(100);
    
    $obResize->save(__DIR__."/img/{$filename}", 50);
}
