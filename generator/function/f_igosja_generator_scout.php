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
    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_team; $i++)
    {
        $team_id        = $team_array[$i]['team_id'];
        $reputation     = $team_array[$i]['staff_reputation'];
        $training_level = $team_array[$i]['team_training_level'];
        $limit          = $reputation * $training_level;

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
}