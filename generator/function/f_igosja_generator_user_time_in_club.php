<?php

function f_igosja_generator_user_time_in_club()
//Наибольшее время в клубе
{
    $sql = "UPDATE `team`
            LEFT JOIN
            (
                SELECT ROUND((UNIX_TIMESTAMP() - MAX(`history_date`)) / 60 / 60 / 24) AS `day`,
                       MAX(`history_date`) AS `history_date`,
                       `history_user_id`
                FROM `history`
                WHERE `history_historytext_id`='1'
                GROUP BY `history_user_id`
                ORDER BY `history_id` ASC
            ) AS `t1`
            ON `history_user_id`=`team_user_id`
            LEFT JOIN `user`
            ON `user_id`=`team_user_id`
            SET `user_team_time_max`=IF (`user_team_time_max`>`day`, `user_team_time_max`, `day`)
            WHERE `team_user_id`!='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}