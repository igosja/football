<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['role_name']))
{
    $role_name          = $_POST['role_name'];
    $role_description   = $_POST['role_description'];
    $role_short         = $_POST['role_short'];

    $sql = "INSERT INTO `role`
            SET `role_name`=?,
                `role_short`=?,
                `role_description`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('sss', $role_name, $role_short, $role_description);
    $prepare->execute();
    $prepare->close();

    redirect('role_list.php');
}

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');