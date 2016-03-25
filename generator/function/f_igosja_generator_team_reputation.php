<?php

function f_igosja_generator_team_reputation()
//Репутация команд
{
    $sql = "UPDATE `team`
            LEFT JOIN
            (
                SELECT COUNT(`player_id`) AS `count_player`,
                       SUM(`player_reputation`) AS `player_reputation`,
                       `player_team_id`
                FROM `player`
                WHERE `player_team_id`!='0'
                AND `player_rent_team_id`='0'
                GROUP BY `player_team_id`
            ) AS `t1`
            ON `team_id`=`player_team_id`
            SET `team_reputation`=`player_reputation`/`count_player`
            WHERE `team_id`!='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}