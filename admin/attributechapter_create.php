<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['chapter_name']))
{
    $chapter_name = $_POST['chapter_name'];

    $sql = "INSERT INTO `attributechapter`
            SET `attributechapter_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $chapter_name);
    $prepare->execute();
    $prepare->close();

    redirect('attributechapter_list.php');
}

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');