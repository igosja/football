<?php

include('include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    $smarty->display('only_my_team.html');
    exit;
}

$sql = "SELECT `building_end_date`,
               `building_length`,
               `building_width`,
               `stadium_length`,
               `stadium_name`,
               `stadium_width`
        FROM `stadium`
        LEFT JOIN
        (
            SELECT `building_end_date`,
                   `building_length`,
                   `building_team_id`,
                   `building_width`
            FROM `building`
            WHERE `building_buildingtype_id`='5'
        ) AS `t1`
        ON `building_team_id`=`stadium_team_id`
        WHERE `stadium_team_id`='$get_num'";
$stadium_sql = $mysqli->query($sql);

$stadium_array = $stadium_sql->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['length']) &&
    isset($_POST['width']) &&
    !$stadium_array[0]['building_end_date'])
{
    $length = (int)$_POST['length'];
    $width  = (int)$_POST['width'];

    if (100 <= $length &&
        110 >= $length &&
        64 <= $width &&
        75 >= $width)
    {
        $sql = "INSERT INTO `building`
                SET `building_buildingtype_id`='5',
                    `building_end_date`=DATE_ADD(CURDATE(), INTERVAL 1 DAY),
                    `building_length`='$length',
                    `building_team_id`='$get_num',
                    `building_width`='$width'";
        $mysqli->query($sql);

        redirect('team_team_information_condition.php?num=' . $get_num);
        exit;
    }
    else
    {
        $error_message = 'Не правильно введены размеры поля';

        $smarty->assign('error_message', $error_message);
    }
}

$smarty->assign('header_title', $authorization_team_name);
$smarty->assign('stadium_array', $stadium_array);

$smarty->display('main.html');