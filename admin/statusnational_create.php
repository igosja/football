<?php

include ('../include/include.php');

if (isset($_POST['statusnational_name']))
{
    $statusnational_name = $_POST['statusnational_name'];

    $sql = "INSERT INTO `statusnational`
            SET `statusnational_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $statusnational_name);
    $prepare->execute();
    $prepare->close();

    redirect('statusnational_list.php');

    exit;
}

$smarty->display('admin_main.html');