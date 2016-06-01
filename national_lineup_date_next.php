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

$sql = "SELECT `country_name`
        FROM `country`
        WHERE `country_id`='$num_get'
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$count_country = $country_sql->num_rows;

if (0 == $count_country)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$country_array = $country_sql->fetch_all(1);

$country_name = $country_array[0]['country_name'];

$sql = "SELECT `game_id`,
               `country_id`,
               `country_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `country`
        ON IF (`game_home_country_id`='$num_get', `game_guest_country_id`=`country_id`, `game_home_country_id`=`country_id`)
        WHERE (`game_home_country_id`='$num_get'
        OR `game_guest_country_id`='$num_get')
        AND `game_played`='0'
        ORDER BY `shedule_date` ASC
        LIMIT 1";
$nearest_game_sql = $mysqli->query($sql);

$count_nearest_game = $nearest_game_sql->num_rows;

if (0 == $count_nearest_game)
{
    include (__DIR__ . '/view/no_game.php');
    exit;
}

$nearest_game_array = $nearest_game_sql->fetch_all(1);

$opponent_id = $nearest_game_array[0]['country_id'];

$sql = "SELECT `game_guest_score`,
               `game_guest_country_id`,
               `t2`.`country_name` AS `game_guest_country_name`,
               `game_home_score`,
               `game_home_country_id`,
               `t1`.`country_name` AS `game_home_country_name`,
               `game_id`,
               `shedule_date`,
               `tournament_id`,
               `tournament_name`
        FROM `game`
        LEFT JOIN `country` AS `t1`
        ON `game_home_country_id`=`t1`.`country_id`
        LEFT JOIN `country` AS `t2`
        ON `game_guest_country_id`=`t2`.`country_id`
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE ((`game_home_country_id`='$num_get'
        AND `game_guest_country_id`='$opponent_id')
        OR (`game_guest_country_id`='$num_get'
        AND `game_home_country_id`='$opponent_id'))
        AND `game_played`='1'
        ORDER BY `game_id`";
$game_sql = $mysqli->query($sql);

$game = $game_sql->num_rows;

$game_array = $game_sql->fetch_all(1);

$win    = 0;
$draw   = 0;
$loose  = 0;
$score  = 0;
$pass   = 0;

for ($i=0; $i<$game; $i++)
{
    $country_id  = $game_array[$i]['game_home_country_id'];
    $home_score  = $game_array[$i]['game_home_score'];
    $guest_score = $game_array[$i]['game_guest_score'];

    if ($home_score > $guest_score)
    {
        if ($country_id == $num_get)
        {
            $win++;
        }
        else
        {
            $loose++;
        }
    }
    elseif ($home_score == $guest_score)
    {
        $draw++;
    }
    elseif ($home_score < $guest_score)
    {
        if ($country_id == $num_get)
        {
            $loose++;
        }
        else
        {
            $win++;
        }
    }

    if ($country_id == $num_get)
    {
        $score = $score + $home_score;
        $pass  = $pass + $guest_score;
    }
    else
    {
        $score = $score + $guest_score;
        $pass  = $pass + $home_score;
    }
}

$num                = $num_get;
$header_title       = $country_name;
$seo_title          = $header_title . '. Следующий соперник. ' . $seo_title;
$seo_description    = $header_title . '. Следующий соперник. ' . $seo_description;
$seo_keywords       = $header_title . ', следующий соперник, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');