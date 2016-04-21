<?php

function f_igosja_season_user_cup_trophy()
{
    global $igosja_season_id;

    $sql = "UPDATE `user`
            LEFT JOIN `cupparticipant`
            ON `cupparticipant_user_id`=`user_id`
            SET `user_trophy`=`user_trophy`+'1'
            WHERE `cupparticipant_out`='-1'
            AND `cupparticipant_season_id`='$igosja_season_id'
            AND `user_id`!='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}