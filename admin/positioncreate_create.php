<?php

include (__DIR__ . '/../include/include.php');

if (isset($_POST['position_id']))
{
    $position_id = (int) $_POST['position_id'];

    $sql = "INSERT INTO `positioncreate`
            SET `positioncreate_position_id`='$position_id'";
    $mysqli->query($sql);

    redirect('positioncreate_list.php');
}

$sql = "SELECT `position_description`,
               `position_id`
        FROM `position`
        ORDER BY `position_id`";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');