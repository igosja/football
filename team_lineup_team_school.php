<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_team_id))
{
    $num_get = $authorization_team_id;
}
else
{
    include (__DIR__ . '/view/only_my_team.php');
    exit;
}

$sql = "SELECT `team_name`,
               `team_school_use`
        FROM `team`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$team_sql = $mysqli->query($sql);

$count_team = $team_sql->num_rows;

if (0 == $count_team)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$team_array = $team_sql->fetch_all(1);

$team_name  = $team_array[0]['team_name'];
$school_use = $team_array[0]['team_school_use'];

if (isset($_GET['school_id']) && isset($_GET['ok']))
{
    if (0 == $school_use)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Вы больше не можете подписывать юниоров в этом сезоне.';

        redirect('team_lineup_team_school.php?num=' . $num_get);
    }

    $school_id  = (int) $_GET['school_id'];
    $ok         = (int) $_GET['ok'];

    $sql = "SELECT `city_country_id`,
                   `name_name`,
                   `position_description`,
                   `school_height`,
                   `school_name_id`,
                   `school_position_id`,
                   `school_surname_id`,
                   `school_weight`,
                   `staff_reputation`,
                   `surname_name`,
                   `team_school_level`
            FROM `school`
            LEFT JOIN `team`
            ON `team_id`=`school_team_id`
            LEFT JOIN `city`
            ON `team_city_id`=`city_id`
            LEFT JOIN `name`
            ON `school_name_id`=`name_id`
            LEFT JOIN `surname`
            ON `school_surname_id`=`surname_id`
            LEFT JOIN `position`
            ON `school_position_id`=`position_id`
            LEFT JOIN `staff`
            ON `staff_team_id`=`team_id`
            WHERE `school_team_id`='$num_get'
            AND `school_id`='$school_id'
            AND `staff_staffpost_id`='" . STAFFPOST_SCHOOL . "'";
    $school_sql = $mysqli->query($sql);

    $count_school = $school_sql->num_rows;

    if (0 == $count_school)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Игрок выбран неправильно.';

        redirect('team_lineup_team_school.php?num=' . $num_get);
    }

    $school_array = $school_sql->fetch_all(1);

    $country_id     = $school_array[0]['city_country_id'];
    $position_id    = $school_array[0]['school_position_id'];
    $name_id        = $school_array[0]['school_name_id'];
    $name           = $school_array[0]['name_name'];
    $surname_id     = $school_array[0]['school_surname_id'];
    $surname        = $school_array[0]['surname_name'];
    $position       = $school_array[0]['position_description'];
    $height         = $school_array[0]['school_height'];
    $weight         = $school_array[0]['school_weight'];
    $school_level   = $school_array[0]['team_school_level'];
    $staff_level    = $school_array[0]['staff_reputation'];
    $level          = ceil(($school_level * 10 + $staff_level) / 3);

    if (10 > $level)
    {
        $level = 10;
    }

    $ability    = $level - rand(0, 9);
    $age        = 17;

    if (1 == $ok)
    {
        $leg_array = f_igosja_player_leg($position_id);
        $leg_left  = $leg_array['leg_left'];
        $leg_right = $leg_array['leg_right'];

        $sql = "INSERT INTO `player`
                SET `player_country_id`='$country_id',
                    `player_name_id`='$name_id',
                    `player_age`='$age',
                    `player_surname_id`='$surname_id',
                    `player_team_id`='$num_get',
                    `player_leg_left`='$leg_left',
                    `player_leg_right`='$leg_right',
                    `player_ability`='$ability',
                    `player_height`='$height',
                    `player_weight`='$weight',
                    `player_position_id`='$position_id'";
        $mysqli->query($sql);

        $player_id = $mysqli->insert_id;

        f_igosja_history(HISTORY_TEXT_PLAYER_COME_FROM_SCHOOL, $authorization_user_id, 0, $num_get, $player_id);

        if (GK_POSITION_ID == $position_id)
        {
            $sql = "INSERT INTO `playerattribute` (`playerattribute_player_id`, `playerattribute_attribute_id`, `playerattribute_value`)
                    SELECT '$player_id', `attribute_id`, '$level' - '9' * RAND()
                    FROM `attribute`
                    WHERE `attribute_attributechapter_id`!=" . FIELD_ATTRIBUTE_CHAPTER . "
                    ORDER BY `attribute_id` ASC";
            $mysqli->query($sql);
        }
        else
        {
            $sql = "INSERT INTO `playerattribute` (`playerattribute_player_id`, `playerattribute_attribute_id`, `playerattribute_value`)
                    SELECT '$player_id', `attribute_id`, '$level' - '9' * RAND()
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
                WHERE `team_id`='$num_get'
                ORDER BY RAND()
                LIMIT 1";
        $name_sql = $mysqli->query($sql);

        $name_array = $name_sql->fetch_all(1);

        $name_id = $name_array[0]['countryname_name_id'];

        $sql = "SELECT `countrysurname_surname_id`
                FROM `countrysurname`
                LEFT JOIN `city`
                ON `city_country_id`=`countrysurname_country_id`
                LEFT JOIN `team`
                ON `team_city_id`=`city_id`
                WHERE `team_id`='$num_get'
                AND `countrysurname_surname_id`
                NOT IN
                (
                    SELECT `player_surname_id`
                    FROM `player`
                    WHERE `player_team_id`='$num_get'
                )
                ORDER BY RAND()
                LIMIT 1";
        $surname_sql = $mysqli->query($sql);

        $surname_array = $surname_sql->fetch_all(1);

        $surname_id = $surname_array[0]['countrysurname_surname_id'];

        $sql = "UPDATE `school`
                SET `school_height`='165'+'35'*RAND(),
                    `school_name_id`='$name_id',
                    `school_surname_id`='$surname_id',
                    `school_weight`=`school_height`-'95'-'5'*RAND()
                WHERE `school_id`='$school_id'
                LIMIT 1";
        $mysqli->query($sql);

        $sql = "UPDATE `team`
                SET `team_school_use`=`team_school_use`-'1'
                WHERE `team_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Изменения успешно сохранены.';

        redirect('team_lineup_team_player.php?num=' . $num_get);
    }
}
elseif (isset($_GET['data']) && isset($_GET['ok']))
{
    if (0 == $school_use)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Вы больше не можете подписывать юниоров в этом сезоне.';

        redirect('team_lineup_team_school.php?num=' . $num_get);
    }

    $data_array     = $_GET['data'];
    $ok             = (int) $_GET['ok'];
    $name_id        = (int) $data_array['name_id'];
    $surname_id     = (int) $data_array['surname_id'];
    $position_id    = (int) $data_array['position_id'];
    $country_id     = (int) $data_array['country_id'];
    $height         = (int) $data_array['height'];
    $weight         = (int) $data_array['weight'];

    $sql = "SELECT `name_name`
            FROM `name`
            WHERE `name_id`='$name_id'
            LIMIT 1";
    $name_sql = $mysqli->query($sql);

    $count_name = $name_sql->num_rows;

    if (0 == $count_name)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Игрок выбран неправильно.';

        redirect('team_lineup_team_school.php?num=' . $num_get);
    }

    $name_array = $name_sql->fetch_all(1);

    $name = $name_array[0]['name_name'];

    $sql = "SELECT `surname_name`
            FROM `surname`
            WHERE `surname_id`='$surname_id'
            LIMIT 1";
    $surname_sql = $mysqli->query($sql);

    $count_surname = $surname_sql->num_rows;

    if (0 == $count_surname)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Игрок выбран неправильно.';

        redirect('team_lineup_team_school.php?num=' . $num_get);
    }

    $surname_array = $surname_sql->fetch_all(1);

    $surname = $surname_array[0]['surname_name'];

    $sql = "SELECT `position_description`
            FROM `position`
            WHERE `position_id`='$position_id'
            LIMIT 1";
    $position_sql = $mysqli->query($sql);

    $count_position = $position_sql->num_rows;

    if (0 == $count_position)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Игрок выбран неправильно.';

        redirect('team_lineup_team_school.php?num=' . $num_get);
    }

    $position_array = $position_sql->fetch_all(1);

    $position = $position_array[0]['position_description'];

    $sql = "SELECT `country_name`
            FROM `country`
            WHERE `country_id`='$country_id'
            LIMIT 1";
    $country_sql = $mysqli->query($sql);

    $count_country = $country_sql->num_rows;

    if (0 == $count_country)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Игрок выбран неправильно.';

        redirect('team_lineup_team_school.php?num=' . $num_get);
    }

    $sql = "SELECT `team_school_level`,
                   `staff_reputation`
            FROM `team`
            LEFT JOIN `staff`
            ON `staff_team_id`=`team_id`
            WHERE `team_id`='$num_get'
            AND `staff_staffpost_id`='" . STAFFPOST_SCHOOL . "'
            LIMIT 1";
    $team_sql = $mysqli->query($sql);

    $count_team = $team_sql->num_rows;

    if (0 == $count_team)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Игрок выбран неправильно.';

        redirect('team_lineup_team_school.php?num=' . $num_get);
    }

    $team_array = $team_sql->fetch_all(1);

    $school_level   = $team_array[0]['team_school_level'];
    $staff_level    = $team_array[0]['staff_reputation'];
    $level          = ceil(($school_level * 10 + $staff_level) / 3);

    if (10 > $level)
    {
        $level = 10;
    }

    $ability    = $level - rand(0, 9);
    $age        = 17;

    if (1 == $ok)
    {
        $leg_array = f_igosja_player_leg($position_id);
        $leg_left  = $leg_array['leg_left'];
        $leg_right = $leg_array['leg_right'];

        $sql = "INSERT INTO `player`
                SET `player_country_id`='$country_id',
                    `player_name_id`='$name_id',
                    `player_age`='$age',
                    `player_surname_id`='$surname_id',
                    `player_team_id`='$num_get',
                    `player_leg_left`='$leg_left',
                    `player_leg_right`='$leg_right',
                    `player_ability`='$ability',
                    `player_height`='$height',
                    `player_weight`='$weight',
                    `player_position_id`='$position_id'";
        $mysqli->query($sql);

        $player_id = $mysqli->insert_id;

        f_igosja_history(HISTORY_TEXT_PLAYER_COME_FROM_SCHOOL, $authorization_user_id, 0, $num_get, $player_id); 

        if (GK_POSITION_ID == $position_id)
        {
            $sql = "INSERT INTO `playerattribute` (`playerattribute_player_id`, `playerattribute_attribute_id`, `playerattribute_value`)
                    SELECT '$player_id', `attribute_id`, '$level' - '9' * RAND()
                    FROM `attribute`
                    WHERE `attribute_attributechapter_id`!=" . FIELD_ATTRIBUTE_CHAPTER . "
                    ORDER BY `attribute_id` ASC";
            $mysqli->query($sql);
        }
        else
        {
            $sql = "INSERT INTO `playerattribute` (`playerattribute_player_id`, `playerattribute_attribute_id`, `playerattribute_value`)
                    SELECT '$player_id', `attribute_id`, '$level' - '9' * RAND()
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
                    `player_power`=`power`,
                    `player_reputation`=`power`/'" . MAX_PLAYER_POWER . "'*'100'
                WHERE `player_id`='$player_id'";
        $mysqli->query($sql);

        $sql = "UPDATE `team`
                SET `team_school_use`=`team_school_use`-'1'
                WHERE `team_id`='$num_get'
                LIMIT 1";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Изменения успешно сохранены.';

        redirect('team_lineup_team_player.php?num=' . $num_get);
    }
}

$sql = "SELECT COUNT(`position_id`) AS `count`
        FROM `position`
        WHERE `position_available`='1'";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(1);
$count_position = $position_array[0]['count'];

$sql = "SELECT COUNT(`school_id`) AS `count`
        FROM `school`
        WHERE `school_team_id`='$num_get'";
$school_sql = $mysqli->query($sql);

$school_array = $school_sql->fetch_all(1);
$count_school = $school_array[0]['count'];

if ($count_position > $count_school)
{
    $sql = "SELECT `position_id`
            FROM `position`
            WHERE `position_available`='1'
            ORDER BY `position_id` ASC";
    $position_sql = $mysqli->query($sql);

    $position_array = $position_sql->fetch_all(1);

    foreach ($position_array as $item)
    {
        $position_id = $item['position_id'];

        $sql = "SELECT COUNT(`school_id`) AS `count`
                FROM `school`
                WHERE `school_team_id`='$num_get'
                AND `school_position_id`='$position_id'";
        $school_sql = $mysqli->query($sql);

        $school_array = $school_sql->fetch_all(1);
        $count_school = $school_array[0]['count'];

        if (0 == $count_school)
        {
            $sql = "SELECT `countryname_name_id`
                    FROM `countryname`
                    LEFT JOIN `city`
                    ON `city_country_id`=`countryname_country_id`
                    LEFT JOIN `team`
                    ON `team_city_id`=`city_id`
                    WHERE `team_id`='$num_get'
                    AND `countryname_name_id`
                    NOT IN
                    (
                        SELECT `player_name_id`
                        FROM `player`
                        WHERE `player_team_id`='$num_get'
                    )
                    ORDER BY RAND()
                    LIMIT 1";
            $name_sql = $mysqli->query($sql);

            $name_array = $name_sql->fetch_all(1);

            $name_id = $name_array[0]['countryname_name_id'];

            $sql = "SELECT `countrysurname_surname_id`
                    FROM `countrysurname`
                    LEFT JOIN `city`
                    ON `city_country_id`=`countrysurname_country_id`
                    LEFT JOIN `team`
                    ON `team_city_id`=`city_id`
                    WHERE `team_id`='$num_get'
                    AND `countrysurname_surname_id`
                    NOT IN
                    (
                        SELECT `player_surname_id`
                        FROM `player`
                        WHERE `player_team_id`='$num_get'
                    )
                    ORDER BY RAND()
                    LIMIT 1";
            $surname_sql = $mysqli->query($sql);

            $surname_array = $surname_sql->fetch_all(1);

            $surname_id = $surname_array[0]['countrysurname_surname_id'];

            $sql = "INSERT INTO `school`
                    SET `school_height`='165'+'35'*RAND(),
                        `school_name_id`='$name_id',
                        `school_position_id`='$position_id',
                        `school_surname_id`='$surname_id',
                        `school_team_id`='$num_get',
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
        WHERE `school_team_id`='$num_get'
        ORDER BY `school_position_id` ASC";
$school_sql = $mysqli->query($sql);

$school_array = $school_sql->fetch_all(1);

$sql = "SELECT `position_id`,
               `position_name`
        FROM `position`
        WHERE `position_available`='1'
        ORDER BY `position_id` ASC";
$position_sql = $mysqli->query($sql);

$position_array = $position_sql->fetch_all(1);

$sql = "SELECT `surname_id`,
               `surname_name`
        FROM `countrysurname`
        LEFT JOIN `surname`
        ON `surname_id`=`countrysurname_surname_id`
        LEFT JOIN `city`
        ON `countrysurname_country_id`=`city_country_id`
        LEFT JOIN `team`
        ON `team_city_id`=`city_id`
        WHERE `team_id`='$num_get'
        ORDER BY `surname_name` ASC";
$surname_sql = $mysqli->query($sql);

$surname_array = $surname_sql->fetch_all(1);

$sql = "SELECT `name_id`,
               `name_name`
        FROM `countryname`
        LEFT JOIN `name`
        ON `name_id`=`countryname_name_id`
        LEFT JOIN `city`
        ON `countryname_country_id`=`city_country_id`
        LEFT JOIN `team`
        ON `team_city_id`=`city_id`
        WHERE `team_id`='$num_get'
        ORDER BY `name_name` ASC";
$name_sql = $mysqli->query($sql);

$name_array = $name_sql->fetch_all(1);

$sql = "SELECT `mood_id`,
               `mood_name`
        FROM `mood`
        WHERE `mood_id`='4'
        LIMIT 1";
$mood_sql = $mysqli->query($sql);

$mood_array = $mood_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        LEFT JOIN `city`
        ON `city_country_id`=`country_id`
        LEFT JOIN `team`
        ON `team_city_id`=`city_id`
        WHERE `team_id`='$num_get'
        LIMIT 1";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $team_name;
$seo_title          = $header_title . '. Спортшкола. ' . $seo_title;
$seo_description    = $header_title . '. Спортшкола. ' . $seo_description;
$seo_keywords       = $header_title . ', спортшкола, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');