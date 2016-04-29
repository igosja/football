<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];

    setcookie('referal', $num_get, time() + 60*60*24*7);

    redirect('index.php');
}

$social_array = f_igosja_social_array();

include (__DIR__ . '/view/main.php');