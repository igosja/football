<?php

include ('../include/include.php');

if (isset($_POST['newstheme_name']))
{
    $newstheme_name = $_POST['newstheme_name'];
    $newstheme_text = $_POST['newstheme_text'];

    $sql = "INSERT INTO `newstheme`
            SET `newstheme_name`=?,
                `newstheme_text`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $newstheme_name, $newstheme_text);
    $prepare->execute();
    $prepare->close();

    redirect('newstheme_list.php');

    exit;
}

$smarty->display('admin_main.html');