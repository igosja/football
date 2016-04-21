<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$num_get'
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

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `staff_id`,
               `staff_reputation`,
               `staff_salary`,
               `staffpost_name`,
               `surname_name`
        FROM `staff`
        LEFT JOIN `country`
        ON `staff_country_id`=`country_id`
        LEFT JOIN `name`
        ON `name_id`=`staff_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`staff_surname_id`
        LEFT JOIN `staffpost`
        ON `staffpost_id`=`staff_staffpost_id`
        WHERE `staff_team_id`='$num_get'";
$staff_sql = $mysqli->query($sql);

$staff_array = $staff_sql->fetch_all(MYSQLI_ASSOC);

$num            = $num_get;
$header_title   = $team_name;

include (__DIR__ . '/view/main.php');