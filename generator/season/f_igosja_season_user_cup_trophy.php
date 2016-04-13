<?php

function f_igosja_season_user_cup_trophy()
{
    global $igosja_season_id;

    $sql = "UPDATE `team`
            LEFT JOIN `user`
            ON `team_user_id`=`user_id`
            LEFT JOIN
            (
                SELECT IF(`game_home_score`+`game_home_shoot_out`>`game_guest_score`+`game_guest_shoot_out`, `game_home_team_id`, `game_guest_team_id`) AS `winner_id`
                FROM `game`
                LEFT JOIN `shedule`
                ON `shedule_id`=`game_shedule_id`
                WHERE `shedule_tournamenttype_id`='" . TOURNAMENT_TYPE_CUP . "'
                AND `shedule_season_id`='$igosja_season_id'
                AND `game_stage_id`='" . CUP_FINAL_STAGE . "'
            ) AS `t1`
            ON `winner_id`=`team_id`
            SET `user_trophy`=`user_trophy`+'1'
            WHERE `winner_id`>'0'
            AND `user_id`!='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}