<?php

include (__DIR__ . '/../include/include.php');

if (isset($_POST['stadiumquality_name']))
{
    $stadiumquality_name = $_POST['stadiumquality_name'];

    $sql = "INSERT INTO `stadiumquality`
            SET `stadiumquality_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $stadiumquality_name);
    $prepare->execute();
    $prepare->close();

    redirect('stadiumquality_list.php');
}

include (__DIR__ . '/../view/admin_main.php');