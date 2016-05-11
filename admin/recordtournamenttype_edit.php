<?php

include (__DIR__ . '/../include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `recordtournamenttype_name`
        FROM `recordtournamenttype`
        WHERE `recordtournamenttype_id`='$num_get'
        LIMIT 1";
$recordtournamenttype_sql = $mysqli->query($sql);

$count_recordtournamenttype = $recordtournamenttype_sql->num_rows;

if (0 == $count_recordtournamenttype)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['recordtournamenttype_name']))
{
    $recordtournamenttype_name = $_POST['recordtournamenttype_name'];

    $sql = "UPDATE `recordtournamenttype` 
            SET `recordtournamenttype_name`=?
            WHERE `recordtournamenttype_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $recordtournamenttype_name);
    $prepare->execute();
    $prepare->close();

    redirect('recordtournamenttype_list.php');
}

$recordtournamenttype_array = $recordtournamenttype_sql->fetch_all(MYSQLI_ASSOC);

$tpl = 'recordtournamenttype_create';

include (__DIR__ . '/../view/admin_main.php');