<?php

include (__DIR__ . '/../include/include.php');

if (isset($_POST['gender_name']))
{
    $gender_name = $_POST['gender_name'];

    $sql = "INSERT INTO `gender`
            SET `gender_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $gender_name);
    $prepare->execute();
    $prepare->close();

    $gender_id = $mysqli->insert_id;

    redirect('gender_list.php');
}

include (__DIR__ . '/../view/admin_main.php');