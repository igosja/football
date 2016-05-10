<?php

include (__DIR__ . '/../include/include.php');

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
}

include (__DIR__ . '/../view/admin_main.php');