<?php

include ('../include/include.php');

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

    exit;
}

$smarty->display('admin_main.html');