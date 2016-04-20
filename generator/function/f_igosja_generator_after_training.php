<?php

function f_igosja_generator_after_training()
//Повышение навыков игроков при полной тренировке
{
    $sql = "UPDATE `playerposition`
            SET `playerposition_value`='100'
            WHERE `playerposition_value`>'100'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `training`
            LEFT JOIN `playerattribute`
            ON (`playerattribute_attribute_id`=`training_attribute_id`
            AND `playerattribute_player_id`=`training_player_id`)
            SET `playerattribute_value`=`playerattribute_value`+'1'
            WHERE `training_percent`>='100'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `training`
            LEFT JOIN `playerattribute`
            ON (`playerattribute_attribute_id`=`training_attribute_id`
            AND `playerattribute_player_id`=`training_player_id`)
            SET `playerattribute_value`=`playerattribute_value`-'1'
            WHERE `training_percent`<='-100'";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `training`
            WHERE `training_percent`>='100'
            OR `training_percent`<='-100'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `playerattribute`
            SET `playerattribute_value`='1'
            WHERE `playerattribute_value`<'1'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `playerattribute`
            SET `playerattribute_value`='100'
            WHERE `playerattribute_value`>'100'";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}