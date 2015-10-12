<?php

include ('../include/include.php');

if (isset($_POST['statusrent_name']))
{
    $statusrent_name = $_POST['statusrent_name'];

    $sql = "INSERT INTO `statusrent`
            SET `statusrent_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $statusrent_name);
    $prepare->execute();
    $prepare->close();

    redirect('statusrent_list.php');

    exit;
}

$smarty->display('admin_main.html');