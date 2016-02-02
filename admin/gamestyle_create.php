<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

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

    exit;
}

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');