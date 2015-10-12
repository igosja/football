<?php

include ('../include/include.php');

if (isset($_POST['tournamenttype_name']))
{
    $tournamenttype_name = $_POST['tournamenttype_name'];

    $sql = "INSERT INTO `tournamenttype`
            SET `tournamenttype_name`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $tournamenttype_name);
    $prepare->execute();
    $prepare->close();

    redirect('tournamenttype_list.php');

    exit;
}

$smarty->display('admin_main.html');