<?php

include (__DIR__ . '/../include/include.php');

if (isset($_POST['gamestyle_name']))
{
    $gamestyle_name          = $_POST['gamestyle_name'];
    $gamestyle_description   = $_POST['gamestyle_description'];

    $sql = "INSERT INTO `gamestyle`
            SET `gamestyle_name`=?,
                `gamestyle_description`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $gamestyle_name, $gamestyle_description);
    $prepare->execute();
    $prepare->close();

    redirect('gamestyle_list.php');
}

include (__DIR__ . '/../view/admin_main.php');