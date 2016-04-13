<?php

function f_igosja_season_cup_most_titled_record()
{
    global $igosja_season_id;

    $sql = "SELECT `game_tournament_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE `shedule_season_id`='$igosja_season_id'
            AND `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP. "'
            AND `game_stage_id`='" . CUP_FINAL_STAGE . "'
            ORDER BY `game_tournament_id` ASC";
    $tournament_sql = f_igosja_mysqli_query($sql);

    $count_tournament = $tournament_sql->num_rows;
    $tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_tournament; $i++)
    {
        $tournament_id = $tournament_array[$i]['game_tournament_id'];

        $sql = "SELECT IF(`game_home_score`+`game_home_shoot_out`>`game_guest_score`+`game_guest_shoot_out`, `game_home_team_id`, `game_guest_team_id`) AS `winner_id`,
                       COUNT(`game_id`) AS `count`
                FROM `game`
                WHERE `game_stage_id`='" . CUP_FINAL_STAGE . "'
                AND `game_tournament_id`='$tournament_id'
                ORDER BY `count` DESC
                LIMIT 1";
        $winner_sql = f_igosja_mysqli_query($sql);

        $winner_array = $winner_sql->fetch_all(MYSQLI_ASSOC);

        $winner_id      = $winner_array[0]['winner_id'];
        $winner_count   = $winner_array[0]['count'];

        $sql = "SELECT `recordtournament_value_1`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$tournament_id'
                AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_TITLED . "'
                LIMIT 1";
        $record_sql = f_igosja_mysqli_query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_TITLED . "',
                        `recordtournament_team_id`='$winner_id',
                        `recordtournament_tournament_id`='$tournament_id',
                        `recordtournament_value_1`='$winner_count'";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
            $record_score = $record_array[$i]['recordtournament_value_1'];

            if ($winner_count > $record_score)
            {
                $sql = "UPDATE `recordtournament`
                        SET `recordtournament_value_1`='$winner_count',
                            `recordtournament_team_id`='$winner_id'
                        WHERE `recordtournament_tournament_id`='$tournament_id'
                        AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_MOST_TITLED . "'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}