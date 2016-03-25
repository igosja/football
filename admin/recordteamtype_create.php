<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

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
}

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');