<?php

include ('../include/include.php');

if (isset($_POST['statustransfer_name']))
{
    $statustransfer_name = $_POST['statustransfer_name'];

    $sql = "INSERT INTO `statustransfer`
            SET `statustransfer_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $statustransfer_name);
    $prepare->execute();
    $prepare->close();

    redirect('statustransfer_list.php');

    exit;
}

$smarty->display('admin_main.html');