<?php

set_time_limit(0);

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/include/generator.php');

f_igosja_generator_lineup_current_create();

usleep(1);

print '.';
flush();

usleep(1);

f_igosja_generator_lineup_current_fill_auto();

print '.';
flush();

usleep(1);

f_igosja_generator_lineup_current_clean();

print '.';
flush();

usleep(1);

f_igosja_generator_lineup_current_check();

usleep(1);

print '.';
flush();

usleep(1);

f_igosja_generator_lineup_current_to_lineup();

print '.';
flush();

usleep(1);

f_igosja_generator_lineup_to_disqualification();

print '.';
flush();

usleep(1);

f_igosja_generator_lineup_to_statistic();

print '.';
flush();

usleep(1);

f_igosja_generator_referee_to_statistic();

print '.';
flush();

usleep(1);

f_igosja_generator_team_to_statistic();

print '.';
flush();

usleep(1);

f_igosja_generator_user_to_statistic();

print '.';
flush();

usleep(1);

f_igosja_generator_disqualification_decrease();

print '.';
flush();

usleep(1);

f_igosja_generator_visitor();

print '.';
flush();

usleep(1);

for ($i=1; $i<=90; $i=$i+2)
{
    f_igosja_generator_game_result($i);

    if (0 == $i%4)
    {
        f_igosja_generator_game_tire();
    }

    print '.';
    flush();

    usleep(1);
}

f_igosja_generator_game_moments();

print '.';
flush();

usleep(1);

f_igosja_generator_game_offside();

print '.';
flush();

usleep(1);

f_igosja_generator_referee_mark();

print '.';
flush();

usleep(1);

f_igosja_generator_statistic_player();

print '.';
flush();

usleep(1);

f_igosja_generator_player_condition_practice();

print '.';
flush();

usleep(1);

f_igosja_generator_statistic_team_user_referee();

print '.';
flush();

usleep(1);

f_igosja_generator_standing();

print '.';
flush();

usleep(1);

f_igosja_generator_standing_history();

print '.';
flush();

usleep(1);

f_igosja_generator_game_series();

print '.';
flush();

usleep(1);

f_igosja_generator_team_series_to_record();

print '.';
flush();

usleep(1);

f_igosja_generator_tournament_series_to_record();

print '.';
flush();

usleep(1);

f_igosja_generator_team_record();

print '.';
flush();

usleep(1);

f_igosja_generator_tournament_record();

print '.';
flush();

usleep(1);

f_igosja_generator_mood_after_game();

print '.';
flush();

usleep(1);

f_igosja_generator_injury_after_game();

print '.';
flush();

usleep(1);

f_igosja_generator_make_played();

print '.';
flush();

usleep(1);

f_igosja_generator_training();

print '<br/>Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек.';
print '<br/>Потребление памяти (байт): ' . number_format(memory_get_usage(), 0, ",", " ");
