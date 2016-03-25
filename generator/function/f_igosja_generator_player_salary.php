<?php

function f_igosja_generator_player_salary()
//Зарплата игроков
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
            SET `player_salary`=ROUND(POW(`power`, 1.3)),
                `player_price`=`player_salary`*'987',
                `player_reputation`=`power`/'" . MAX_PLAYER_POWER . "'*'100'
            WHERE `player_id`!='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}