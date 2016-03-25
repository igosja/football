<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['seriestype_name']))
{
    $seriestype_name = $_POST['seriestype_name'];

    $sql = "INSERT INTO `seriestype`
            SET `seriestype_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $seriestype_name);
    $prepare->execute();
    $prepare->close();

    redirect('seriestype_list.php');
}

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');