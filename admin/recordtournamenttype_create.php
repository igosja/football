<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['recordtournamenttype_name']))
{
    $recordtournamenttype_name = $_POST['recordtournamenttype_name'];

    $sql = "INSERT INTO `recordtournamenttype`
            SET `recordtournamenttype_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $recordtournamenttype_name);
    $prepare->execute();
    $prepare->close();

    redirect('recordtournamenttype_list.php');
}

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');