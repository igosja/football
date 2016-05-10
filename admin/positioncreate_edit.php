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

$sql = "SELECT `positioncreate_position_id`
        FROM `positioncreate`
        WHERE `positioncreate_id`='$num_get'
        LIMIT 1";
$position_sql = $mysqli->query($sql);

$count_position = $position_sql->num_rows;

if (0 == $count_position)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.php');

    exit;
}

if (isset($_POST['position_id']))
{
    $position_id = (int) $_POST['position_id'];

    $sql = "UPDATE `positioncreate` 
            SET `positioncreate_position_id`='$position_id'
            WHERE `positioncreate_id`='$num_get'";
    $mysqli->query($sql);

    redirect('positioncreate_list.php');
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

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');