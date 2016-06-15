<?php

function f_igosja_generator_lineup_distance()
//Добавляем доп данные в составы матча (дистанция, передачи, точность)
{
    for ($i=0; $i<2; $i++) //Вратарям ставим меньше беготни и передач
    {
        $if_sql = "(IF(`lineup_in`='0', IF(`lineup_out`='0', '1', (`lineup_out`)/'90'), ('90'-`lineup_in`)/'90'))";

        if (0 == $i)
        {
            $distance   = "('3000'+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()+'1000'*RAND()+'1000'*RAND())";
            $pass       = "('30'+'10'*RAND()+'10'*RAND()+'10'*RAND())";
            $accurate   = "('15'+'5'*RAND()+'5'*RAND()+'5'*RAND())";
            $position   = " BETWEEN '2' AND '25'";
        }
        else
        {
            $distance   = "('2000'+'1000'*RAND()+'1000'*RAND()+'1000'*RAND())";
            $pass       = "('15'+'2'*RAND()+'2'*RAND()+'2'*RAND())";
            $accurate   = "('9'+'2'*RAND()+'2'*RAND()+'2'*RAND())";
            $position   = "='1'";
        }

        $sql = "UPDATE `lineup`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                LEFT JOIN `player`
                ON `player_id`=`lineup_player_id`
                SET `lineup_distance`=" . $distance . " * " . $if_sql . ",
                    `lineup_pass`=" . $pass . " * " . $if_sql . ",
                    `lineup_pass_accurate`=" . $accurate . " * " . $if_sql . "
                WHERE `shedule_date`=CURDATE()
                AND `game_played`='0'
                AND (`lineup_position_id`" . $position . "
                OR `lineup_in`!='0')";
        f_igosja_mysqli_query($sql);

        usleep(1);

        print '.';
        flush();
    }
}