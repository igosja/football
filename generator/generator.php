<?php

set_time_limit(0);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/generator/function.php');

f_igosja_generator_lineup_current_create();
f_igosja_generator_lineup_current_check_and_fill();
f_igosja_generator_lineup_current_to_lineup();
f_igosja_generator_lineup_current_auto_reset();
f_igosja_generator_lineup_to_disqualification();
f_igosja_generator_lineup_to_statistic();
f_igosja_generator_referee_to_statistic();
f_igosja_generator_team_to_statistic();
f_igosja_generator_user_to_statistic();
//f_igosja_generator_game_result();

print '<br/>Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br/>Потребление памяти (байт): ' . number_format(memory_get_usage(), 0, ",", " ");