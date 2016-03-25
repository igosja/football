<?php

function f_igosja_generator_statisticplayer()
//Обновляем статистику игроков, которую не надо пускать в циклы
{
    global $igosja_season_id;

    $sql = "UPDATE `lineup`
            LEFT JOIN `game`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `statisticplayer`
            ON `statisticplayer_player_id`=`lineup_player_id`
            AND `statisticplayer_tournament_id`=`game_tournament_id`
            AND `statisticplayer_team_id`=`lineup_team_id`
            SET `statisticplayer_game`=`statisticplayer_game`+'1',
                `statisticplayer_distance`=`statisticplayer_distance`+`lineup_distance`,
                `statisticplayer_mark`=`statisticplayer_mark`+`lineup_mark`,
                `statisticplayer_pass`=`statisticplayer_pass`+`lineup_pass`,
                `statisticplayer_pass_accurate`=`statisticplayer_pass_accurate`+`lineup_pass_accurate`
            WHERE `statisticplayer_season_id`='$igosja_season_id'
            AND `lineup_team_id`!='0'
            AND `lineup_position_id`<='25'
            AND `shedule_date`=CURDATE()
            AND `game_played`='0'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `lineup`
            LEFT JOIN `game`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `statisticplayer`
            ON `statisticplayer_player_id`=`lineup_player_id`
            AND `statisticplayer_tournament_id`=`game_tournament_id`
            AND `statisticplayer_country_id`=`lineup_country_id`
            SET `statisticplayer_game`=`statisticplayer_game`+'1',
                `statisticplayer_distance`=`statisticplayer_distance`+`lineup_distance`,
                `statisticplayer_mark`=`statisticplayer_mark`+`lineup_mark`,
                `statisticplayer_pass`=`statisticplayer_pass`+`lineup_pass`,
                `statisticplayer_pass_accurate`=`statisticplayer_pass_accurate`+`lineup_pass_accurate`
            WHERE `statisticplayer_season_id`='$igosja_season_id'
            AND `lineup_team_id`='0'
            AND `lineup_position_id`<='25'
            AND `shedule_date`=CURDATE()
            AND `game_played`='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}