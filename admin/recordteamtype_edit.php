<?php

include ('../include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `recordteamtype_name`
        FROM `recordteamtype`
        WHERE `recordteamtype_id`='$get_num'
        LIMIT 1";
$recordteamtype_sql = $mysqli->query($sql);

$count_recordteamtype = $recordteamtype_sql->num_rows;

if (0 == $count_recordteamtype)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['recordteamtype_name']))
{
    $recordteamtype_name = $_POST['recordteamtype_name'];

    $sql = "UPDATE `recordteamtype` 
            SET `recordteamtype_name`=?
            WHERE `recordteamtype_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $recordteamtype_name);
    $prepare->execute();
    $prepare->close();

    redirect('recordteamtype_list.php');

    exit;
}

$recordteamtype_array = $recordteamtype_sql->fetch_all(MYSQLI_ASSOC);

$recordteamtype_name = $recordteamtype_array[0]['recordteamtype_name'];

$smarty->assign('recordteamtype_name', $recordteamtype_name);
$smarty->assign('tpl', 'recordteamtype_create');

$smarty->display('admin_main.html');