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

$sql = "SELECT `statustransfer_name`
        FROM `statustransfer`
        WHERE `statustransfer_id`='$get_num'
        LIMIT 1";
$statustransfer_sql = $mysqli->query($sql);

$count_statustransfer = $statustransfer_sql->num_rows;

if (0 == $count_statustransfer)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['statustransfer_name']))
{
    $statustransfer_name = $_POST['statustransfer_name'];

    $sql = "UPDATE `statustransfer` 
            SET `statustransfer_name`=?
            WHERE `statustransfer_id`='$get_num'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $statustransfer_name);
    $prepare->execute();
    $prepare->close();

    redirect('statustransfer_list.php');

    exit;
}

$statustransfer_array = $statustransfer_sql->fetch_all(MYSQLI_ASSOC);

$statustransfer_name = $statustransfer_array[0]['statustransfer_name'];

$smarty->assign('statustransfer_name', $statustransfer_name);
$smarty->assign('tpl', 'statustransfer_create');

$smarty->display('admin_main.html');