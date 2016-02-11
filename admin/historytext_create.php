<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['historytext_name']))
{
    $historytext_name = $_POST['historytext_name'];

    $sql = "INSERT INTO `historytext`
            SET `historytext_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $historytext_name);
    $prepare->execute();
    $prepare->close();

    redirect('historytext_list.php');
    exit;
}

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');