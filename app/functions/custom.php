<?php

function dd($dump) {
    echo "<pre>";
    var_dump($dump);
    echo "</pre>";
    die();
}
function redirectBack() {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
