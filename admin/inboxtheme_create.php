<?php

include (__DIR__ . '/../include/include.php');

if (isset($_POST['inboxtheme_name']))
{
    $inboxtheme_name = $_POST['inboxtheme_name'];
    $inboxtheme_text = $_POST['inboxtheme_text'];

    $sql = "INSERT INTO `inboxtheme`
            SET `inboxtheme_name`=?,
                `inboxtheme_text`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $inboxtheme_name, $inboxtheme_text);
    $prepare->execute();
    $prepare->close();

    redirect('inboxtheme_list.php');
}

include (__DIR__ . '/../view/admin_main.php');