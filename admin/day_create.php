<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['day_id']))
{
    $sql = "INSERT INTO `day`
            SET `day_id`=NULL;";
    $mysqli->query($sql);

    redirect('day_list.php');

    exit;
}

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');