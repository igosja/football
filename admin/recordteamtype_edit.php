<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `recordteamtype_name`
        FROM `recordteamtype`
        WHERE `recordteamtype_id`='$num_get'
        LIMIT 1";
$recordteamtype_sql = $mysqli->query($sql);

$count_recordteamtype = $recordteamtype_sql->num_rows;

if (0 == $count_recordteamtype)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');

    exit;
}

if (isset($_POST['recordteamtype_name']))
{
    $recordteamtype_name = $_POST['recordteamtype_name'];

    $sql = "UPDATE `recordteamtype` 
            SET `recordteamtype_name`=?
            WHERE `recordteamtype_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $recordteamtype_name);
    $prepare->execute();
    $prepare->close();

    redirect('recordteamtype_list.php');
}

$recordteamtype_array = $recordteamtype_sql->fetch_all(MYSQLI_ASSOC);

$recordteamtype_name = $recordteamtype_array[0]['recordteamtype_name'];

$smarty->assign('recordteamtype_name', $recordteamtype_name);
$smarty->assign('tpl', 'recordteamtype_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');