<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Image\Resize;

$images = $_FILES['imgs'];
$convert_images_to_webp = $_POST['webp'] ?? null;
$upload_dir = 'uploads/';


$images_info = [];

foreach ($images['name'] as $index => $file_name) {
    $target_path = __DIR__ . "/" . $upload_dir . $file_name;

    $file_path = $images['tmp_name'][$index];
    $file_size = $images['size'][$index];

    if($convert_images_to_webp) {
        $convert_to_webp = in_array("$file_size/$file_name", $convert_images_to_webp);

    }

    $image_info = [
        'file_name' => pathinfo($file_name, PATHINFO_FILENAME),
        'file_extension' => pathinfo($file_name, PATHINFO_EXTENSION),
        'target_path' => $target_path,
        'convert_to_webp' => $convert_to_webp ?? false,
    ];
    $images_info[] = $image_info;

    if (move_uploaded_file($images["tmp_name"][$index], $target_path)) {
        echo "File $file_name has been uploaded successfully.<br>";
    } else {
        echo "Error uploading file $file_name.<br>";
    }
}

foreach ($images_info as $info) {
    $file_complete_name = $info['file_name'] . '.' . $info['file_extension'];
    $type = $info['file_extension'];

    if($info['convert_to_webp']) {
        $type = 'webp';
        $file_complete_name = $info['file_name'] . '.webp';
    }

    $path_image = __DIR__."/img/{$file_complete_name}";
    $obResize = new Resize($info['target_path']);
    var_dump($path_image);
    echo "<br>";
    // $obResize->resize(50, -1);

    $obResize->save($path_image, 90, $type);
}
