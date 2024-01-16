<?php
session_start();

require __DIR__ . '/vendor/autoload.php';
use \App\Image\Resize;

$images = $_FILES['imgs'];
$convert_images_to_webp = $_POST['webp'] ?? null;
$upload_dir = __DIR__ . "/uploads/";

$allowed_extensions = ['jpg', 'png', 'webp', 'gif', 'jpeg'];
$not_allowed_images = [];


if(empty($images) || $images == null) {
    $_SESSION['warning'] = 'Nenhuma imagem carregada.';
    return redirectBack();
}

if(in_array('', $images['name'])) {
    $_SESSION['error'] = 'Uma ou mais imagens não foram carregadas!';
    return redirectBack();
}

$images_info = [];

foreach ($images['name'] as $index => $file_name) {
    $target_path =  $upload_dir . $file_name;

    $file_path = $images['tmp_name'][$index];
    $file_size = $images['size'][$index];

    $check_extension = explode('.', $file_name);
    if(!in_array(end($check_extension), $allowed_extensions)) {
        $not_allowed_images[] = $file_name;
        continue;
    }

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
        // echo "File $file_name has been uploaded successfully.<br>";
    } else {
        // echo "Error uploading file $file_name.<br>";
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

    // $obResize->resize(50, -1);

    $obResize->save($path_image, 90, $type);
}

if(!empty($not_allowed_images)) {
    $_SESSION['warning'] = 'Tipo de arquivo de arquivo não permitido encontrado: ';
    foreach($not_allowed_images as $image) {
        $_SESSION['warning'] .= "$image, ";
    }
}

$_SESSION['success'] = 'Imagens convertidas com sucesso!';
header('Location: ' . $_SERVER['HTTP_REFERER']);
