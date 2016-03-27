<?php

function f_igosja_generator_training()
//Тренировка игроков
{
    $sql = "SELECT `coach_reputation`,
                   `gk_reputation`,
                   `player_ability`,
                   `player_age`,
                   `player_id`,
                   `player_position_id`,
                   `player_training_attribute_id`,
                   `player_training_intensity`,
                   `player_training_position_id`,
                   `team_training_level`
            FROM `player`
            LEFT JOIN `team`
            ON `team_id`=`player_team_id`
            LEFT JOIN
            (
                SELECT `staff_reputation` AS `coach_reputation`,
                       `staff_team_id`
                FROM `staff`
                WHERE `staff_staffpost_id`='" . STAFFPOST_COACH . "'
            ) AS `coach`
            ON `coach`.`staff_team_id`=`team_id`
            LEFT JOIN
            (
                SELECT `staff_reputation` AS `gk_reputation`,
                       `staff_team_id`
                FROM `staff`
                WHERE `staff_staffpost_id`='" . STAFFPOST_GK . "'
            ) AS `gk`
            ON `gk`.`staff_team_id`=`team_id`
            WHERE `player_team_id`!='0'
            ORDER BY `player_id` ASC";
    $player_sql = f_igosja_mysqli_query($sql);

    $count_player = $player_sql->num_rows;
    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

    for ($i=0; $i<$count_player; $i++)
    {
        $player_id          = $player_array[$i]['player_id'];
        $player_position_id = $player_array[$i]['player_position_id'];
        $ability            = $player_array[$i]['player_ability'];
        $age                = $player_array[$i]['player_age'];
        $attribute_id       = $player_array[$i]['player_training_attribute_id'];
        $position_id        = $player_array[$i]['player_training_position_id'];
        $intensity          = $player_array[$i]['player_training_intensity'];
        $training_level     = $player_array[$i]['team_training_level'];
        $percent_minus      = 0;

        if (1 == $player_position_id)
        {
            $reputation = $player_array[$i]['gk_reputation'];
        }
        else
        {
            $reputation = $player_array[$i]['coach_reputation'];
        }

        $percent = $training_level * $reputation * $ability;

        if (0 != $position_id)
        {
            $sql = "SELECT COUNT(`playerposition_id`) AS `count`
                    FROM `playerposition`
                    WHERE `playerposition_player_id`='$player_id'
                    AND `playerposition_position_id`='$position_id'";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            $count_check = $check_array[0]['count'];

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `playerposition`
                        SET `playerposition_player_id`='$player_id',
                            `playerposition_position_id`='$position_id',
                            `playerposition_value`='$percent'*'$intensity'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $sql = "UPDATE `playerposition`
                        SET `playerposition_value`=`playerposition_value`+'$percent'*'$intensity'
                        WHERE `playerposition_player_id`='$player_id'
                        AND `playerposition_position_id`='$position_id'";
                f_igosja_mysqli_query($sql);
            }

            $percent_minus = $percent_minus + $percent * $intensity;
        }

        if (0 != $attribute_id)
        {
            $sql = "SELECT COUNT(`training_id`) AS `count`
                    FROM `training`
                    WHERE `training_player_id`='$player_id'
                    AND `training_attribute_id`='$attribute_id'";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            $count_check = $check_array[0]['count'];

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `training`
                        SET `training_player_id`='$player_id',
                            `training_attribute_id`='$attribute_id',
                            `training_percent`='$percent'*'$intensity'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $sql = "UPDATE `training`
                        SET `training_percent`=`training_percent`+'$percent'*'$intensity'
                        WHERE `training_player_id`='$player_id'
                        AND `training_attribute_id`='$attribute_id'";
                f_igosja_mysqli_query($sql);
            }

            $percent_minus = $percent_minus + $percent * $intensity / 100;
        }

        $percent = ceil(($percent - $percent_minus) / TRAINING_ATTRIBUTES_COUNT, 0);

        $sql = "SELECT `playerattribute_attribute_id`
                FROM `playerattribute`
                LEFT JOIN `attribute`
                ON `attribute_id`=`playerattribute_attribute_id`
                WHERE `attribute_attributechapter_id`!='3'
                AND `playerattribute_player_id`='$player_id'";
        $attribute_sql = f_igosja_mysqli_query($sql);

        $count_attribute = $attribute_sql->num_rows;
        $attribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_attribute; $j++)
        {
            $attribute_id = $attribute_array[$j]['playerattribute_attribute_id'];

            $sql = "SELECT COUNT(`training_id`) AS `count`
                    FROM `training`
                    WHERE `training_player_id`='$player_id'
                    AND `training_attribute_id`='$attribute_id'";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            $count_check = $check_array[0]['count'];

            if (0 == $count_check)
            {
                if (30 >= $age)
                {
                    $sql = "INSERT INTO `training`
                            SET `training_player_id`='$player_id',
                                `training_attribute_id`='$attribute_id',
                                `training_percent`='$percent'";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "INSERT INTO `training`
                            SET `training_player_id`='$player_id',
                                `training_attribute_id`='$attribute_id',
                                `training_percent`='-8'";
                    f_igosja_mysqli_query($sql);
                }
            }
            else
            {
                if (30 >= $age)
                {
                    $sql = "UPDATE `training`
                            SET `training_percent`=`training_percent`+'$percent'
                            WHERE `training_player_id`='$player_id'
                            AND `training_attribute_id`='$attribute_id'";
                    f_igosja_mysqli_query($sql);
                }
                else
                {
                    $sql = "UPDATE `training`
                            SET `training_percent`=`training_percent`-'8'
                            WHERE `training_player_id`='$player_id'
                            AND `training_attribute_id`='$attribute_id'";
                    f_igosja_mysqli_query($sql);
                }
            }
        }

        $sql = "SELECT `playerattribute_attribute_id`
                FROM `playerattribute`
                LEFT JOIN `attribute`
                ON `attribute_id`=`playerattribute_attribute_id`
                WHERE `attribute_attributechapter_id`='3'
                AND `playerattribute_player_id`='$player_id'";
        $attribute_sql = f_igosja_mysqli_query($sql);

        $count_attribute = $attribute_sql->num_rows;
        $attribute_array = $attribute_sql->fetch_all(MYSQLI_ASSOC);

        for ($j=0; $j<$count_attribute; $j++)
        {
            $attribute_id = $attribute_array[$j]['playerattribute_attribute_id'];

            $sql = "SELECT COUNT(`training_id`) AS `count`
                    FROM `training`
                    WHERE `training_player_id`='$player_id'
                    AND `training_attribute_id`='$attribute_id'";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            $count_check = $check_array[0]['count'];

            if (0 == $count_check)
            {
                $sql = "INSERT INTO `training`
                        SET `training_player_id`='$player_id',
                            `training_attribute_id`='$attribute_id',
                            `training_percent`='$percent'";
                f_igosja_mysqli_query($sql);
            }
            else
            {
                $sql = "UPDATE `training`
                        SET `training_percent`=`training_percent`+'$percent'
                        WHERE `training_player_id`='$player_id'
                        AND `training_attribute_id`='$attribute_id'";
                f_igosja_mysqli_query($sql);
            }
        }

        usleep(1);

        print '.';
        flush();
    }
}