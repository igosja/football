<?php

function f_igosja_generator_injury_after_game()
//Снятие травм у вылечившихся
{
    $sql = "UPDATE `injury`
            LEFT JOIN `player`
            ON `injury_player_id`=`player_id`
            SET `player_injury`='0'
            WHERE `injury_end_date`<=CURDATE()";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}