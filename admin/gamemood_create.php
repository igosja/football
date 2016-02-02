<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['gamemood_name']))
{
    $gamemood_name          = $_POST['gamemood_name'];
    $gamemood_description   = $_POST['gamemood_description'];

    $sql = "INSERT INTO `gamemood`
            SET `gamemood_name`=?,
                `gamemood_description`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $gamemood_name, $gamemood_description);
    $prepare->execute();
    $prepare->close();

    redirect('gamemood_list.php');

    exit;
}

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');