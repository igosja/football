<?php

function f_igosja_generator_building()
//Заверешение строительства базы и стадиона
{
    $sql = "UPDATE `team`
            LEFT JOIN `building`
            ON `building_team_id`=`team_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`building_shedule_id`
            SET `team_training_level`=`team_training_level`+'1'
            WHERE `shedule_date`=CURDATE()
            AND `building_buildingtype_id`='1'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            LEFT JOIN `building`
            ON `building_team_id`=`team_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`building_shedule_id`
            SET `team_school_level`=`team_school_level`+'1'
            WHERE `shedule_date`=CURDATE()
            AND `building_buildingtype_id`='2'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `stadium`
            LEFT JOIN `team`
            ON `team_id`=`stadium_team_id`
            LEFT JOIN `building`
            ON `building_team_id`=`team_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`building_shedule_id`
            SET `stadium_capacity`=`building_capacity`
            WHERE `shedule_date`=CURDATE()
            AND `building_buildingtype_id`='3'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `stadium`
            LEFT JOIN `team`
            ON `team_id`=`stadium_team_id`
            LEFT JOIN `building`
            ON `building_team_id`=`team_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`building_shedule_id`
            SET `stadium_length`=`building_length`,
                `stadium_width`=`building_width`
            WHERE `shedule_date`=CURDATE()
            AND `building_buildingtype_id`='5'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `stadium`
            LEFT JOIN `team`
            ON `team_id`=`stadium_team_id`
            LEFT JOIN `building`
            ON `building_team_id`=`team_id`
            LEFT JOIN `shedule`
            ON `shedule_id`=`building_shedule_id`
            SET `stadium_stadiumquality_id`='1'
            WHERE `shedule_date`=CURDATE()
            AND `building_buildingtype_id`='4'";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `building`
            WHERE `building_shedule_id`<=
            (
                SELECT `shedule_id`
                FROM `shedule`
                WHERE `shedule_date`=CURDATE()
            )";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `building`
            WHERE `building_buildingtype_id` IN (4,5)";
    f_igosja_mysqli_query($sql);

    usleep(1);

    print '.';
    flush();
}