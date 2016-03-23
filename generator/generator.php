<?php

ini_set('memory_limit', '2048M');
set_time_limit(0);
date_default_timezone_set('Europe/Moscow');

include (__DIR__ . '/../include/constants.php');
include (__DIR__ . '/../include/database.php');
include (__DIR__ . '/generator/function.php');

$sql = "SELECT `season_id`
        FROM `season`
        ORDER BY `season_id` DESC
        LIMIT 1";
$season_sql = $mysqli->query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$igosja_season_id = $season_array[0]['season_id'];

f_igosja_generator_site_close();
f_igosja_generator_asktoplay_delete();
f_igosja_generator_lineup_main_create();
f_igosja_generator_lineup_check_and_fill();
f_igosja_generator_lineup_practice_and_condition();
f_igosja_generator_lineup_to_disqualification();
f_igosja_generator_lineup_to_statistic();
f_igosja_generator_referee_to_statistic();
f_igosja_generator_team_to_statistic();
f_igosja_generator_user_to_statistic();
f_igosja_generator_disqualification_decrease();
f_igosja_generator_visitor();
f_igosja_generator_game_result();
f_igosja_generator_game_result_overtime();
f_igosja_generator_lineup_mark_distance();
f_igosja_generator_lineup_statisticplayer_after_game_and_event();
f_igosja_generator_statisticplayer();
f_igosja_generator_best_player();
f_igosja_generator_statistic_team_user_referee();
f_igosja_generator_user_formation_gamemood_gamestyle();
f_igosja_generator_player_condition_practice();
f_igosja_generator_standing();
f_igosja_generator_league_standing();
f_igosja_generator_world_cup_standing();
f_igosja_generator_standing_history();
f_igosja_generator_cup_next_stage();
f_igosja_generator_champions_league_next_stage();
f_igosja_generator_game_series();
f_igosja_generator_team_series_to_record();
f_igosja_generator_country_series_to_record();
f_igosja_generator_tournament_series_to_record();
f_igosja_generator_team_record();
f_igosja_generator_country_record();
f_igosja_generator_tournament_record();
f_igosja_generator_mood_after_game();
f_igosja_generator_injury_after_game();
f_igosja_generator_training();
f_igosja_generator_after_training();
f_igosja_generator_player_salary();
f_igosja_generator_staff_salary();
f_igosja_generator_team_reputation();
f_igosja_generator_tournament_reputation();
f_igosja_generator_user_reputation();
f_igosja_generator_user_time_in_club();
f_igosja_generator_finance();
f_igosja_generator_make_played();
f_igosja_generator_scout();
f_igosja_generator_building();
f_igosja_generator_site_open();

print '<br/>Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br/>Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';