<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['post_name']))
{
    $post_name = $_POST['post_name'];

    $sql = "INSERT INTO `staffpost`
            SET `staffpost_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $post_name);
    $prepare->execute();
    $prepare->close();

    redirect('post_list.php');

    exit;
}

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');