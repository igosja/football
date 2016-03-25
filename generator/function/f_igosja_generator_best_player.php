<?php

function f_igosja_generator_best_player()
//Вычисляем лучших игроков матча и в статистику
{
    global $igosja_season_id;

    $sql = "UPDATE `statisticplayer`
            LEFT JOIN
            (
                SELECT *
                FROM `lineup`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                GROUP BY `lineup_game_id`
                ORDER BY `lineup_mark` DESC
            ) AS `t1`
            ON `statisticplayer_player_id`=`lineup_player_id`
            AND `statisticplayer_tournament_id`=`game_tournament_id`
            AND `statisticplayer_team_id`=`lineup_team_id`
            SET `statisticplayer_best`=`statisticplayer_best`+'1'
            WHERE `statisticplayer_season_id`='$igosja_season_id'
            AND `lineup_team_id`!='0'
            AND `lineup_id` IS NOT NULL";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `statisticplayer`
            LEFT JOIN
            (
                SELECT *
                FROM `lineup`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                GROUP BY `lineup_game_id`
                ORDER BY `lineup_mark` DESC
            ) AS `t1`
            ON `statisticplayer_player_id`=`lineup_player_id`
            AND `statisticplayer_tournament_id`=`game_tournament_id`
            AND `statisticplayer_country_id`=`lineup_country_id`
            SET `statisticplayer_best`=`statisticplayer_best`+'1'
            WHERE `statisticplayer_season_id`='$igosja_season_id'
            AND `lineup_team_id`!='0'
            AND `lineup_id` IS NOT NULL";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}