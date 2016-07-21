<?php

function f_igosja_generator_national_coach()
{
    global $igosja_season_id;

    $sql = "SELECT `country_id`
            FROM `country`
            WHERE `country_id` IN
            (
                SELECT `city_country_id`
                FROM `city`
                WHERE `city_id`!='0'
            )
            AND `country_user_id`='0'
            ORDER BY RAND()";
    $country_sql = f_igosja_mysqli_query($sql);

    $count_country = $country_sql->num_rows;
    $country_array = $country_sql->fetch_all(1);

    for ($i=0; $i<$count_country; $i++)
    {
        $country_id = $country_array[$i]['country_id'];

        $sql = "SELECT `coachapplication_user_id`
                FROM `coachapplication`
                LEFT JOIN
                (
                    SELECT COUNT(`coachvote_id`) AS `count`,
                           `coachvote_coachapplication_id`
                    FROM `coachvote`
                    WHERE `coachvote_season_id`='$igosja_season_id'
                    GROUP BY `coachvote_coachapplication_id`
                ) AS `t1`
                ON `coachvote_coachapplication_id`=`coachapplication_id`
                LEFT JOIN `user`
                ON `user_id`=`coachapplication_user_id`
                WHERE `coachapplication_season_id`='$igosja_season_id'
                AND `coachapplication_country_id`='$country_id'
                AND `coachapplication_ready`='0'
                AND `coachapplication_date`<(UNIX_TIMESTAMP()-'2'*'24'*'60'*'60')
                AND `count`>'0'
                AND `coachapplication_user_id` NOT IN
                (
                    SELECT `country_user_id`
                    FROM `country`
                    WHERE `country_user_id`!='0'
                )
                ORDER BY `count` DESC, `user_reputation` DESC
                LIMIT 1";
        $user_sql = f_igosja_mysqli_query($sql);

        $user_array = $user_sql->fetch_all(1);

        if (isset($user_array[0]['coachapplication_user_id']))
        {
            $user_id = $user_array[0]['coachapplication_user_id'];

            $sql = "UPDATE `country`
                    SET `country_user_id`='$user_id'
                    WHERE `country_id`='$country_id'";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `user`
                    SET `user_national`=`user_national`+'1'";
            f_igosja_mysqli_query($sql);

            f_igosja_history(22, $user_id, $country_id);
        }
    }

    $sql = "UPDATE `coachapplication`
            SET `coachapplication_ready`='1'
            WHERE `coachapplication_ready`='0'";
    f_igosja_mysqli_query($sql);
}