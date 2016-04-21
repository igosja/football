<?php

function f_igosja_season_user_league_trophy()
{
    global $igosja_season_id;

    $sql = "UPDATE `user`
            LEFT JOIN `leagueparticipant`
            ON `leagueparticipant_user_id`=`user_id`
            SET `user_trophy`=`user_trophy`+'1'
            WHERE `leagueparticipant_out`='-1'
            AND `leagueparticipant_season_id`='$igosja_season_id'
            AND `user_id`!='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}