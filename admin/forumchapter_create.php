<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['chapter_name']))
{
    $chapter_name = $_POST['chapter_name'];

    $sql = "INSERT INTO `forumchapter`
            SET `forumchapter_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $chapter_name);
    $prepare->execute();
    $prepare->close();

    redirect('forumchapter_list.php');

    exit;
}

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');