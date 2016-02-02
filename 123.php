<?php

include($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$dir    = $_SERVER['DOCUMENT_ROOT'] . '/view/admin';
$files  = scandir($dir);
$files  = array_slice($files, 3);

foreach ($files as $file)
{
    $file_name = explode('.', $file);
    rename($dir . '/' . $file_name[0] . '.' . $file_name[1], $dir . '/' . $file_name[0] . '.php');
}