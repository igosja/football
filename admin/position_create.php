<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_POST['position_name']))
{
    $position_name          = $_POST['position_name'];
    $position_description   = $_POST['position_description'];
    $position_available     = (int) $_POST['position_available'];
    $position_coordinate_x  = (int) $_POST['position_coordinate_x'];
    $position_coordinate_y  = (int) $_POST['position_coordinate_y'];

    $sql = "INSERT INTO `position`
            SET `position_name`=?,
                `position_description`=?,
                `position_available`=?,
                `position_coordinate_x`=?,
                `position_coordinate_y`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ssiii', $position_name, $position_description, $position_available, $position_coordinate_x, $position_coordinate_y);
    $prepare->execute();
    $prepare->close();

    foreach($_POST['role'] as $key=>$value)
    {
        $value       = (int) $value;
        $sql_array[] = "('$mysqli->insert_id', '$value')";
    }

    $sql = "INSERT INTO `positionrole` (`positionrole_position_id`, `positionrole_role_id`)
            VALUES " . implode(',', $sql_array) . ";";
    $mysqli->query($sql);

    redirect('position_list.php');
}

$sql = "SELECT `role_id`, `role_name`
        FROM `role`
        ORDER BY `role_id` ASC";
$role_sql = $mysqli->query($sql);

$role_array = $role_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('role_array', $role_array);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');