<?php

include (__DIR__ . '/include/include.php');

$sql = "UPDATE `game`
        SET `game_home_possession`='30',
            `game_guest_possession`='100'-`game_home_possession`
        WHERE `game_home_possession`<'30'
        AND `game_played`='1'";
$mysqli->query($sql);

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';