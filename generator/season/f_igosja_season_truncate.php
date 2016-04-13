<?php

function f_igosja_season_truncate()
{
    $sql = "TRUNCATE `asktoplay`";
    f_igosja_mysqli_query($sql);

    $sql = "TRUNCATE `disqualification`";
    f_igosja_mysqli_query($sql);

    $sql = "TRUNCATE `playeroffer`";
    f_igosja_mysqli_query($sql);

    $sql = "TRUNCATE `series`";
    f_igosja_mysqli_query($sql);

    $sql = "TRUNCATE `standinghistory`";
    f_igosja_mysqli_query($sql);

    $sql = "TRUNCATE `teaminstruction`";
    f_igosja_mysqli_query($sql);

    $sql = "TRUNCATE `transfer`";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}