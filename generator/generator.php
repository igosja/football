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
f_igosja_generator_disqualification_decrease();
f_igosja_generator_visitor();
f_igosja_generator_game_result();
f_igosja_generator_lineup_mark_distance();
f_igosja_generator_lineup_statisticplayer_after_game_and_event();
f_igosja_generator_statisticplayer();
f_igosja_generator_best_player();
f_igosja_generator_statistic_team_user_referee();
f_igosja_generator_player_condition_practice();
f_igosja_generator_standing();
f_igosja_generator_standing_history();
f_igosja_generator_game_series();
f_igosja_generator_team_series_to_record();
f_igosja_generator_tournament_series_to_record();
f_igosja_generator_team_record();
f_igosja_generator_tournament_record();
f_igosja_generator_mood_after_game();
f_igosja_generator_injury_after_game();
f_igosja_generator_training();
f_igosja_generator_player_salary();
f_igosja_generator_staff_salary();
f_igosja_generator_finance();
f_igosja_generator_make_played();

print '<br/>Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br/>Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';