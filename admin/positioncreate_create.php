<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['position_id']))
{
    $position_id = (int) $_POST['position_id'];

    $sql = "INSERT INTO `positioncreate`
            SET `positioncreate_position_id`='$position_id'";
    $mysqli->query($sql);

    redirect('positioncreate_list.php');

    exit;
}

$sql = "SELECT `position_description`, `position_id`
        FROM `position`
        ORDER BY `position_id`";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('position_array', $position_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');