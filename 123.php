<?php

include (__DIR__ . '/include/include.php');

print '<pre>';

for ($i=0; $i<2; $i++) //Вратарям ставим меньше беготни и передач
{
    $if_sql = "(IF(`lineup_in`='0', IF(`lineup_out`='0', '1', (`lineup_out`)/'100'), ('90'-`lineup_in`)/'100'))";

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
`lineup_mark`='5'+RAND()+RAND()+RAND()+RAND()+RAND(),
`lineup_pass`=" . $pass . " * " . $if_sql . ",
`lineup_pass_accurate`=" . $accurate . " * " . $if_sql . "
WHERE `shedule_date`=CURDATE()
AND `game_played`='0'
AND (`lineup_position_id`" . $position . "
OR `lineup_in`!='0')";
    print $sql . '<br/><br/><br/>';
}

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';