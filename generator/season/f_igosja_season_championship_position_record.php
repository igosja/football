<?php

function f_igosja_season_championship_position_record()
{
    global $igosja_season_id;

    $sql = "SELECT `standing_tournament_id`
            FROM `standing`
            WHERE `standing_season_id`='$igosja_season_id'
            GROUP BY `standing_tournament_id`
            ORDER BY `standing_tournament_id` ASC";
    $tournament_sql = f_igosja_mysqli_query($sql);

    $count_tournament = $tournament_sql->num_rows;
    $tournament_array = $tournament_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_tournament; $i++)
    {
        $tournament_id = $tournament_array[$i]['standing_tournament_id'];

        $sql = "SELECT `standing_place`,
                       `standing_team_id`
                FROM `standing`
                WHERE `standing_tournament_id`='$tournament_id'
                AND `standing_season_id`='$igosja_season_id'
                ORDER BY `standing_place` ASC";
        $team_sql = f_igosja_mysqli_query($sql);

        $count_team = $team_sql->num_rows;
        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_team; $j++)
        {
            $team_id    = $team_array[$j]['standing_team_id'];
            $place      = $team_array[$j]['standing_place'];

            $sql = "SELECT `recordteam_value`
                    FROM `recordteam`
                    WHERE `recordteam_team_id`='$team_id'
                    AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_HIGHEST_POSITION . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordteam`
                        SET `recordteam_recordteamtype_id`='" . RECORD_TEAM_HIGHEST_POSITION . "',
                            `recordteam_team_id`='$team_id',
                            `recordteam_tournament_id`='$tournament_id',
                            `recordteam_value`='$place'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
                $record_place = $record_array[0]['recordteam_value'];

                if ($place < $record_place ||
                    0 == $record_place)
                {
                    $sql = "UPDATE `recordteam`
                            SET `recordteam_value`='$place',
                                `recordteam_tournament_id`='$tournament_id'
                            WHERE `recordteam_recordteamtype_id`='" . RECORD_TEAM_HIGHEST_POSITION . "'
                            AND `recordteam_team_id`='$team_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }

            $sql = "SELECT `recordteam_value`
                    FROM `recordteam`
                    WHERE `recordteam_team_id`='$team_id'
                    AND `recordteam_recordteamtype_id`='" . RECORD_TEAM_LOWEST_POSITION . "'
                    LIMIT 1";
            $record_sql = f_igosja_mysqli_query($sql);

            $count_record = $record_sql->num_rows;

            if (0 == $count_record)
            {
                $sql = "INSERT INTO `recordteam`
                        SET `recordteam_recordteamtype_id`='" . RECORD_TEAM_LOWEST_POSITION . "',
                            `recordteam_team_id`='$team_id',
                            `recordteam_tournament_id`='$tournament_id',
                            `recordteam_value`='$place'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $record_array = $record_sql->fetch_all(MYSQLI_ASSOC);
                $record_place = $record_array[0]['recordteam_value'];

                if ($place > $record_place ||
                    0 == $record_place)
                {
                    $sql = "UPDATE `recordteam`
                            SET `recordteam_value`='$place',
                                `recordteam_tournament_id`='$tournament_id'
                            WHERE `recordteam_recordteamtype_id`='" . RECORD_TEAM_LOWEST_POSITION . "'
                            AND `recordteam_team_id`='$team_id'
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }
    }
}