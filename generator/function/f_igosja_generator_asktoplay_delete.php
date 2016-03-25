<?php

function f_igosja_generator_asktoplay_delete()
//Удаляем заявки на товарищеские матчи на текущий день
{
    $sql = "SELECT `asktoplay_id`
            FROM `asktoplay`
            LEFT JOIN `shedule`
            ON `shedule_id`=`asktoplay_shedule_id`
            WHERE `shedule_date`=CURDATE()";
    $asktoplay_sql = f_igosja_mysqli_query($sql);

    $count_asktoplay = $asktoplay_sql->num_rows;
    $asktoplay_array = $asktoplay_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_asktoplay; $i++)
    {
        $asktoplay_id = $asktoplay_array[$i]['asktoplay_id'];

        $sql = "DELETE FROM `asktoplay`
                WHERE `asktoplay_id`='$asktoplay_id'";
        f_igosja_mysqli_query($sql);

        $sql = "DELETE FROM `inbox`
                WHERE `inbox_asktoplay_id`='$asktoplay_id'";
        f_igosja_mysqli_query($sql);

        usleep(1);

        print '.';
        flush();
    }
}