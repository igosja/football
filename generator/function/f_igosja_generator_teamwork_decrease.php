<?php

function f_igosja_generator_teamwork_decrease()
//Уменьшение сыгранности
{
    $sql = "UPDATE `teamwork`
            SET `teamwork_value`=`teamwork_value`-'1'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `teamwork`
            SET `teamwork_value`='100'
            WHERE `teamwork_value`>'100'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `teamwork`
            SET `teamwork_value`='0'
            WHERE `teamwork_value`<'0'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}