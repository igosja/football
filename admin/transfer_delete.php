<?php

include (__DIR__ . '/../include/include.php');

if (!isset($_GET['num']))
{
    redirect('transfer_list.php');
}

$num_get = (int) $_GET['num'];

$sql = "DELETE FROM `transfer`
        WHERE `transfer_id`='$num_get'
        LIMIT 1";
$mysqli->query($sql);

redirect('transfer_list.php');