<?php

include (__DIR__ . '/../include/generator.php');

f_igosja_generator_site_close();
f_igosja_generator_asktoplay_delete();
f_igosja_generator_lineup_main_create();
f_igosja_generator_lineup_check_and_fill();
f_igosja_generator_lineup_practice_and_condition();
f_igosja_generator_lineup_to_disqualification();
f_igosja_generator_lineup_to_statistic();
f_igosja_generator_referee_to_statistic();
f_igosja_generator_team_to_statistic();
f_igosja_generator_country_to_statistic();
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
f_igosja_generator_rating_league();
f_igosja_generator_rating_country();
f_igosja_generator_league_standing();
f_igosja_generator_world_cup_standing();
f_igosja_generator_standing_history();
f_igosja_generator_cup_next_stage();
f_igosja_generator_league_next_stage();
f_igosja_generator_game_series();
f_igosja_generator_team_series_to_record();
f_igosja_generator_country_series_to_record();
f_igosja_generator_tournament_series_to_record();
f_igosja_generator_team_record();
f_igosja_generator_country_record();
f_igosja_generator_tournament_record();
f_igosja_generator_mood_after_game();
f_igosja_generator_injury_after_game();
f_igosja_generator_make_injury();
f_igosja_generator_training();
f_igosja_generator_after_training();
f_igosja_generator_player_salary();
f_igosja_generator_staff_salary();
f_igosja_generator_team_price();
f_igosja_generator_team_reputation();
f_igosja_generator_tournament_reputation();
f_igosja_generator_user_reputation();
f_igosja_generator_user_time_in_club();
f_igosja_generator_finance();
f_igosja_generator_finance_tv();
f_igosja_generator_make_played();
f_igosja_generator_scout();
f_igosja_generator_field_worse();
f_igosja_generator_building();
f_igosja_generator_transfer();
f_igosja_generator_ticket_price();

$sql = "SELECT COUNT(`shedule_id`) AS `count`
        FROM `shedule`
        WHERE `shedule_date`>CURRENT_DATE()
        AND `shedule_season_id`='$igosja_season_id'";
$shedule_sql = $mysqli->query($sql);

$shedule_array = $shedule_sql->fetch_all(MYSQLI_ASSOC);

$count_shedule = $shedule_array[0]['count'];

if (0 == $count_shedule)
{
    include (__DIR__ . '/../include/season.php');

    f_igosja_season_player_age();
    f_igosja_season_participant_to_winner();
    f_igosja_season_user_worldcup_trophy();
    f_igosja_season_user_championship_trophy();
    f_igosja_season_user_cup_trophy();
    f_igosja_season_user_league_trophy();
    f_igosja_season_worldcup_most_titled_record();
    f_igosja_season_worldcup_position_record();
    f_igosja_season_championship_most_titled_record();
    f_igosja_season_championship_position_record();
    f_igosja_season_league_most_titled_record();
    f_igosja_season_cup_most_titled_record();
    f_igosja_season_league_prize();
    f_igosja_season_championship_prize();
    f_igosja_season_championship_visitor();
    f_igosja_season_cup_prize();
    f_igosja_season_national_coach();
    f_igosja_season_truncate();
    f_igosja_season_user_fire();
    f_igosja_season_tax();
    f_igosja_season_new_season();
    f_igosja_season_worldcup_standing();
    f_igosja_season_championship_standing();
    f_igosja_season_shedule();
    f_igosja_season_worldcup_game();
    f_igosja_season_champions_league_game();
    f_igosja_season_championship_game();
    f_igosja_season_cup_game();
}

f_igosja_generator_site_open();

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Запросов к базе данных: ' . $count_sql . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';