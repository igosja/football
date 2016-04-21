<?php

function f_igosja_season_user_championship_trophy()
{
    global $igosja_season_id;

    $sql = "UPDATE `user`
            LEFT JOIN `standing`
            ON `standing_user_id`=`user_id`
            SET `user_trophy`=`user_trophy`+'1'
            WHERE `standing_season_id`='$igosja_season_id'
            AND `standing_place`='1'
            AND `user_id`!='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}