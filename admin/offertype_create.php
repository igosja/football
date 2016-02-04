<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['offertype_name']))
{
    $offertype_name = $_POST['offertype_name'];

    $sql = "INSERT INTO `offertype`
            SET `offertype_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $offertype_name);
    $prepare->execute();
    $prepare->close();

    redirect('offertype_list.php');

    exit;
}

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');