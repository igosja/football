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

$sql = "SELECT `position_coordinate_x`, `position_coordinate_y`, `position_available`, `position_description`, `position_name`
        FROM `position`
        WHERE `position_id`='$num_get'
        LIMIT 1";
$position_sql = $mysqli->query($sql);

$count_position = $position_sql->num_rows;

if (0 == $count_position)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');

    exit;
}

if (isset($_POST['position_name']))
{
    $position_name          = $_POST['position_name'];
    $position_description   = $_POST['position_description'];
    $position_available     = (int) $_POST['position_available'];
    $position_coordinate_x  = (int) $_POST['position_coordinate_x'];
    $position_coordinate_y  = (int) $_POST['position_coordinate_y'];

    $sql = "UPDATE `position` 
            SET `position_name`=?,
                `position_description`=?,
                `position_available`=?,
                `position_coordinate_x`=?,
                `position_coordinate_y`=?
            WHERE `position_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ssiii', $position_name, $position_description, $position_available, $position_coordinate_x, $position_coordinate_y);
    $prepare->execute();
    $prepare->close();

    $sql = "DELETE FROM `positionrole`
            WHERE `positionrole_position_id`='$num_get'";
    $mysqli->query($sql);

    $sql_array = array();

    foreach($_POST['role'] as $key=>$value)
    {
        $value       = (int) $value;
        $sql_array[] = "('$num_get', '$value')";
    }

    $sql = "INSERT INTO `positionrole` (`positionrole_position_id`, `positionrole_role_id`)
            VALUES " . implode(',', $sql_array) . ";";
    $mysqli->query($sql);

    redirect('position_list.php');
}

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$position_name          = $position_array[0]['position_name'];
$position_description   = $position_array[0]['position_description'];
$position_available     = $position_array[0]['position_available'];
$position_coordinate_x  = $position_array[0]['position_coordinate_x'];
$position_coordinate_y  = $position_array[0]['position_coordinate_y'];

$sql = "SELECT `role_id`, `role_name`
        FROM `role`
        ORDER BY `role_id` ASC";
$role_sql = $mysqli->query($sql);

$role_array = $role_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `positionrole_role_id`
        FROM `positionrole`
        WHERE `positionrole_position_id`='$num_get'
        ORDER BY `positionrole_id` ASC";
$positionrole_sql = $mysqli->query($sql);

$positionrole_array = $positionrole_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('position_name', $position_name);
$smarty->assign('position_description', $position_description);
$smarty->assign('position_available', $position_available);
$smarty->assign('position_coordinate_x', $position_coordinate_x);
$smarty->assign('position_coordinate_y', $position_coordinate_y);
$smarty->assign('role_array', $role_array);
$smarty->assign('positionrole_array', $positionrole_array);
$smarty->assign('tpl', 'position_create');

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');