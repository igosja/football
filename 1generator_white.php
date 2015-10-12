<?php

set_time_limit(0);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/include/generator.php');

f_igosja_generator_lineup_current_create();

sleep(1);

print '.';
ob_flush();
flush();

sleep(1);

f_igosja_generator_lineup_current_fill_auto();

print '.';
ob_flush();
flush();

sleep(1);

f_igosja_generator_lineup_current_clean();

print '.';
ob_flush();
flush();

sleep(1);

f_igosja_generator_lineup_current_check();

sleep(1);

print '.';
ob_flush();
flush();

sleep(1);

f_igosja_generator_lineup_current_to_lineup();

print '.';
ob_flush();
flush();

sleep(1);

f_igosja_generator_lineup_to_disqualification();

print '.';
ob_flush();
flush();

sleep(1);

f_igosja_generator_lineup_to_statistic();

print '.';
ob_flush();
flush();

sleep(1);

f_igosja_generator_referee_to_statistic();

print '.';
ob_flush();
flush();

sleep(1);

f_igosja_generator_team_to_statistic();

print '.';
ob_flush();
flush();

sleep(1);

f_igosja_generator_user_to_statistic();

print '.';
ob_flush();
flush();

sleep(1);

for ($i=1; $i<=90; $i=$i+2)
{
    f_igosja_generator_game_result($i);

    print '.';
    ob_flush();
    flush();

    sleep(1);
}

f_igosja_generator_statistic_player();

print '.';
ob_flush();
flush();

sleep(1);

f_igosja_generator_player_condition_practice();

print '.';
ob_flush();
flush();

sleep(1);

f_igosja_generator_statistic_team_user_referee();

print '.';
ob_flush();
flush();

sleep(1);

f_igosja_generator_standing();

print '.';
ob_flush();
flush();

sleep(1);

f_igosja_generator_make_played();

print '<br/>Ready';