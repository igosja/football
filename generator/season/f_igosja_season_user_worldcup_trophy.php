<?php

function f_igosja_season_user_worldcup_trophy()
{
    global $igosja_season_id;

    $sql = "UPDATE `user`
            LEFT JOIN `worldcup`
            ON `worldcup_user_id`=`user_id`
            SET `user_trophy`=`user_trophy`+'1'
            WHERE `worldcup_season_id`='$igosja_season_id'
            AND `worldcup_place`='1'
            AND `user_id`!='0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}