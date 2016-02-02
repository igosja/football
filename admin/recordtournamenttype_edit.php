<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `recordtournamenttype_name`
        FROM `recordtournamenttype`
        WHERE `recordtournamenttype_id`='$get_num'
        LIMIT 1";
$recordtournamenttype_sql = $mysqli->query($sql);

$count_recordtournamenttype = $recordtournamenttype_sql->num_rows;

if (0 == $count_recordtournamenttype)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/wrong_page.html');

    exit;
}

if (isset($_POST['recordtournamenttype_name']))
{
    $recordtournamenttype_name = $_POST['recordtournamenttype_name'];

    $sql = "UPDATE `recordtournamenttype` 
            SET `recordtournamenttype_name`=?
            WHERE `recordtournamenttype_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $recordtournamenttype_name);
    $prepare->execute();
    $prepare->close();

    redirect('recordtournamenttype_list.php');

    exit;
}

$recordtournamenttype_array = $recordtournamenttype_sql->fetch_all(MYSQLI_ASSOC);

$recordtournamenttype_name = $recordtournamenttype_array[0]['recordtournamenttype_name'];

$smarty->assign('recordtournamenttype_name', $recordtournamenttype_name);
$smarty->assign('tpl', 'recordtournamenttype_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/include/view/admin_main.html');