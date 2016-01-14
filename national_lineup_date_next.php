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

$sql = "SELECT `country_name`
        FROM `country`
        WHERE `country_id`='$get_num'
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

$sql = "SELECT `game_id`,
               `country_id`,
               `country_name`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `country`
        ON IF (`game_home_country_id`='$get_num', `game_guest_country_id`=`country_id`, `game_home_country_id`=`country_id`)
        WHERE (`game_home_country_id`='$get_num'
        OR `game_guest_country_id`='$get_num')
        AND `game_played`='0'
        ORDER BY `shedule_date` ASC
        LIMIT 1";
$nearest_game_sql = $mysqli->query($sql);

$nearest_game_array = $nearest_game_sql->fetch_all(MYSQLI_ASSOC);

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
        WHERE ((`game_home_country_id`='$get_num'
        AND `game_guest_country_id`='$opponent_id')
        OR (`game_guest_country_id`='$get_num'
        AND `game_home_country_id`='$opponent_id'))
        AND `game_played`='1'
        ORDER BY `game_id`";
$game_sql = $mysqli->query($sql);

$game = $game_sql->num_rows;

$game_array = $game_sql->fetch_all(MYSQL_ASSOC);

$win    = 0;
$draw   = 0;
$loose  = 0;
$score  = 0;
$pass   = 0;

for ($i=0; $i<$game; $i++)
{
    $country_id     = $game_array[$i]['game_home_country_id'];
    $home_score  = $game_array[$i]['game_home_score'];
    $guest_score = $game_array[$i]['game_guest_score'];

    if ($home_score > $guest_score)
    {
        if ($country_id == $get_num)
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
        if ($country_id == $get_num)
        {
            $loose++;
        }
        else
        {
            $win++;
        }
    }

    if ($country_id == $get_num)
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

$smarty->assign('num', $get_num);
$smarty->assign('header_title', $country_name);
$smarty->assign('team_name', $country_name);
$smarty->assign('game_array', $game_array);
$smarty->assign('nearest_game_array', $nearest_game_array);
$smarty->assign('game', $game);
$smarty->assign('win', $win);
$smarty->assign('draw', $draw);
$smarty->assign('loose', $loose);
$smarty->assign('score', $score);
$smarty->assign('pass', $pass);

$smarty->display('main.html');