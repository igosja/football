<?php

include ('../include/include.php');

if (isset($_POST['stage_name']))
{
    $stage_name = $_POST['stage_name'];

    $sql = "INSERT INTO `stage`
            SET `stage_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $stage_name);
    $prepare->execute();
    $prepare->close();

    redirect('stage_list.php');

    exit;
}

$smarty->display('admin_main.html');