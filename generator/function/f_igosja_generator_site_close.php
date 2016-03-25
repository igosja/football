<?php

function f_igosja_generator_site_close()
//Закрываем сайт для пользователей на время генерации
{
    $sql = "UPDATE `site`
            SET `site_status`='0'
            WHERE `site_id`='1'
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}