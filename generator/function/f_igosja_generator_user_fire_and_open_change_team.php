<?php

function f_igosja_generator_user_fire_and_open_change_team()
//Увольняем давно не заходивших и даем возможность менять команды
{
    $sql = "SELECT `team_id`,
                   `user_id`
            FROM `team`
            LEFT JOIN `user`
            ON `user_id`=`team_user_id`
            WHERE `user_last_visit`<UNIX_TIMESTAMP() - 7 * 24 * 60 * 60
            AND `user_id`!='0'
            ORDER BY `team_id` ASC";
    $user_sql = f_igosja_mysqli_query($sql);

    $count_user = $user_sql->num_rows;
    $user_array = $user_sql->fetch_all(1);

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

        usleep(1);

        print '.';
        flush();
    }

    $sql = "SELECT `country_id`,
                   `user_id`
            FROM `country`
            LEFT JOIN `user`
            ON `user_id`=`country_user_id`
            WHERE `user_last_visit`<UNIX_TIMESTAMP() - 7 * 24 * 60 * 60
            AND `user_id`!='0'
            ORDER BY `country_id` ASC";
    $user_sql = f_igosja_mysqli_query($sql);

    $count_user = $user_sql->num_rows;
    $user_array = $user_sql->fetch_all(1);

    for ($i=0; $i<$count_user; $i++)
    {
        $user_id    = $user_array[$i]['user_id'];
        $country_id = $user_array[$i]['country_id'];

        $sql = "UPDATE `country`
                SET `country_user_id`='0'
                WHERE `country_id`='$country_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        f_igosja_history(2, $user_id, $country_id);

        usleep(1);

        print '.';
        flush();
    }

    $sql = "UPDATE `user`
            SET `user_change_team`='0'
            WHERE `user_change_team`='1'";
    f_igosja_mysqli_query($sql);
}