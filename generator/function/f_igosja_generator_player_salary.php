<?php

function f_igosja_generator_player_salary()
//Зарплата игроков
{
    $sql = "UPDATE `player`
            SET `player_salary`=ROUND(POW(`player_power`, 1.3)),
                `player_price`=`player_salary`*'987',
                `player_reputation`=`player_power`/'" . MAX_PLAYER_POWER . "'*'100'
            WHERE `player_id`!='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}