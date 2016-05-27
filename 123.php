<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `game_id`,
               `game_guest_penalty`,
               `game_guest_score`,
               `game_guest_team_id`,
               `game_home_penalty`,
               `game_home_score`,
               `game_home_team_id`,
               `game_tournament_id`
        FROM `game`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        WHERE `game_played`='1'
        AND `shedule_date`<CURDATE()
        ORDER BY `game_id`";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;
$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_game; $i++)
{
    $game_id        = $game_array[$i]['game_id'];
    $tournament_id  = $game_array[$i]['game_tournament_id'];
    $home_team_id   = $game_array[$i]['game_home_team_id'];
    $guest_team_id  = $game_array[$i]['game_guest_team_id'];
    $home_penalty   = $game_array[$i]['game_home_penalty'];
    $home_score     = $game_array[$i]['game_home_score'];
    $guest_penalty  = $game_array[$i]['game_guest_penalty'];
    $guest_score    = $game_array[$i]['game_guest_score'];

    $sql = "SELECT `lineup_id`,
                   `lineup_player_id`
            FROM `lineup`
            WHERE `lineup_team_id`='$home_team_id'
            AND `lineup_game_id`='$game_id'
            AND `lineup_position_id`='1'";
    $home_gk_sql = $mysqli->query($sql);

    $home_gk_array = $home_gk_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `lineup_id`,
                   `lineup_player_id`
            FROM `lineup`
            WHERE `lineup_team_id`='$guest_team_id'
            AND `lineup_game_id`='$game_id'
            AND `lineup_position_id`='1'";
    $guest_gk_sql = $mysqli->query($sql);

    $guest_gk_array = $guest_gk_sql->fetch_all(MYSQLI_ASSOC);

    $home_lineup_id     = $home_gk_array[0]['lineup_id'];
    $home_player_id     = $home_gk_array[0]['lineup_player_id'];
    $guest_lineup_id    = $guest_gk_array[0]['lineup_id'];
    $guest_player_id    = $guest_gk_array[0]['lineup_player_id'];

    for ($j=0; $j<$home_penalty; $j++)
    {
        $sql = "UPDATE `statisticplayer`
                SET `statisticplayer_goal`=`statisticplayer_goal`-'1',
                    `statisticplayer_penalty_goal`=`statisticplayer_penalty_goal`-'1'
                WHERE `statisticplayer_player_id`='$guest_player_id'
                AND `statisticplayer_season_id`='$igosja_season_id'
                AND `statisticplayer_tournament_id`='$tournament_id'
                AND `statisticplayer_team_id`='$guest_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_goal`=`lineup_goal`-'1',
                    `lineup_penalty_goal`=`lineup_penalty_goal`-'1'
                WHERE `lineup_id`='$guest_lineup_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$home_score; $j++)
    {
        $sql = "UPDATE `statisticplayer`
                SET `statisticplayer_goal`=`statisticplayer_goal`-'1'
                WHERE `statisticplayer_player_id`='$guest_player_id'
                AND `statisticplayer_season_id`='$igosja_season_id'
                AND `statisticplayer_tournament_id`='$tournament_id'
                AND `statisticplayer_team_id`='$guest_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_goal`=`lineup_goal`-'1'
                WHERE `lineup_id`='$guest_lineup_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$guest_penalty; $j++)
    {
        $sql = "UPDATE `statisticplayer`
                SET `statisticplayer_goal`=`statisticplayer_goal`-'1',
                    `statisticplayer_penalty_goal`=`statisticplayer_penalty_goal`-'1'
                WHERE `statisticplayer_player_id`='$home_player_id'
                AND `statisticplayer_season_id`='$igosja_season_id'
                AND `statisticplayer_tournament_id`='$tournament_id'
                AND `statisticplayer_team_id`='$home_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_goal`=`lineup_goal`-'1',
                    `lineup_penalty_goal`=`lineup_penalty_goal`-'1'
                WHERE `lineup_id`='$home_lineup_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    for ($j=0; $j<$guest_score; $j++)
    {
        $sql = "UPDATE `statisticplayer`
                SET `statisticplayer_goal`=`statisticplayer_goal`-'1'
                WHERE `statisticplayer_player_id`='$home_player_id'
                AND `statisticplayer_season_id`='$igosja_season_id'
                AND `statisticplayer_tournament_id`='$tournament_id'
                AND `statisticplayer_team_id`='$home_team_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `lineup`
                SET `lineup_goal`=`lineup_goal`-'1'
                WHERE `lineup_id`='$home_lineup_id'
                LIMIT 1";
        $mysqli->query($sql);
    }
}

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';