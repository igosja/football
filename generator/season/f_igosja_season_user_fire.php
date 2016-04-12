<?php

function f_igosja_season_user_fire()
{
    $sql = "SELECT `team_id`,
                   `user_id`
            FROM `team`
            LEFT JOIN `user`
            ON `user_id`=`team_user_id`
            WHERE `user_last_visit`<NOW()-INTERVAL 14 DAY
            ORDER BY `team_id` ASC";
    $user_sql = f_igosja_mysqli_query($sql);

    $count_user = $user_sql->num_rows;
    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_user; $i++)
    {
        $user_id = $user_array[$i]['user_id'];
        $team_id = $user_array[$i]['team_id'];

        $sql = "UPDATE `team`
                SET `team_user_id`='0'
                WHERE `team_id`='$team_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        f_igosja_history(2, $user_id, 0, $team_id);
    }
}