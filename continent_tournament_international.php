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

$sql = "SELECT `continent_name`
        FROM `continent`
        WHERE `continent_id`='$num_get'
        LIMIT 1";
$continent_sql = $mysqli->query($sql);

$count_continent = $continent_sql->num_rows;

if (0 == $count_continent)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$continent_array = $continent_sql->fetch_all(1);

$continent_name = $continent_array[0]['continent_name'];

$sql = "SELECT `country_id`,
               `country_name`,
               `tournament_id`,
               `tournament_name`,
               `tournament_reputation`
        FROM `tournament`
        LEFT JOIN `worldcup`
        ON `worldcup_tournament_id`=`tournament_id`
        LEFT JOIN `country`
        ON `worldcup_country_id`=`country_id`
        WHERE `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_WORLD_CUP . "'
        AND `worldcup_place`='1'
        AND `worldcup_season_id`='$igosja_season_id'-'1'
        ORDER BY `tournament_reputation` DESC, `tournament_id` ASC";
$tournament_sql = $mysqli->query($sql);

$tournament_array = $tournament_sql->fetch_all(1);

$sql = "SELECT `tournament_id`,
               `tournament_name`,
               `tournament_reputation`
        FROM `tournament`
        WHERE `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONS_LEAGUE . "'
        ORDER BY `tournament_reputation` DESC, `tournament_id` ASC";
$league_sql = $mysqli->query($sql);

$count_league = $league_sql->num_rows;
$league_array = $league_sql->fetch_all(1);

$sql = "SELECT `game_guest_score`,
               `game_guest_shoot_out`,
               `game_guest_team_id`,
               `game_home_score`,
               `game_home_shoot_out`,
               `game_home_team_id`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `game_stage_id`='" .CUP_FINAL_STAGE . "'
        AND `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONS_LEAGUE . "'
        AND `shedule_season_id`='$igosja_season_id'-'1'
        ORDER BY `game_id` ASC
        LIMIT 2";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;

if (2 == $count_game)
{
    $game_array = $game_sql->fetch_all(1);

    $home_team_id       = $game_array[0]['game_home_team_id'];
    $home_score_1       = $game_array[0]['game_guest_score'];
    $home_shoot_out_1   = $game_array[0]['game_guest_shoot_out'];
    $home_score_2       = $game_array[1]['game_guest_score'];
    $home_shoot_out_2   = $game_array[1]['game_guest_shoot_out'];
    $guest_team_id      = $game_array[0]['game_guest_team_id'];
    $guest_score_1      = $game_array[0]['game_guest_score'];
    $guest_shoot_out_1  = $game_array[0]['game_guest_shoot_out'];
    $guest_score_2      = $game_array[1]['game_guest_score'];
    $guest_shoot_out_2  = $game_array[1]['game_guest_shoot_out'];
    $home_score         = $home_score_1 + $home_shoot_out_1 + $guest_score_2 + $guest_shoot_out_2;
    $guest_score        = $guest_score_2 + $guest_shoot_out_2 + $home_score_2 + $home_shoot_out_2;

    if ($home_score > $guest_score)
    {
        $winner_id = $home_team_id;
    }
    else
    {
        $winner_id = $guest_team_id;
    }

    $sql = "SELECT `team_name`
            FROM `team`
            WHERE `team_id`='$winner_id'
            LIMIT 1";
    $team_sql = $mysqli->query($sql);

    $team_array = $team_sql->fetch_all(1);
}

if (isset($team_array[0]['team_name']))
{
    $league_array[0]['team_id']     = $winner_id;
    $league_array[0]['team_name']   = $team_array[0]['team_name'];
}
else
{
    $league_array[0]['team_id']     = 0;
    $league_array[0]['team_name']   = '-';
}

$tournament_array = array_merge($tournament_array, $league_array);
$count_tournament = count($tournament_array);

$num                = $num_get;
$header_title       = $continent_name;
$seo_title          = $continent_name . '. Рейтинг международных турниров. ' . $seo_title;
$seo_description    = $continent_name . '. Рейтинг международных турниров. ' . $seo_description;
$seo_keywords       = $continent_name . ', рейтинг международных турниров, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');