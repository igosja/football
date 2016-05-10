<?php

include (__DIR__ . '/../include/include.php');

if (isset($_POST['horizontalmenuchapter_name']))
{
    $horizontalmenuchapter_name = $_POST['horizontalmenuchapter_name'];

    $sql = "INSERT INTO `horizontalmenuchapter`
            SET `horizontalmenuchapter_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $horizontalmenuchapter_name);
    $prepare->execute();
    $prepare->close();

    redirect('horizontalmenuchapter_list.php');
}

include (__DIR__ . '/../view/admin_main.php');