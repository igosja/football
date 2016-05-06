<?php

function f_igosja_generator_injury_after_game()
//Снятие травм у вылечившихся
{
    $sql = "UPDATE `injury`
            LEFT JOIN `player`
            ON `injury_player_id`=`player_id`
            SET `player_injury`='0'
            WHERE `injury_end_date`<=UNIX_TIMESTAMP()";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `injury`
            LEFT JOIN `player`
            ON `injury_player_id`=`player_id`
            SET `player_injury`='1'
            WHERE `injury_end_date`>UNIX_TIMESTAMP()";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_condition`='50'
            WHERE `player_injury`='1'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}