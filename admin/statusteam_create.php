<?php

include ('../include/include.php');

if (isset($_POST['statusteam_name']))
{
    $statusteam_name = $_POST['statusteam_name'];

    $sql = "INSERT INTO `statusteam`
            SET `statusteam_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $statusteam_name);
    $prepare->execute();
    $prepare->close();

    redirect('statusteam_list.php');

    exit;
}

$smarty->display('admin_main.html');