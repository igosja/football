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

$sql = "SELECT `tournament_name`
        FROM `tournament`
        WHERE `tournament_id`='$get_num'
        LIMIT 1";
$tournament_sql = $mysqli->query($sql);

$count_tournament = $tournament_sql->num_rows;

if (0 == $count_tournament)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

$tournament_name = $tournament_array[0]['tournament_name'];

$sql = "SELECT `game_first_game_id`,
               `game_guest_score`,
               `game_guest_shoot_out`,
               `game_guest_team_id`,
               `game_home_score`,
               `game_home_shoot_out`,
               `game_home_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `guest_city`.`city_name` AS `guest_city_name`,
               `guest_country`.`country_name` AS `guest_country_name`,
               `home_team`.`team_name` AS `home_team_name`,
               `home_city`.`city_name` AS `home_city_name`,
               `home_country`.`country_name` AS `home_country_name`,
               `shedule_season_id`
        FROM `game`
        LEFT JOIN `team` AS `guest_team`
        ON `guest_team`.`team_id`=`game_guest_team_id`
        LEFT JOIN `city` AS `guest_city`
        ON `guest_city`.`city_id`=`guest_team`.`team_city_id`
        LEFT JOIN `country` AS `guest_country`
        ON `guest_country`.`country_id`=`guest_city`.`city_country_id`
        LEFT JOIN `team` AS `home_team`
        ON `home_team`.`team_id`=`game_home_team_id`
        LEFT JOIN `city` AS `home_city`
        ON `home_city`.`city_id`=`home_team`.`team_city_id`
        LEFT JOIN `country` AS `home_country`
        ON `home_country`.`country_id`=`home_city`.`city_country_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `game_tournament_id`='$get_num'
        AND `shedule_season_id`<'$igosja_season_id'
        AND `game_stage_id`='" . CUP_FINAL_STAGE . "'
        ORDER BY `shedule_season_id` DESC, `game_first_game_id` ASC";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;
$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$final_game_array   = array();
$winner_array       = array();

for ($i=0; $i<$count_game; $i++)
{
    $first_game_id  = $game_array[$i]['game_first_game_id'];
    $season_id      = $game_array[$i]['shedule_season_id'];

    if (0 == $first_game_id)
    {
        $home_team_id       = $game_array[$i]['game_home_team_id'];
        $home_team_name     = $game_array[$i]['home_team_name'];
        $home_city_name     = $game_array[$i]['home_city_name'];
        $home_country_name  = $game_array[$i]['home_country_name'];
        $home_score_1       = $game_array[$i]['game_home_score'] + $game_array[$i]['game_home_shoot_out'];
        $guest_team_id      = $game_array[$i]['game_guest_team_id'];
        $guest_team_name    = $game_array[$i]['guest_team_name'];
        $guest_city_name    = $game_array[$i]['guest_city_name'];
        $guest_country_name = $game_array[$i]['guest_country_name'];
        $guest_score_1      = $game_array[$i]['game_guest_score'] + $game_array[$i]['game_guest_shoot_out'];

        $final_game_array[$season_id] = array
        (
            'home_team_id'          => $home_team_id,
            'home_team_name'        => $home_team_name,
            'home_city_name'        => $home_city_name,
            'home_country_name'     => $home_country_name,
            'home_score_1'          => $home_score_1,
            'guest_team_id'         => $guest_team_id,
            'guest_team_name'       => $guest_team_name,
            'guest_city_name'       => $guest_city_name,
            'guest_country_name'    => $guest_country_name,
            'guest_score_1'         => $guest_score_1,
            'season_id'             => $season_id,
        );
    }
    else
    {
        $home_score_2   = $game_array[$i]['game_guest_score'] + $game_array[$i]['game_guest_shoot_out'];;
        $guest_score_2  = $game_array[$i]['game_home_score'] + $game_array[$i]['game_home_shoot_out'];;

        $final_game_array[$season_id]['home_score_2']   = $home_score_2;
        $final_game_array[$season_id]['guest_score_2']  = $guest_score_2;
    }
}

foreach ($final_game_array as $item)
{
    $home_score     = $item['home_score_1'] + $item['home_score_2'];
    $guest_score    = $item['guest_score_1'] + $item['guest_score_2'];
    $season_id      = $item['season_id'];

    if ($home_score > $guest_score)
    {
        $looser_id          = $item['guest_team_id'];
        $looser_name        = $item['guest_team_name'];
        $looser_city        = $item['guest_city_name'];
        $looser_country     = $item['guest_country_name'];
        $winner_id          = $item['home_team_id'];
        $winner_name        = $item['home_team_name'];
        $winner_city        = $item['home_city_name'];
        $winner_country     = $item['home_country_name'];
    }
    else
    {
        $looser_id          = $item['home_team_id'];
        $looser_name        = $item['home_team_name'];
        $looser_city        = $item['home_city_name'];
        $looser_country     = $item['home_country_name'];
        $winner_id          = $item['guest_team_id'];
        $winner_name        = $item['guest_team_name'];
        $winner_city        = $item['guest_city_name'];
        $winner_country     = $item['guest_country_name'];
    }

    $winner_array[] = array
    (
        'shedule_season_id' => $season_id,
        'looser_id'         => $looser_id,
        'looser_name'       => $looser_name,
        'looser_city'       => $looser_city,
        'looser_country'    => $looser_country,
        'winner_id'         => $winner_id,
        'winner_name'       => $winner_name,
        'winner_city'       => $winner_city,
        'winner_country'    => $winner_country,
    );
}

$num            = $get_num;
$header_title   = $tournament_name;

include (__DIR__ . '/view/main.php');