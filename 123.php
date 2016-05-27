<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `game_guest_penalty`,
               `game_guest_score`,
               `game_guest_team_id`"

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';