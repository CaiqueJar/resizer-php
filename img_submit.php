<?php

session_start();

require __DIR__ . '/vendor/autoload.php';
use \App\Image\Resize;



if(!isset($_POST['submit'])) {
    $_SESSION['error'] = 'Algo deu errado!';
    return redirectBack();
}

$images = $_FILES['imgs'];
$convert_images_to_webp = $_POST['webp'] ?? null;
$compress_images = $_POST['compress'] ?? null;
$upload_dir = __DIR__ . "/uploads/";
$canZIP = $_POST['zip'] ?? false;

$allowed_extensions = ['jpg', 'png', 'webp', 'gif', 'jpeg', 'PNG', 'jfif'];
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

// Format images names to receive an id
foreach($convert_images_to_webp as $key => $value) {
    $file = explode('/', $value);
    $file[1] = pathinfo($file[1], PATHINFO_FILENAME) . "-" . $key . "." . pathinfo($file[1], PATHINFO_EXTENSION);
    $file = implode("/", $file);
    $convert_images_to_webp[$key] = $file;
}

foreach ($images['name'] as $index => $file_name) {
    $file_name = pathinfo($file_name, PATHINFO_FILENAME) . "-" . $index . "." . pathinfo($file_name, PATHINFO_EXTENSION);

    $target_path =  $upload_dir . $file_name;

    $file_path = $images['tmp_name'][$index];
    $file_size = $images['size'][$index];

    $check_extension = explode('.', $file_name);
    if(!in_array(end($check_extension), $allowed_extensions)) {
        $not_allowed_images[] = $file_name;
        continue;
    }
    $convert_to_webp = !empty($convert_images_to_webp) ? in_array("$file_size/$file_name", $convert_images_to_webp) : false;

    if($convert_images_to_webp) {
        $convert_to_webp = in_array("$file_size/$file_name", $convert_images_to_webp);
    }
    if($compress_images) {
        $compress = in_array("$file_size/$file_name", $compress_images);
    }

    $image_info = [
        'file_name' => pathinfo($file_name, PATHINFO_FILENAME),
        'file_extension' => pathinfo($file_name, PATHINFO_EXTENSION),
        'target_path' => $target_path,
        'convert_to_webp' => $convert_to_webp ?? false,
        'compress' => $compress ?? false,
    ];

    $images_info[] = $image_info;

    move_uploaded_file($images["tmp_name"][$index], $target_path);
}
if ($canZIP) {
    $zip = new ZipArchive;
    $tmp_file = __DIR__ . "/zips/images.zip";
}
foreach ($images_info as $info) {
    $file_complete_name = $info['file_name'] . '.' . $info['file_extension'];
    $old_file_name = $file_complete_name;
    $type = $info['file_extension'];
    $quality = 100;

    if($info['convert_to_webp']) {
        $type = 'webp';
        $file_complete_name = $info['file_name'] . '.webp';
    }
    if($info['compress']) {
        $quality = 90;
    }

    $path_image = __DIR__."/img/{$file_complete_name}";
    $obResize = new Resize($info['target_path']);

    // $obResize->resize(50, -1);

    $obResize->save($path_image, $quality, $type);
    if ($canZIP) {
        if ($zip->open($tmp_file, ZipArchive::CREATE)) {
            $zip->addFile($path_image, $file_complete_name);
        }
    }
    unlink(__DIR__ . "/uploads/" . $old_file_name);
}

if ($canZIP) {
    $zip->close();
    $_SESSION['zip'] = $tmp_file;
}

if(!empty($not_allowed_images)) {
    $_SESSION['warning'] = 'Tipo de arquivo de arquivo não permitido encontrado: ';
    foreach($not_allowed_images as $image) {
        $_SESSION['warning'] .= "$image, ";
    }
}

$_SESSION['success'] = 'Imagens convertidas com sucesso!';
return redirectBack();