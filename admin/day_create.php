<?php

include ('../include/include.php');

if (isset($_POST['day_id']))
{
    $sql = "INSERT INTO `day`
            SET `day_id`=NULL;";
    $mysqli->query($sql);

    redirect('day_list.php');

    exit;
}

$smarty->display('admin_main.html');