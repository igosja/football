<?php

include ('include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    $smarty->display('wrong_page.html');

    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

if (isset($_GET['surname']) && !empty($_GET['surname']))
{
    $sql_surname = $_GET['surname'];
}
else
{
    $sql_surname = '';
}

if (isset($_GET['position']) && !empty($_GET['position']))
{
    $sql_position = (int) $_GET['position'];
}
else
{
    $sql_position = 0;
}

if (isset($_GET['country']) && !empty($_GET['country']))
{
    $sql_country = (int) $_GET['country'];
}
else
{
    $sql_country = 0;
}

if (0 == $sql_position)
{
    $sql_position = 1;
}
else
{
    $sql_position = "`staff_staffpost_id`='$sql_position'";
}

if (0 == $sql_country)
{
    $sql_country = 1;
}
else
{
    $sql_country = "`staff_country_id`='$sql_country'";
}

if (isset($_GET['page']))
{
    $page = (int) $_GET['page'];
}
else
{
    $page = 1;
}

$offset = ($page - 1) * 30;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `country_id`,
               `country_name`,
               `name_name`,
               `staff_id`,
               `staff_reputation`,
               `staff_salary`,
               `staffpost_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `staff`
        LEFT JOIN `name`
        ON `name_id`=`staff_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`staff_surname_id`
        LEFT JOIN `team`
        ON `team_id`=`staff_team_id`
        LEFT JOIN `country`
        ON `country_id`=`staff_country_id`
        LEFT JOIN `staffpost`
        ON `staffpost_id`=`staff_staffpost_id`
        WHERE `staff_team_id`!='0'
        AND $sql_country
        AND $sql_position
        AND `surname_name` LIKE ?
        ORDER BY `staff_reputation` DESC
        LIMIT $offset, 30";
$like    = '%' . $sql_surname . '%';
$prepare = $mysqli->prepare($sql);
$prepare->bind_param('s', $like);
$prepare->execute();
$staff_sql = $prepare->get_result();
$prepare->close();

$staff_array = $staff_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count_staff`";
$count_staff = $mysqli->query($sql);
$count_staff = $count_staff->fetch_all(MYSQLI_ASSOC);
$count_staff = $count_staff[0]['count_staff'];
$count_staff = ceil($count_staff / 30);

$sql = "SELECT `staffpost_id`,
               `staffpost_name`
        FROM `staffpost`
        ORDER BY `staffpost_id` ASC";
$staffpost_sql = $mysqli->query($sql);

$staffpost_array = $staffpost_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_season_id`!='0'
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $team_name);
$smarty->assign('staff_array', $staff_array);
$smarty->assign('staffpost_array', $staffpost_array);
$smarty->assign('country_array', $country_array);
$smarty->assign('count_staff', $count_staff);

$smarty->display('main.html');