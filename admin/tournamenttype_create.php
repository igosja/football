<?php

include ('../include/include.php');

if (isset($_POST['tournamenttype_name']))
{
    $tournamenttype_name    = $_POST['tournamenttype_name'];
    $tournamenttype_visitor = (float) $_POST['tournamenttype_visitor'];

    $sql = "INSERT INTO `tournamenttype`
            SET `tournamenttype_name`=?,
                `tournamenttype_visitor`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('sd', $tournamenttype_name, $tournamenttype_visitor);
    $prepare->execute();
    $prepare->close();

    redirect('tournamenttype_list.php');

    exit;
}

$smarty->display('admin_main.html');