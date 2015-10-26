<?php

set_time_limit(0);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/include/generator.php');

f_igosja_generator_lineup_current_create();

sleep(1);

print '.';
flush();

sleep(1);

f_igosja_generator_lineup_current_fill_auto();

print '.';
flush();

sleep(1);

f_igosja_generator_lineup_current_clean();

print '.';
flush();

sleep(1);

f_igosja_generator_lineup_current_check();

sleep(1);

print '.';
flush();

sleep(1);

f_igosja_generator_lineup_current_to_lineup();

print '.';
flush();

sleep(1);

f_igosja_generator_lineup_to_disqualification();

print '.';
flush();

sleep(1);

f_igosja_generator_lineup_to_statistic();

print '.';
flush();

sleep(1);

f_igosja_generator_referee_to_statistic();

print '.';
flush();

sleep(1);

f_igosja_generator_team_to_statistic();

print '.';
flush();

sleep(1);

f_igosja_generator_user_to_statistic();

print '.';
flush();

sleep(1);

f_igosja_generator_disqualification_decrease();

print '.';
flush();

sleep(1);

f_igosja_generator_visitor();

print '.';
flush();

sleep(1);

for ($i=1; $i<=90; $i=$i+2)
{
    f_igosja_generator_game_result($i);

    if (0 == $i%4)
    {
        f_igosja_generator_game_tire();
    }

    print '.';
    flush();

    sleep(1);
}

f_igosja_generator_statistic_player();

print '.';
flush();

sleep(1);

f_igosja_generator_player_condition_practice();

print '.';
flush();

sleep(1);

f_igosja_generator_statistic_team_user_referee();

print '.';
flush();

sleep(1);

f_igosja_generator_standing();

print '.';
flush();

sleep(1);

f_igosja_generator_game_series();

print '.';
flush();

sleep(1);

f_igosja_generator_team_series_to_record();

print '.';
flush();

sleep(1);

f_igosja_generator_tornament_series_to_record();

print '.';
flush();

sleep(1);

f_igosja_generator_make_played();

print '<br/>Ready';