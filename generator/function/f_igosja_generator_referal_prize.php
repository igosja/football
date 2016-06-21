<?php

function f_igosja_generator_referal_prize()
//Вознаграждение на рефералов
{
    $sql = "SELECT `user_id`,
                   `user_referrer`
            FROM `user`
            WHERE `user_referrer`!='0'
            AND `user_referrer_prize`='0'
            AND `user_last_visit`-`user_registration_date`>'2592000'
            ORDER BY `user_id` ASC";
    $user_sql = f_igosja_mysqli_query($sql);

    $count_user = $user_sql->num_rows;
    $user_array = $user_sql->fetch_all(1);

    for ($i=0; $i<$count_user; $i++)
    {
        $user_id        = $user_array[$i]['user_id'];
        $referrer_id    = $user_array[$i]['user_referrer'];

        $sql = "UPDATE `user`
                SET `user_money`=`user_money`+'5'
                WHERE `user_id`='$referrer_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `user`
                SET `user_referrer_prize`='1'
                WHERE `user_id`='$user_id'
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }

    usleep(1);

    print '.';
    flush();
}