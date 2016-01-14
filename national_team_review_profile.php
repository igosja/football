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

$sql = "SELECT `t1`.`country_name` AS `country_name`,
               `t1`.`country_season_id` AS `country_season_id`,
               `stadium_name`,
               `stadium_capacity`,
               `user_birth_year`,
               `user_firstname`,
               `user_id`,
               `user_country_id`,
               `t2`.`country_name` AS `user_country_name`,
               `user_lastname`,
               `user_registration_date`
        FROM `country` AS `t1`
        LEFT JOIN `city`
        ON `t1`.`country_id`=`city_country_id`
        LEFT JOIN `team`
        ON `city_id`=`team_city_id`
        LEFT JOIN `stadium`
        ON `team_id`=`stadium_team_id`
        LEFT JOIN `user`
        ON `country_user_id`=`user_id`
        LEFT JOIN `country` AS `t2`
        ON `user_country_id`=`t2`.`country_id`
        WHERE `t1`.`country_id`='$get_num'
        ORDER BY `stadium_capacity` DESC
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    $smarty->display('wrong_page.html');

    exit;
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$country_name = $country_array[0]['country_name'];

$sql = "SELECT `country_id`,
               `country_name`,
               `team_id`,
               `team_name`
        FROM `team`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `country_id`='$get_num'
        AND `team_id`!='0'
        LIMIT 7";
$team_sql = $mysqli->query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `name_name`,
               `player_id`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `country_id`='$get_num'
        AND `team_id`!='0'
        LIMIT 7";
$player_sql = $mysqli->query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `game_id`,
               `country_id`,
               `country_name`,
               `tournament_id`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `country`
        ON IF (`game_home_country_id`='$get_num', `game_guest_country_id`=`country_id`, `game_home_country_id`=`country_id`)
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        WHERE (`game_home_country_id`='$get_num'
        OR `game_guest_country_id`='$get_num')
        AND `game_played`='0'
        ORDER BY `shedule_date` ASC
        LIMIT 1";
$nearest_game_sql = $mysqli->query($sql);

$nearest_game_array = $nearest_game_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `ratingcountry_position`
        FROM `ratingcountry`
        WHERE `ratingcountry_country_id`='$get_num'
        LIMIT 1";
$rating_sql = $mysqli->query($sql);

$rating_array = $rating_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `buyer`.`team_id` AS `buyer_id`,
               `buyer`.`team_name` AS `buyer_name`,
               `name_name`,
               `player_id`,
               `seller`.`team_id` AS `seller_id`,
               `seller`.`team_name` AS `seller_name`,
               `surname_name`
        FROM `transferhistory`
        LEFT JOIN `player`
        ON `player_id`=`transferhistory_player_id`
        LEFT JOIN `name`
        ON `name_id`=`player_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`player_surname_id`
        LEFT JOIN `team` AS `buyer`
        ON `buyer`.`team_id`=`transferhistory_buyer_id`
        LEFT JOIN `city` AS `buyer_city`
        ON `buyer`.`team_city_id`=`buyer_city`.`city_id`
        LEFT JOIN `team` AS `seller`
        ON `seller`.`team_id`=`transferhistory_seller_id`
        LEFT JOIN `city` AS `seller_city`
        ON `seller`.`team_city_id`=`seller_city`.`city_id`
        WHERE `transferhistory_season_id`='$igosja_season_id'
        AND (`seller_city`.`city_country_id`='$get_num'
        OR `buyer_city`.`city_country_id`='$get_num')
        ORDER BY `transferhistory_price` DESC
        LIMIT 10";
$transfer_sql = $mysqli->query($sql);

$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $country_name);
$smarty->assign('country_id', $get_num);
$smarty->assign('top_team_array', $team_array);
$smarty->assign('top_player_array', $player_array);
$smarty->assign('country_array', $country_array);
$smarty->assign('nearest_game_array', $nearest_game_array);
$smarty->assign('transfer_array', $transfer_array);
$smarty->assign('rating_array', $rating_array);

$smarty->display('main.html');