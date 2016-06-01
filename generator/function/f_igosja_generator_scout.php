<?php

function f_igosja_generator_scout()
//Изучение игроков скаутами
{
    $sql = "SELECT `staff_reputation`,
                   `team_id`,
                   `team_training_level`
            FROM `team`
            LEFT JOIN `staff`
            ON `staff_team_id`=`team_id`
            WHERE `team_id`!='0'
            AND `staff_staffpost_id`='" . STAFFPOST_SCOUT . "'";
    $team_sql = f_igosja_mysqli_query($sql);

    $count_team = $team_sql->num_rows;
    $team_array = $team_sql->fetch_all(1);

    for ($i=0; $i<$count_team; $i++)
    {
        $team_id        = $team_array[$i]['team_id'];
        $reputation     = $team_array[$i]['staff_reputation'];
        $training_level = $team_array[$i]['team_training_level'];
        $limit          = $reputation * $training_level;

        $sql = "SELECT `scoutnearest_id`,
                       `scoutnearest_player_id`
                FROM `scoutnearest`
                WHERE `scoutnearest_team_id`='$team_id'
                LIMIT $limit";
        $scout_sql = f_igosja_mysqli_query($sql);

        $count_scout = $scout_sql->num_rows;
        $scout_array = $scout_sql->fetch_all(1);

        for ($j=0; $j<$count_scout; $j++)
        {
            $player_id  = $scout_array[$j]['scoutnearest_player_id'];
            $scout_id   = $scout_array[$j]['scoutnearest_id'];

            $sql = "INSERT INTO `scout`
                    SET `scout_team_id`='$team_id',
                        `scout_player_id`='$player_id'";
            f_igosja_mysqli_query($sql);

            $sql = "DELETE FROM `scoutnearest`
                    WHERE `scoutnearest_id`='$scout_id'";
            f_igosja_mysqli_query($sql);
        }

        $limit = $limit - $count_scout;

        $sql = "INSERT INTO `scout` (`scout_team_id`, `scout_player_id`)
                SELECT '$team_id', `player_id`
                FROM `player`
                WHERE `player_id` NOT IN
                (
                    SELECT `scout_player_id`
                    FROM `scout`
                    WHERE `scout_team_id`='$team_id'
                )
                AND `player_team_id`!='0'
                ORDER BY `player_price` DESC
                LIMIT $limit";
        f_igosja_mysqli_query($sql);

        usleep(1);

        print '.';
        flush();
    }

    $sql = "SELECT COUNT(`scoutnearest_id`) AS `count`
            FROM `scoutnearest`";
    $scout_sql = f_igosja_mysqli_query($sql);

    $scout_array = $scout_sql->fetch_all(1);

    $count_scout = $scout_array[0]['count'];

    if (0 == $count_scout)
    {
        $sql = "TRUNCATE `scoutnearest`";
        f_igosja_mysqli_query($sql);
    }
}