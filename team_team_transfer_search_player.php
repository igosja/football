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

if (isset($_GET['age_min']) && !empty($_GET['age_min']))
{
    $sql_age_min = (int) $_GET['age_min'];
}
else
{
    $sql_age_min = 0;
}

if (isset($_GET['age_max']) && !empty($_GET['age_max']))
{
    $sql_age_max = (int) $_GET['age_max'];
}
else
{
    $sql_age_max = 50;
}

if (isset($_GET['weight_min']) && !empty($_GET['weight_min']))
{
    $sql_weight_min = (int) $_GET['weight_min'];
}
else
{
    $sql_weight_min = 0;
}

if (isset($_GET['weight_max']) && !empty($_GET['weight_max']))
{
    $sql_weight_max = (int) $_GET['weight_max'];
}
else
{
    $sql_weight_max = 300;
}

if (isset($_GET['height_min']) && !empty($_GET['height_min']))
{
    $sql_height_min = (int) $_GET['height_min'];
}
else
{
    $sql_height_min = 0;
}

if (isset($_GET['height_max']) && !empty($_GET['height_max']))
{
    $sql_height_max = (int) $_GET['height_max'];
}
else
{
    $sql_height_max = 300;
}

if (isset($_GET['price_min']) && !empty($_GET['price_min']))
{
    $sql_price_min = (int) $_GET['price_min'];
}
else
{
    $sql_price_min = 0;
}

if (isset($_GET['price_max']) && !empty($_GET['price_max']))
{
    $sql_price_max = (int) $_GET['price_max'];
}
else
{
    $sql_price_max = 100000000000;
}

if (isset($_GET['transfer_price_min']) && !empty($_GET['transfer_price_min']))
{
    $sql_transfer_price_min = (int) $_GET['transfer_price_min'];
}
else
{
    $sql_transfer_price_min = 0;
}

if (isset($_GET['transfer_price_max']) && !empty($_GET['transfer_price_max']))
{
    $sql_transfer_price_max = (int) $_GET['transfer_price_max'];
}
else
{
    $sql_transfer_price_max = 100000000000;
}

if (0 == $sql_position)
{
    $sql_position = 1;
}
else
{
    $sql_position = "`playerposition_position_id`='$sql_position'";
}

if (0 == $sql_country)
{
    $sql_country = 1;
}
else
{
    $sql_country = "`player_country_id`='$sql_country'";
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
               `player_age`,
               `player_id`,
               `player_height`,
               `player_price`,
               `player_transfer_price`,
               `player_weight`,
               `position_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team`
        ON `team_id`=`player_team_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `playerposition`
        ON `playerposition_player_id`=`player_id`
        LEFT JOIN `position`
        ON `playerposition_position_id`=`position_id`
        WHERE `player_team_id`!='$get_num'
        AND `playerposition_value`='100'
        AND `player_statustransfer_id`!='3'
        AND `player_age` BETWEEN '$sql_age_min' AND '$sql_age_max'
        AND `player_weight` BETWEEN '$sql_weight_min' AND '$sql_weight_max'
        AND `player_height` BETWEEN '$sql_height_min' AND '$sql_height_max'
        AND `player_price` BETWEEN '$sql_price_min' AND '$sql_price_max'
        AND `player_transfer_price` BETWEEN '$sql_transfer_price_min' AND '$sql_transfer_price_max'
        AND `surname_name` LIKE ?
        AND $sql_position
        AND $sql_country
        ORDER BY `player_transfer_price` DESC
        LIMIT $offset, 30";
$like    = '%' . $sql_surname . '%';
$prepare = $mysqli->prepare($sql);
$prepare->bind_param('s', $like);
$prepare->execute();
$player_sql = $prepare->get_result();
$prepare->close();

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count_player`";
$count_player = $mysqli->query($sql);
$count_player = $count_player->fetch_all(MYSQLI_ASSOC);
$count_player = $count_player[0]['count_player'];
$count_player = ceil($count_player / 30);

$sql = "SELECT `position_id`,
               `position_name`
        FROM `position`
        WHERE `position_available`='1'
        ORDER BY `position_id` ASC";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_season_id`!='0'
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('team_name', $team_name);
$smarty->assign('player_array', $player_array);
$smarty->assign('position_array', $position_array);
$smarty->assign('country_array', $country_array);
$smarty->assign('count_player', $count_player);

$smarty->display('main.html');