<?php

function f_igosja_season_worldcup_most_titled_record()
{
    global $igosja_season_id;

    $sql = "SELECT `worldcup_tournament_id`
            FROM `worldcup`
            WHERE `worldcup_season_id`='$igosja_season_id'
            ORDER BY `worldcup_tournament_id` ASC";
    $tournament_sql = f_igosja_mysqli_query($sql);

    $count_tournament = $tournament_sql->num_rows;
    $tournament_array = $tournament_sql->fetch_all(1);

    for ($i=0; $i<$count_tournament; $i++)
    {
        $tournament_id = $tournament_array[$i]['worldcup_tournament_id'];

        $sql = "SELECT COUNT(`worldcup_id`) AS `count`,
                       `worldcup_country_id`
                FROM `worldcup`
                WHERE `worldcup_place`='1'
                AND `worldcup_tournament_id`='$tournament_id'
                GROUP BY `worldcup_country_id`
                ORDER BY `count` DESC
                LIMIT 1";
        $winner_sql = f_igosja_mysqli_query($sql);

        $winner_array = $winner_sql->fetch_all(1);

        $winner_id      = $winner_array[0]['worldcup_country_id'];
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
            $record_array = $record_sql->fetch_all(1);
            $record_score = $record_array[0]['recordtournament_value_1'];

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