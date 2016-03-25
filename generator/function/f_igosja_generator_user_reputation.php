<?php

function f_igosja_generator_user_reputation()
//Репутация пользователя
{
    $sql = "SELECT `game_guest_score`,
                   `game_home_score`,
                   `guest`.`team_reputation` AS `guest_reputation`,
                   `guest`.`team_user_id` AS `guest_user_id`,
                   `home`.`team_reputation` AS `home_reputation`,
                   `home`.`team_user_id` AS `home_user_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `shedule_id`=`game_shedule_id`
            LEFT JOIN `team` AS `home`
            ON `home`.`team_id`=`game_home_team_id`
            LEFT JOIN `team` AS `guest`
            ON `guest`.`team_id`=`game_guest_team_id`
            WHERE `shedule_date`=CURDATE()
            AND `game_played`='0'
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $count_game = $game_sql->num_rows;
    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_game; $i++)
    {
        $home_reputation    = $game_array[$i]['home_reputation'];
        $home_score         = $game_array[$i]['game_home_score'];
        $home_user_id       = $game_array[$i]['home_user_id'];
        $guest_reputation   = $game_array[$i]['guest_reputation'];
        $guest_score        = $game_array[$i]['game_guest_score'];
        $guest_user_id      = $game_array[$i]['guest_user_id'];

        if ($home_score > $guest_score &&
            $guest_reputation >= $home_reputation)
        {
            $sql = "UPDATE `user`
                    SET `user_reputation`=`user_reputation`+'1'
                    WHERE `user_id`='$home_user_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `user`
                    SET `user_reputation`=`user_reputation`-'1'
                    WHERE `user_id`='$guest_user_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
        elseif ($home_score == $guest_score &&
                $home_reputation > $guest_reputation)
        {
            $sql = "UPDATE `user`
                    SET `user_reputation`=`user_reputation`-'1'
                    WHERE `user_id`='$home_user_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `user`
                    SET `user_reputation`=`user_reputation`+'1'
                    WHERE `user_id`='$guest_user_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
        elseif ($home_score == $guest_score &&
                $home_reputation < $guest_reputation)
        {
            $sql = "UPDATE `user`
                    SET `user_reputation`=`user_reputation`+'1'
                    WHERE `user_id`='$home_user_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `user`
                    SET `user_reputation`=`user_reputation`-'1'
                    WHERE `user_id`='$guest_user_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
        elseif ($home_score < $guest_score &&
                $home_reputation >= $guest_reputation)
        {
            $sql = "UPDATE `user`
                    SET `user_reputation`=`user_reputation`-'1'
                    WHERE `user_id`='$home_user_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `user`
                    SET `user_reputation`=`user_reputation`+'1'
                    WHERE `user_id`='$guest_user_id'
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }

    $sql = "UPDATE `user`
            SET `user_reputation`='100'
            WHERE `user_reputation`>'100'
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `user`
            SET `user_reputation`='0'
            WHERE `user_reputation`<'0'
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}