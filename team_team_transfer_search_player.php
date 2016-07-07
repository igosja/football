<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_team_id))
{
    $num_get = $authorization_team_id;
}
else
{
    include (__DIR__ . '/view/only_my_team.php');
    exit;
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

$team_array = $team_sql->fetch_all(1);

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
    $sql_position = "`player_position_id`='$sql_position'";
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
        LEFT JOIN `position`
        ON `player_position_id`=`position_id`
        WHERE `player_team_id`!='0'
        AND `player_statustransfer_id`='2'
        AND `player_age` BETWEEN '$sql_age_min' AND '$sql_age_max'
        AND `player_weight` BETWEEN '$sql_weight_min' AND '$sql_weight_max'
        AND `player_height` BETWEEN '$sql_height_min' AND '$sql_height_max'
        AND `player_price` BETWEEN '$sql_price_min' AND '$sql_price_max'
        AND `player_transfer_price` BETWEEN '$sql_transfer_price_min' AND '$sql_transfer_price_max'
        AND `surname_name` LIKE ?
        AND $sql_position
        AND $sql_country
        ORDER BY `player_transfer_price` DESC, `player_id` ASC
        LIMIT $offset, 30";
$like    = '%' . $sql_surname . '%';
$prepare = $mysqli->prepare($sql);
$prepare->bind_param('s', $like);
$prepare->execute();
$player_sql = $prepare->get_result();
$prepare->close();

$player_array = $player_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count`";
$count_page = $mysqli->query($sql);
$count_page = $count_page->fetch_all(1);
$count_page = $count_page[0]['count'];
$count_page = ceil($count_page / 30);

$sql = "SELECT `position_id`,
               `position_name`
        FROM `position`
        WHERE `position_available`='1'
        ORDER BY `position_id` ASC";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_season_id`!='0'
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $team_name;
$seo_title          = $header_title . '. Поиск игроков. ' . $seo_title;
$seo_description    = $header_title . '. Поиск игроков. ' . $seo_description;
$seo_keywords       = $header_title . ', поиск игроков, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');
