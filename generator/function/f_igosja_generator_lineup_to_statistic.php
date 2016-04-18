<?php

function f_igosja_generator_lineup_to_statistic()
//Добавляем игроков в статистические таблицы
{
    global $igosja_season_id;

    $sql = "SELECT `game_tournament_id`,
                   `lineup_player_id`,
                   `lineup_team_id`,
                   `statisticplayer_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineup`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN
            (
                SELECT `statisticplayer_id`,
                       `statisticplayer_player_id`,
                       `statisticplayer_team_id`,
                       `statisticplayer_tournament_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_season_id`='$igosja_season_id'
            ) AS `t1`
            ON (`statisticplayer_player_id`=`lineup_player_id`
            AND `statisticplayer_tournament_id`=`game_tournament_id`
            AND `statisticplayer_team_id`=`lineup_team_id`)
            WHERE `game_played`='0'
            AND `lineup_team_id`!='0'
            AND `lineup_player_id`!='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $lineup_sql = f_igosja_mysqli_query($sql);

    $count_lineup = $lineup_sql->num_rows;
    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_lineup; $i++)
    {
        $statisticplayer_id = $lineup_array[$i]['statisticplayer_id'];

        if (!$statisticplayer_id)
        {
            $player_id      = $lineup_array[$i]['lineup_player_id'];
            $team_id        = $lineup_array[$i]['lineup_team_id'];

            if (0 != $team_id)
            {
                $tournament_id  = $lineup_array[$i]['game_tournament_id'];

                $sql = "INSERT INTO `statisticplayer`
                                SET `statisticplayer_player_id`='$player_id',
                                    `statisticplayer_tournament_id`='$tournament_id',
                                    `statisticplayer_season_id`='$igosja_season_id',
                                    `statisticplayer_team_id`='$team_id'";
                f_igosja_mysqli_query($sql);
            }
        }

        usleep(1);

        print '.';
        flush();
    }

    $sql = "SELECT `game_tournament_id`,
                   `lineup_player_id`,
                   `lineup_country_id`,
                   `statisticplayer_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineup`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN
            (
                SELECT `statisticplayer_id`,
                       `statisticplayer_player_id`,
                       `statisticplayer_country_id`,
                       `statisticplayer_tournament_id`
                FROM `statisticplayer`
                WHERE `statisticplayer_season_id`='$igosja_season_id'
            ) AS `t1`
            ON (`statisticplayer_player_id`=`lineup_player_id`
            AND `statisticplayer_tournament_id`=`game_tournament_id`
            AND `statisticplayer_country_id`=`lineup_country_id`)
            WHERE `game_played`='0'
            AND `lineup_country_id`!='0'
            AND `lineup_player_id`!='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $lineup_sql = f_igosja_mysqli_query($sql);

    $count_lineup = $lineup_sql->num_rows;
    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_lineup; $i++)
    {
        $statisticplayer_id = $lineup_array[$i]['statisticplayer_id'];

        if (!$statisticplayer_id)
        {
            $player_id      = $lineup_array[$i]['lineup_player_id'];
            $country_id     = $lineup_array[$i]['lineup_country_id'];
            $tournament_id  = $lineup_array[$i]['game_tournament_id'];

            $sql = "INSERT INTO `statisticplayer`
                    SET `statisticplayer_player_id`='$player_id',
                        `statisticplayer_tournament_id`='$tournament_id',
                        `statisticplayer_season_id`='$igosja_season_id',
                        `statisticplayer_country_id`='$country_id'";
            f_igosja_mysqli_query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}