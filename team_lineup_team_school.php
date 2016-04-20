<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_team_id))
{
    $get_num = $authorization_team_id;
}
else
{
    include (__DIR__ . '/view/only_my_team.php');
    exit;
}

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$get_num'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$team_name = $team_array[0]['team_name'];

if (isset($_GET['ok']))
{
    $ok = (int) $_GET['ok'];

    $sql = "SELECT `city_country_id`,
                   `school_height`,
                   `school_name_id`,
                   `school_position_id`,
                   `school_surname_id`,
                   `school_weight`,
                   `team_school_level`
            FROM `school`
            LEFT JOIN `team`
            ON `team_id`=`school_team_id`
            LEFT JOIN `city`
            ON `team_city_id`=`city_id`
            WHERE `school_team_id`='$get_num'
            AND `school_id`='$ok'";
    $school_sql = $mysqli->query($sql);

    $count_school = $school_sql->num_rows;

    if (0 == $count_school)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Игрок выбран неправильно.';

        redirect('team_lineup_team_school.php?num=' . $get_num);
    }

    $school_array = $school_sql->fetch_all(MYSQLI_ASSOC);

    $country_id     = $school_array[0]['city_country_id'];
    $position_id    = $school_array[0]['school_position_id'];
    $name_id        = $school_array[0]['school_name_id'];
    $surname_id     = $school_array[0]['school_surname_id'];
    $height         = $school_array[0]['school_height'];
    $weight         = $school_array[0]['school_weight'];
    $school_level   = $school_array[0]['team_school_level'];
    $ability        = $school_level * 10 - rand(0, 10);
    $age            = 17;

    $leg_array = f_igosja_player_leg($position_id);
    $leg_left  = $leg_array['leg_left'];
    $leg_right = $leg_array['leg_right'];

    $sql = "INSERT INTO `player`
            SET `player_country_id`='$country_id',
                `player_name_id`='$name_id',
                `player_age`='$age',
                `player_surname_id`='$surname_id',
                `player_team_id`='$get_num',
                `player_leg_left`='$leg_left',
                `player_leg_right`='$leg_right',
                `player_ability`='$ability',
                `player_height`='$height',
                `player_weight`='$weight',
                `player_position_id`='$position_id'";
    $mysqli->query($sql);

    $player_id = $mysqli->insert_id;

    if (GK_POSITION_ID == $position_id)
    {
        $sql = "INSERT INTO `playerattribute` (`playerattribute_player_id`, `playerattribute_attribute_id`, `playerattribute_value`)
                SELECT '$player_id', `attribute_id`, '$school_level' * '10' - '10' * RAND()
                FROM `attribute`
                WHERE `attribute_attributechapter_id`!=" . FIELD_ATTRIBUTE_CHAPTER . "
                ORDER BY `attribute_id` ASC";
        $mysqli->query($sql);
    }
    else
    {
        $sql = "INSERT INTO `playerattribute` (`playerattribute_player_id`, `playerattribute_attribute_id`, `playerattribute_value`)
                SELECT '$player_id', `attribute_id`, '$school_level' * '10' - '10' * RAND()
                FROM `attribute`
                WHERE `attribute_attributechapter_id`!=" . GK_ATTRIBUTE_CHAPTER . "
                ORDER BY `attribute_id` ASC";
        $mysqli->query($sql);
    }

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
    
    $sql = "SELECT `countryname_name_id`
            FROM `countryname`
            LEFT JOIN `city`
            ON `city_country_id`=`countryname_country_id`
            LEFT JOIN `team`
            ON `team_city_id`=`city_id`
            WHERE `team_id`='$get_num'
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
            WHERE `team_id`='$get_num'
            ORDER BY RAND()
            LIMIT 1";
    $surname_sql = $mysqli->query($sql);

    $surname_array = $surname_sql->fetch_all(MYSQLI_ASSOC);

    $surname_id = $surname_array[0]['countrysurname_surname_id'];

    $sql = "UPDATE `school`
            SET `school_height`='150'+'50'*RAND(),
                `school_name_id`='$name_id',
                `school_surname_id`='$surname_id',
                `school_weight`=`school_height`-'95'-'5'*RAND()
            WHERE `school_id`='$ok'
            LIMIT 1";
    $mysqli->query($sql);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Изменения успешно сохранены.';

    redirect('team_lineup_team_player.php?num=' . $get_num);
}

$sql = "SELECT COUNT(`position_id`) AS `count`
        FROM `position`
        WHERE `position_available`='1'";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);
$count_position = $position_array[0]['count'];

$sql = "SELECT COUNT(`school_id`) AS `count`
        FROM `school`
        WHERE `school_team_id`='$get_num'";
$school_sql = $mysqli->query($sql);

$school_array = $school_sql->fetch_all(MYSQLI_ASSOC);
$count_school = $school_array[0]['count'];

if ($count_position > $count_school)
{
    $sql = "SELECT `position_id`
            FROM `position`
            WHERE `position_available`='1'
            ORDER BY `position_id` ASC";
    $position_sql = $mysqli->query($sql);

    $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($position_array as $item)
    {
        $position_id = $item['position_id'];

        $sql = "SELECT COUNT(`school_id`) AS `count`
                FROM `school`
                WHERE `school_team_id`='$get_num'
                AND `school_position_id`='$position_id'";
        $school_sql = $mysqli->query($sql);

        $school_array = $school_sql->fetch_all(MYSQLI_ASSOC);
        $count_school = $school_array[0]['count'];

        if (0 == $count_school)
        {
            $sql = "SELECT `countryname_name_id`
                    FROM `countryname`
                    LEFT JOIN `city`
                    ON `city_country_id`=`countryname_country_id`
                    LEFT JOIN `team`
                    ON `team_city_id`=`city_id`
                    WHERE `team_id`='$get_num'
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
                    WHERE `team_id`='$get_num'
                    ORDER BY RAND()
                    LIMIT 1";
            $surname_sql = $mysqli->query($sql);

            $surname_array = $surname_sql->fetch_all(MYSQLI_ASSOC);

            $surname_id = $surname_array[0]['countrysurname_surname_id'];

            $sql = "INSERT INTO `school`
                    SET `school_height`='150'+'50'*RAND(),
                        `school_name_id`='$name_id',
                        `school_position_id`='$position_id',
                        `school_surname_id`='$surname_id',
                        `school_team_id`='$get_num',
                        `school_weight`=`school_height`-'95'-'5'*RAND()";
            $mysqli->query($sql);
        }
    }
}

$sql = "SELECT `country_id`,
               `country_name`,
               `mood_id`,
               `mood_name`,
               `name_name`,
               `position_name`,
               `school_condition`,
               `school_height`,
               `school_id`,
               `school_practice`,
               `school_weight`,
               `surname_name`
        FROM `school`
        LEFT JOIN `position`
        ON `school_position_id`=`position_id`
        LEFT JOIN `name`
        ON `school_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `school_surname_id`=`surname_id`
        LEFT JOIN `mood`
        ON `mood_id`=`school_mood_id`
        LEFT JOIN `team`
        ON `school_team_id`=`team_id`
        LEFT JOIN `city`
        ON `team_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `school_team_id`='$get_num'
        ORDER BY `school_position_id` ASC";
$school_sql = $mysqli->query($sql);

$school_array = $school_sql->fetch_all(MYSQLI_ASSOC);

$num            = $get_num;
$header_title   = $team_name;

include (__DIR__ . '/view/main.php');