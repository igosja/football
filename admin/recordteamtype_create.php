<?php

include ('../include/include.php');

if (isset($_POST['recordteamtype_name']))
{
    $recordteamtype_name = $_POST['recordteamtype_name'];

    $sql = "INSERT INTO `recordteamtype`
            SET `recordteamtype_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $recordteamtype_name);
    $prepare->execute();
    $prepare->close();

    redirect('recordteamtype_list.php');

    exit;
}

$smarty->display('admin_main.html');