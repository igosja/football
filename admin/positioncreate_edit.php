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

$sql = "SELECT `positioncreate_position_id`
        FROM `positioncreate`
        WHERE `positioncreate_id`='$get_num'
        LIMIT 1";
$position_sql = $mysqli->query($sql);

$count_position = $position_sql->num_rows;

if (0 == $count_position)
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['position_id']))
{
    $position_id = (int) $_POST['position_id'];

    $sql = "UPDATE `positioncreate` 
            SET `positioncreate_position_id`='$position_id'
            WHERE `positioncreate_id`='$get_num'";
    $mysqli->query($sql);

    redirect('positioncreate_list.php');

    exit;
}

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$position_id = $position_array[0]['positioncreate_position_id'];

$sql = "SELECT `position_description`, `position_id`
        FROM `position`
        ORDER BY `position_id`";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('position_id', $position_id);
$smarty->assign('position_array', $position_array);
$smarty->assign('tpl', 'positioncreate_create');

$smarty->display('admin_main.html');