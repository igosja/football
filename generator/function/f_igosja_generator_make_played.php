<?php

function f_igosja_generator_make_played()
//Делаем матчи сыграными
{
    $sql = "UPDATE `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            SET `game_played`='1'
            WHERE `shedule_date`=CURDATE()";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}