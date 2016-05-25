<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `city_country_id`,
               `team_id`,
               `team_school_level`
        FROM `player`
        LEFT JOIN `team`
        ON `team_id`=`player_team_id`
        LEFT JOIN `city`
        ON `city_id`=`team_city_id`
        GROUP BY `player_team_id`
        HAVING COUNT(`player_id`)<'16'";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;
$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_team; $i++)
{
    $team_id        = $team_array[$i]['team_id'];
    $country_id     = $team_array[$i]['city_country_id'];
    $school_level   = $team_array[$i]['team_school_level'];

    $sql = "SELECT COUNT(`player_id`) AS `count`
            FROM `player`
            WHERE `player_position_id`='1'
            AND `player_team_id`='$team_id'";
    $gk_sql = $mysqli->query($sql);

    $gk_array = $gk_sql->fetch_all(MYSQLI_ASSOC);
    $count_gk = $gk_array[0]['count'];

    for ($j=$count_gk; $j<2; $j++)
    {
        $sql = "SELECT `countryname_name_id`
                FROM `countryname`
                WHERE `countryname_country_id`='$country_id'
                ORDER BY RAND()
                LIMIT 1";
        $name_sql = $mysqli->query($sql);

        $name_array = $name_sql->fetch_all(MYSQLI_ASSOC);

        $name_id = $name_array[0]['countryname_name_id'];

        $sql = "SELECT `countrysurname_surname_id`
                FROM `countrysurname`
                LEFT JOIN `city`
                ON `city_country_id`=`countrysurname_country_id`
                LEFT JOIN `team`
                ON `team_city_id`=`city_id`
                WHERE `team_id`='$team_id'
                AND `countrysurname_surname_id`
                NOT IN
                (
                    SELECT `player_surname_id`
                    FROM `player`
                    WHERE `player_team_id`='$team_id'
                )
                ORDER BY RAND()
                LIMIT 1";
        $surname_sql = $mysqli->query($sql);

        $surname_array = $surname_sql->fetch_all(MYSQLI_ASSOC);

        $surname_id = $surname_array[0]['countrysurname_surname_id'];

        $position_id    = 1;
        $height         = rand(165, 200);
        $weight         = $height - 95 - rand(0, 5);
        $ability        = $school_level * 10 - rand(0, 9);
        $age            = 17;
        $leg_array      = f_igosja_player_leg($position_id);
        $leg_left       = $leg_array['leg_left'];
        $leg_right      = $leg_array['leg_right'];

        $sql = "INSERT INTO `player`
                SET `player_country_id`='$country_id',
                    `player_name_id`='$name_id',
                    `player_age`='$age',
                    `player_surname_id`='$surname_id',
                    `player_team_id`='$team_id',
                    `player_leg_left`='$leg_left',
                    `player_leg_right`='$leg_right',
                    `player_ability`='$ability',
                    `player_height`='$height',
                    `player_weight`='$weight',
                    `player_position_id`='$position_id'";
        $mysqli->query($sql);

        $player_id = $mysqli->insert_id;

        $sql = "INSERT INTO `playerattribute` (`playerattribute_player_id`, `playerattribute_attribute_id`, `playerattribute_value`)
                SELECT '$player_id', `attribute_id`, '$school_level' * '10' - '9' * RAND()
                FROM `attribute`
                WHERE `attribute_attributechapter_id`!=" . FIELD_ATTRIBUTE_CHAPTER . "
                ORDER BY `attribute_id` ASC";
        $mysqli->query($sql);

        $sql = "INSERT INTO `playerposition`
                SET `playerposition_player_id`='$player_id', 
                    `playerposition_position_id`='$position_id', 
                    `playerposition_value`='100'";
        $mysqli->query($sql);

        $sql = "UPDATE `player`
                LEFT JOIN
                (
                    SELECT `playerattribute_player_id`,
                           SUM(`playerattribute_value`) AS `power`
                    FROM `playerattribute`
                    GROUP BY `playerattribute_player_id`
                ) AS `t1`
                ON `player_id`=`playerattribute_player_id`
                SET `player_salary`=ROUND(POW(`power`, 1.3)),
                    `player_price`=`player_salary`*'987',
                    `player_reputation`=`power`/'" . MAX_PLAYER_POWER . "'*'100'
                WHERE `player_id`='$player_id'";
        $mysqli->query($sql);
    }

    $sql = "SELECT COUNT(`player_id`) AS `count`
            FROM `player`
            WHERE `player_position_id`!='1'
            AND `player_team_id`='$team_id'";
    $field_sql = $mysqli->query($sql);

    $field_array = $field_sql->fetch_all(MYSQLI_ASSOC);
    $count_field = $field_array[0]['count'];

    for ($j=$count_field; $j<16; $j++)
    {
        $sql = "SELECT `countryname_name_id`
                FROM `countryname`
                WHERE `countryname_country_id`='$country_id'
                ORDER BY RAND()
                LIMIT 1";
        $name_sql = $mysqli->query($sql);

        $name_array = $name_sql->fetch_all(MYSQLI_ASSOC);

        $name_id = $name_array[0]['countryname_name_id'];

        $sql = "SELECT `countrysurname_surname_id`
                FROM `countrysurname`
                LEFT JOIN `city`
                ON `city_country_id`=`countrysurname_country_id`
                LEFT JOIN `team`
                ON `team_city_id`=`city_id`
                WHERE `team_id`='$team_id'
                AND `countrysurname_surname_id`
                NOT IN
                (
                    SELECT `player_surname_id`
                    FROM `player`
                    WHERE `player_team_id`='$team_id'
                )
                ORDER BY RAND()
                LIMIT 1";
        $surname_sql = $mysqli->query($sql);

        $surname_array = $surname_sql->fetch_all(MYSQLI_ASSOC);

        $surname_id = $surname_array[0]['countrysurname_surname_id'];

        $position_id    = 15;
        $height         = rand(165, 200);
        $weight         = $height - 95 - rand(0, 5);
        $ability        = $school_level * 10 - rand(0, 9);
        $age            = 17;
        $leg_array      = f_igosja_player_leg($position_id);
        $leg_left       = $leg_array['leg_left'];
        $leg_right      = $leg_array['leg_right'];

        $sql = "INSERT INTO `player`
                SET `player_country_id`='$country_id',
                    `player_name_id`='$name_id',
                    `player_age`='$age',
                    `player_surname_id`='$surname_id',
                    `player_team_id`='$team_id',
                    `player_leg_left`='$leg_left',
                    `player_leg_right`='$leg_right',
                    `player_ability`='$ability',
                    `player_height`='$height',
                    `player_weight`='$weight',
                    `player_position_id`='$position_id'";
        $mysqli->query($sql);

        $player_id = $mysqli->insert_id;

        $sql = "INSERT INTO `playerattribute` (`playerattribute_player_id`, `playerattribute_attribute_id`, `playerattribute_value`)
                SELECT '$player_id', `attribute_id`, '$school_level' * '10' - '9' * RAND()
                FROM `attribute`
                WHERE `attribute_attributechapter_id`!=" . GK_ATTRIBUTE_CHAPTER . "
                ORDER BY `attribute_id` ASC";
        $mysqli->query($sql);

        $sql = "INSERT INTO `playerposition`
                SET `playerposition_player_id`='$player_id', 
                    `playerposition_position_id`='$position_id', 
                    `playerposition_value`='100'";
        $mysqli->query($sql);

        $sql = "UPDATE `player`
                LEFT JOIN
                (
                    SELECT `playerattribute_player_id`,
                           SUM(`playerattribute_value`) AS `power`
                    FROM `playerattribute`
                    GROUP BY `playerattribute_player_id`
                ) AS `t1`
                ON `player_id`=`playerattribute_player_id`
                SET `player_salary`=ROUND(POW(`power`, 1.3)),
                    `player_price`=`player_salary`*'987',
                    `player_reputation`=`power`/'" . MAX_PLAYER_POWER . "'*'100'
                WHERE `player_id`='$player_id'";
        $mysqli->query($sql);
    }
}

print '<br />Страница сгенерирована за ' . round(microtime(true) - $start_time, 5) . ' сек. в ' . date('H:i:s') . '
       <br />Потребление памяти: ' . number_format(memory_get_usage(), 0, ",", " ") . ' Б';