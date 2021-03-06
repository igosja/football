<?php

function f_igosja_generator_make_injury()
//Добавляем травмы парочке игроков
{
    $sql = "SELECT COUNT(`game_id`) AS `count`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `tournament`
            ON `tournament_id`=`game_tournament_id`
            WHERE `game_played`='0'
            AND `tournament_tournamenttype_id`='" . TOURNAMENT_TYPE_CHAMPIONSHIP . "'
            AND `shedule_date`=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(1);
    $count_game = $game_array[0]['count'];

    if (0 != $count_game)
    {
        $sql = "SELECT `team_id`
                FROM `team`
                WHERE `team_id` NOT IN
                (
                    SELECT `player_team_id`
                    FROM `player`
                    WHERE `player_injury`!='0'
                )
                AND `team_id`!='0'
                ORDER BY RAND()
                LIMIT 1";
        $team_sql = f_igosja_mysqli_query($sql);

        $count_team = $team_sql->num_rows;

        if (0 != $count_team)
        {
            $team_array = $team_sql->fetch_all(1);

            $team_id = $team_array[0]['team_id'];

            $sql = "SELECT `lineup_player_id`,
                           `staff_reputation`
                    FROM `lineup`
                    LEFT JOIN `game`
                    ON `lineup_game_id`=`game_id`
                    LEFT JOIN `shedule`
                    ON `shedule_id`=`game_shedule_id`
                    LEFT JOIN `staff`
                    ON `staff_team_id`=`lineup_team_id`
                    WHERE `lineup_team_id`='$team_id'
                    AND `shedule_date`=CURDATE()
                    AND `game_played`='0'
                    AND `staff_staffpost_id`='" . STAFFPOST_DOCTOR . "'
                    AND `lineup_player_id`!='0'
                    ORDER BY `lineup_condition` ASC
                    LIMIT 1";
            $player_sql = f_igosja_mysqli_query($sql);

            $player_array = $player_sql->fetch_all(1);

            $player_id  = $player_array[0]['lineup_player_id'];
            $reputation = $player_array[0]['staff_reputation'];

            $sql = "SELECT `injurytype_id`,
                           `injurytype_day`
                    FROM `injurytype`
                    ORDER BY RAND()
                    LIMIT 1";
            $injurytype_sql = f_igosja_mysqli_query($sql);

            $injurytype_array = $injurytype_sql->fetch_all(1);

            $injurytype_id  = $injurytype_array[0]['injurytype_id'];
            $injurytype_day = $injurytype_array[0]['injurytype_day'];
            $injurytype_day = round($injurytype_day - $reputation / 100);

            if (0 >= $injurytype_day)
            {
                $injurytype_day = 1;
            }

            $sql = "UPDATE `player`
                    SET `player_injury`='1'
                    WHERE `player_id`='$player_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "INSERT INTO `injury`
                    SET `injury_end_date`=UNIX_TIMESTAMP() + $injurytype_day * 60 * 60,
                        `injury_injurytype_id`='$injurytype_id',
                        `injury_player_id`='$player_id',
                        `injury_start_date`=UNIX_TIMESTAMP()";
            f_igosja_mysqli_query($sql);
        }
    }

    usleep(1);

    print '.';
    flush();
}