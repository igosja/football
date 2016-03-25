<?php

function f_igosja_generator_mood_after_game()
//Настроение игроков после матча
{
    $sql = "UPDATE `game`
            LEFT JOIN `lineup`
            ON `lineup_team_id`=`game_home_team_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `player`
            ON `player_id`=`lineup_player_id`
            SET `player_mood_id`=IF(`game_home_score`>`game_guest_score`, `player_mood_id`+'1', IF(`game_home_score`<`game_guest_score`, `player_mood_id`-'1', `player_mood_id`))
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `game`
            LEFT JOIN `lineup`
            ON `lineup_team_id`=`game_guest_team_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `player`
            ON `player_id`=`lineup_player_id`
            SET `player_mood_id`=IF(`game_home_score`<`game_guest_score`, `player_mood_id`+'1', IF(`game_home_score`>`game_guest_score`, `player_mood_id`-'1', `player_mood_id`))
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_mood_id`='1'
            WHERE `player_mood_id`<'1'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_mood_id`='7'
            WHERE `player_mood_id`>'7'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}