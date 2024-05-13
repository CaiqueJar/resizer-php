<?php
session_start();

if(!isset($_SESSION['zip'])) {
    return redirectBack();
}

$tmp_file = $_SESSION["zip"];
unset($_SESSION['zip']);
header('Content-disposition: attachment; filename=images.zip');
header('Content-type: application/zip');
readfile($tmp_file);
unlink($tmp_file);