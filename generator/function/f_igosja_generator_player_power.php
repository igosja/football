<?php

function f_igosja_generator_player_power()
//Сила игроков
{
    $sql = "UPDATE `player`
            LEFT JOIN
            (
                SELECT `playerattribute_player_id`,
                       SUM(`playerattribute_value`) AS `power`
                FROM `playerattribute`
                GROUP BY `playerattribute_player_id`
            ) AS `t1`
            ON `player_id`=`playerattribute_player_id`
            SET `player_power`=`power`
            WHERE `player_id`!='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}