<?php

include (__DIR__ . '/../include/include.php');

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
}

include (__DIR__ . '/../view/admin_main.php');