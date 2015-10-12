<?php

include ('../include/include.php');

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

    exit;
}

$smarty->display('admin_main.html');