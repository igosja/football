<?php

set_time_limit(0);

include ('/../include/include.php');
include ('/../generator/function.php');

$current_time = round(microtime(true) - $start_time, 5);
print $current_time . ' - start<br/>';

f_igosja_generator_asktoplay_delete();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - asktoplay_delete<br/>';

f_igosja_generator_lineup_main_create();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - lineup_main_create<br/>';

f_igosja_generator_lineup_check_and_fill();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - lineup_check_and_fill<br/>';

f_igosja_generator_lineup_practice_and_condition();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - lineup_practice_and_condition<br/>';

f_igosja_generator_lineup_to_disqualification();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - lineup_to_disqualification<br/>';

f_igosja_generator_lineup_to_statistic();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - lineup_to_statistic<br/>';

f_igosja_generator_referee_to_statistic();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - referee_to_statistic<br/>';

f_igosja_generator_team_to_statistic();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - team_to_statistic<br/>';

f_igosja_generator_user_to_statistic();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - user_to_statistic<br/>';

f_igosja_generator_disqualification_decrease();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - disqualification_decrease<br/>';

f_igosja_generator_visitor();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - visitor<br/>';

f_igosja_generator_game_result();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - game_result<br/>';

f_igosja_generator_game_result_overtime();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - game_result_overtime<br/>';

f_igosja_generator_lineup_mark_distance();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - lineup_mark_distance<br/>';

f_igosja_generator_lineup_statisticplayer_after_game_and_event();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - lineup_statisticplayer_after_game_and_event<br/>';

f_igosja_generator_statisticplayer();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - statisticplayer<br/>';

f_igosja_generator_best_player();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - best_player<br/>';

f_igosja_generator_statistic_team_user_referee();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - statistic_team_user_referee<br/>';

f_igosja_generator_user_formation_gamemood_gamestyle();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - user_formation_gamemood_gamestyle<br/>';

f_igosja_generator_player_condition_practice();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - player_condition_practice<br/>';

f_igosja_generator_standing();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - standing<br/>';

f_igosja_generator_league_standing();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - league_standing<br/>';

f_igosja_generator_world_cup_standing();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - world_cup_standing<br/>';

f_igosja_generator_standing_history();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - standing_history<br/>';

f_igosja_generator_cup_next_stage();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - cup_next_stage<br/>';

f_igosja_generator_champions_league_next_stage();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - champions_league_next_stage<br/>';

f_igosja_generator_game_series();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - game_series<br/>';

f_igosja_generator_team_series_to_record();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - team_series_to_record<br/>';

f_igosja_generator_country_series_to_record();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - country_series_to_record<br/>';

f_igosja_generator_tournament_series_to_record();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - tournament_series_to_record<br/>';

f_igosja_generator_team_record();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - team_record<br/>';

f_igosja_generator_country_record();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - country_record<br/>';

f_igosja_generator_tournament_record();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - tournament_record<br/>';

f_igosja_generator_mood_after_game();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - mood_after_game<br/>';

f_igosja_generator_injury_after_game();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - injury_after_game<br/>';

f_igosja_generator_training();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - training<br/>';

f_igosja_generator_after_training();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - after_training<br/>';

f_igosja_generator_player_salary();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - player_salary<br/>';

f_igosja_generator_staff_salary();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - staff_salary(<br/>';

f_igosja_generator_team_reputation();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - team_reputation<br/>';

f_igosja_generator_tournament_reputation();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - tournament_reputation<br/>';

f_igosja_generator_user_reputation();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - user_reputation<br/>';

f_igosja_generator_user_time_in_club();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - user_time_in_club<br/>';

f_igosja_generator_finance();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - finance<br/>';

f_igosja_generator_make_played();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - make_played<br/>';

f_igosja_generator_scout();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - scout<br/>';

f_igosja_generator_building();

$current_time = round(microtime(true) - $current_time, 5);
print $current_time . ' - building<br/>';

print '<br/>Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br/>Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';