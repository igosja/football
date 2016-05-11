<?php

include (__DIR__ . '/../include/include.php');

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
}

include (__DIR__ . '/../view/admin_main.php');