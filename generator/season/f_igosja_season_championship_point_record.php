<?php

function f_igosja_season_championship_point_record()
{
    global $igosja_season_id;

    $sql = "SELECT `standing_point`,
                   `standing_score`,
                   `standing_team_id`,
                   `standing_tournament_id`
            FROM `standing`
            WHERE `standing_place`='1'
            ORDER BY `standing_id` ASC";
    $standing_sql = f_igosja_mysqli_query($sql);

    $count_standing = $standing_sql->num_rows;
    $standing_array = $standing_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_standing; $i++)
    {
        $point          = $standing_array[$i]['standing_point'];
        $score          = $standing_array[$i]['standing_score'];
        $team_id        = $standing_array[$i]['standing_team_id'];
        $tournament_id  = $standing_array[$i]['standing_tournament_id'];

        $sql = "SELECT `recordtournament_value_1`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$tournament_id'
                AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_POINT . "'
                LIMIT 1";
        $record_sql = f_igosja_mysqli_query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_POINT . "',
                        `recordtournament_season_id`='$igosja_season_id',
                        `recordtournament_team_id`='$team_id',
                        `recordtournament_tournament_id`='$tournament_id',
                        `recordtournament_value_1`='$point'";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
            $record_point = $record_array[0]['recordtournament_value_1'];

            if ($point > $record_point)
            {
                $sql = "UPDATE `recordtournament`
                        SET `recordtournament_value_1`='$point',
                            `recordtournament_team_id`='$team_id',
                            `recordtournament_season_id`='$igosja_season_id'
                        WHERE `recordtournament_tournament_id`='$tournament_id'
                        AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_POINT . "'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }

        $sql = "SELECT `recordtournament_value_1`
                FROM `recordtournament`
                WHERE `recordtournament_tournament_id`='$tournament_id'
                AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_SCORE . "'
                LIMIT 1";
        $record_sql = f_igosja_mysqli_query($sql);

        $count_record = $record_sql->num_rows;

        if (0 == $count_record)
        {
            $sql = "INSERT INTO `recordtournament`
                    SET `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_SCORE . "',
                        `recordtournament_season_id`='$igosja_season_id',
                        `recordtournament_team_id`='$team_id',
                        `recordtournament_tournament_id`='$tournament_id',
                        `recordtournament_value_1`='$score'";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
            $record_score = $record_array[0]['recordtournament_value_1'];

            if ($score > $record_score)
            {
                $sql = "UPDATE `recordtournament`
                        SET `recordtournament_value_1`='$score',
                            `recordtournament_team_id`='$team_id',
                            `recordtournament_season_id`='$igosja_season_id'
                        WHERE `recordtournament_tournament_id`='$tournament_id'
                        AND `recordtournament_recordtournamenttype_id`='" . RECORD_TOURNAMENT_SCORE . "'
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}