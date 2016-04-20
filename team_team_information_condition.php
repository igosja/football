<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `city_name`,
               `team_id`,
               `team_name`,
               `team_school_level`,
               `team_training_level`,
               `stadium_capacity`,
               `stadium_length`,
               `stadium_name`,
               `stadium_width`,
               `stadiumquality_name`
        FROM `team`
        LEFT JOIN `stadium`
        ON `stadium_team_id`=`team_id`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `stadiumquality`
        ON `stadiumquality_id`=`stadium_stadiumquality_id`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

$sql = "SELECT `building_capacity`,
               `building_end_date`,
               `buildingtype_name`
        FROM `building`
        LEFT JOIN `buildingtype`
        ON `building_buildingtype_id`=`buildingtype_id`
        WHERE `building_team_id`='$get_num'
        ORDER BY `building_end_date` ASC";
$building_sql = $mysqli->query($sql);

$building_array = $building_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $team_name;

include (__DIR__ . '/view/main.php');