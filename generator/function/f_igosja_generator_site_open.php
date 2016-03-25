<?php

function f_igosja_generator_site_open()
//Открываем сайт для пользователей после генерации
{
    $sql = "UPDATE `site`
            SET `site_status`='1'
            WHERE `site_id`='1'
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}