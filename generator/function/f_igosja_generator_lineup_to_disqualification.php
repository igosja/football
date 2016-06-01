<?php

function f_igosja_generator_lineup_to_disqualification()
//Добавляем игроков в таблицы дисквалификации
{
    $sql = "SELECT `disqualification_id`,
                   `game_tournament_id`,
                   `lineup_player_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `lineup`
            ON `game_id`=`lineup_game_id`
            LEFT JOIN
            (
                SELECT `disqualification_id`,
                       `disqualification_player_id`,
                       `disqualification_tournament_id`
                FROM `disqualification`
            ) AS `t1`
            ON `disqualification_player_id`=`lineup_player_id`
            AND `disqualification_tournament_id`=`game_tournament_id`
            WHERE `game_played`='0'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $lineup_sql = f_igosja_mysqli_query($sql);

    $count_lineup = $lineup_sql->num_rows;
    $lineup_array = $lineup_sql->fetch_all(1);

    for ($i=0; $i<$count_lineup; $i++)
    {
        $disqualification_id = $lineup_array[$i]['disqualification_id'];

        if (!$disqualification_id)
        {
            $tournament_id  = $lineup_array[$i]['game_tournament_id'];
            $player_id      = $lineup_array[$i]['lineup_player_id'];

            $sql = "INSERT INTO `disqualification`
                    SET `disqualification_player_id`='$player_id',
                        `disqualification_tournament_id`='$tournament_id'";
            f_igosja_mysqli_query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}