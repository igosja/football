<?php

function f_igosja_draw_diagram($data_array, $img)
//Прописовка круговой диаграммы
{
    $color_array = array
    (
        imagecolorallocate($img,  61, 145,  67),
        imagecolorallocate($img, 222, 164,   9),
        imagecolorallocate($img, 216,  80,  26),
        imagecolorallocate($img, 214,  14,   6),
        imagecolorallocate($img, 193, 223, 243),
        imagecolorallocate($img,  51,  53,  56),
        imagecolorallocate($img, 190, 198, 204),
    );

    $count_data = count($data_array);
    $sum_data   = array_sum($data_array);

    if (0 == $sum_data)
    {
        $sum_data = 1;
    }

    $end_angle  = floor(0 + (($data_array[0] * 100) / $sum_data) * 360 / 100);
    $center_x   = 200;
    $center_y   = 200;
    $radius     = 200;

    imagefilledarc($img, $center_x, $center_y, $radius * 2, $radius * 2, 0, $end_angle, $color_array[0], IMG_ARC_PIE);

    for ($i=1; $i<$count_data; $i++)
    {
        $begin_angle = $end_angle;
        $end_angle   = floor($begin_angle + (($data_array[$i] * 100) / $sum_data) * 360 / 100);

        imagefilledarc($img, $center_x, $center_y, $radius * 2, $radius * 2, $begin_angle, $end_angle, $color_array[$i], IMG_ARC_PIE);
    }

    imagefilledarc($img, $center_x, $center_y, $radius * 2, $radius * 2, $end_angle, 360, $color_array[$count_data-1], IMG_ARC_PIE);
}

function redirect($location)
//Перенаправление
{
    header('Location: ' . $location);
}

function f_igosja_five_star($value, $class)
//Репутация звездочками
{
    $value = round($value / 5, 1);
    $return = '';

    for ($i=2; $i<=10; $i=$i+2)
    {
        if ($i > $value)
        {
            $star = 0;
        }
        elseif ($i == $value)
        {
            $star = 1;
        }
        else
        {
            $star = 2;
        }

        $value  = $value - 2;
        $return = $return . '<img class="img-' . $class . '" src="img/star/' . $star . '.png" /> ';
    }

    return $return;
}

function f_igosja_money($money)
//Денежный формат
{
    if ($money >= 1000000000)
    {
        $money = round($money / 1000000000, 2) . ' млрд. $';
    }
    elseif ($money >= 1000000)
    {
        $money = round($money / 1000000, 2) . ' млн. $';
    }
    elseif ($money >= 1000)
    {
        $money = round($money / 1000, 2) . ' тыс. $';
    }
    elseif ($money >= 0)
    {
        $money = $money . ' $';
    }
    elseif ($money >= -1000)
    {
        $money = '<span class="red">' . $money . ' $</span>';
    }
    elseif ($money >= -1000000)
    {
        $money = '<span class="red">' . round($money / 1000, 2) . ' тыс. $</span>';
    }
    elseif ($money >= -1000000000)
    {
        $money = '<span class="red">' . round($money / 1000000, 2) . ' млн. $</span>';
    }
    else
    {
        $money = '<span class="red">' . round($money / 1000000000, 2) . ' млрд. $</span>';
    }

    return $money;
}

function f_igosja_history($history_id, $user_id=0, $country_id=0, $team_id=0, $player_id=0)
//История действий
{
    global $mysqli;
    global $igosja_season_id;

    $history_id = (int) $history_id;
    $country_id = (int) $country_id;
    $team_id    = (int) $team_id;
    $user_id    = (int) $user_id;
    $player_id  = (int) $player_id;

    $sql = "INSERT INTO `history`
            SET `history_historytext_id`='$history_id',
                `history_country_id`='$country_id',
                `history_team_id`='$team_id',
                `history_user_id`='$user_id',
                `history_season_id`='$igosja_season_id',
                `history_player_id`='$player_id',
                `history_date`=SYSDATE()";
    $mysqli->query($sql);
}

function f_igosja_admin_permission($permission)
//Права доступа в админку
{
    if (10 <= $permission)
    {
        return true;
    }
    else
    {
        header('Location: /index.php');

        exit;
    }
}

function f_igosja_generate_password()
//Генератор пароля
{
    $chars      = 'ABCDEFGHIJKLMNPQRSTVXYZabcdefghijklmnopqrstvxyz123456789'; 
    $max        = 10;
    $size       = StrLen($chars) - 1; 
    $password   = ''; 

    for ($i=0; $i<$max; $i++)
    {
        $place      = rand(0,$size);
        $symbol     = $chars[$place];
        $password   = $password . $symbol;
    }

    return $password;
}

function f_igosja_ufu_date($date)
//Форматирование даты
{
    $date = strtotime($date);
    $date = date('d.m.Y', $date);

    return $date;
}

function f_igosja_ufu_last_visit($date)
//Время последнего посещения
{
    $min_5  = strtotime($date . '+5 min');
    $min_60 = strtotime($date . '+60 min');
    $now    = strtotime(date('Y-m-d H:i:s'));
    $date   = strtotime($date);

    if ($min_5 >= $now)
    {
        $date = 'онлайн';
    }
    elseif ($min_60 >= $now)
    {
        $difference = $now - $date;
        $difference = $difference / 60;
        $difference = round($difference, 0);
        $date       = $difference . ' минут назад';
    }
    else
    {
        $date = date('H:i d.m.Y', $date);
    }

    return $date;
}

function f_igosja_chiper_password($password)
//Шифрование пароля
{
    $salt       = 'igosja';
    $salt       = md5($salt);
    $password   = $password . $salt;
    $password   = md5($password);

    return $password;
}

function f_igosja_player_create($team_id, $i)
//Создание игроков при создании команды в админке
{
    global $mysqli;

    $team_id    = (int) $team_id;
    $i          = (int) $i + 1;

    $sql = "SELECT `positioncreate_position_id`
            FROM `positioncreate`
            WHERE `positioncreate_id`='$i'";
    $position_sql = $mysqli->query($sql);

    $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

    $position_id = $position_array[0]['positioncreate_position_id'];

    $leg_array = f_igosja_player_leg($position_id);
    $leg_left  = $leg_array['leg_left'];
    $leg_right = $leg_array['leg_right'];

    $sql = "SELECT `city_country_id`
            FROM `team`
            LEFT JOIN `city`
            ON `team_city_id`=`city_id`
            WHERE `team_id`='$team_id'
            LIMIT 1";
    $team_sql = $mysqli->query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    $country_id = $team_array[0]['city_country_id'];

    $sql = "SELECT `countryname_name_id`, `countrysurname_surname_id`
            FROM `countryname`
            LEFT JOIN
            (
                SELECT `countrysurname_surname_id`, `countrysurname_country_id`
                FROM `countrysurname`
                WHERE `countrysurname_country_id`='$country_id'
                ORDER BY RAND()
                LIMIT 1
            ) AS `t2`
            ON `countrysurname_country_id`=`countryname_country_id`
            WHERE `countryname_country_id`='$country_id'
            ORDER BY RAND()
            LIMIT 1";
    $name_sql = $mysqli->query($sql);

    $name_array = $name_sql->fetch_all(MYSQLI_ASSOC);

    $name_id    = $name_array[0]['countryname_name_id'];
    $surname_id = $name_array[0]['countrysurname_surname_id'];
    $height     = rand (155, 195);
    $weight     = $height - rand (95, 110);
    $age        = rand (17, 30);

    $sql = "INSERT INTO `player`
            SET `player_country_id`='$country_id',
                `player_name_id`='$name_id',
                `player_age`='$age',
                `player_surname_id`='$surname_id',
                `player_team_id`='$team_id',
                `player_leg_left`='$leg_left',
                `player_leg_right`='$leg_right',
                `player_ability_current`='5',
                `player_ability_max`='10',
                `player_height`='$height',
                `player_weight`='$weight'";
    $mysqli->query($sql);

    $player_id = $mysqli->insert_id;

    if (GK_POSITION_ID == $position_id)
    {
        $sql = "INSERT INTO `playerattribute` (`playerattribute_player_id`, `playerattribute_attribute_id`, `playerattribute_value`)
                SELECT '$player_id', `attribute_id`, '1'
                FROM `attribute`
                WHERE `attribute_attributechapter_id`!=" . FIELD_ATTRIBUTE_CHAPTER . "
                ORDER BY `attribute_id` ASC";
        $mysqli->query($sql);
    }
    else
    {
        $sql = "INSERT INTO `playerattribute` (`playerattribute_player_id`, `playerattribute_attribute_id`, `playerattribute_value`)
                SELECT '$player_id', `attribute_id`, '1'
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
}

function f_igosja_staff_create($team_id)
//Создание персонала при создании команды в админке
{
    global $mysqli;

    $team_id = (int) $team_id;

    $sql = "SELECT `staffpost_id`
            FROM `staffpost`
            ORDER BY `staffpost_id` ASC";
    $post_sql = $mysqli->query($sql);

    $post_array = $post_sql->fetch_all(MYSQLI_ASSOC);
    $count_post = $post_sql->num_rows;

    for ($i=0; $i<$count_post; $i++)
    {
        $post_id = $post_array[$i]['staffpost_id'];
        $age     = rand (30, 50);

        $sql = "SELECT `city_country_id`
                FROM `team`
                LEFT JOIN `city`
                ON `team_city_id`=`city_id`
                WHERE `team_id`='$team_id'
                LIMIT 1";
        $team_sql = $mysqli->query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        $country_id = $team_array[0]['city_country_id'];

        $sql = "SELECT `countryname_name_id`, `countrysurname_surname_id`
                FROM `countryname`
                LEFT JOIN
                (
                    SELECT `countrysurname_surname_id`, `countrysurname_country_id`
                    FROM `countrysurname`
                    WHERE `countrysurname_country_id`='$country_id'
                    ORDER BY RAND()
                    LIMIT 1
                ) AS `t2`
                ON `countrysurname_country_id`=`countryname_country_id`
                WHERE `countryname_country_id`='$country_id'
                ORDER BY RAND()
                LIMIT 1";
        $name_sql = $mysqli->query($sql);

        $name_array = $name_sql->fetch_all(MYSQLI_ASSOC);

        $name_id    = $name_array[0]['countryname_name_id'];
        $surname_id = $name_array[0]['countrysurname_surname_id'];

        $sql = "INSERT INTO `staff`
                SET `staff_team_id`='$team_id',
                    `staff_staffpost_id`='$post_id',
                    `staff_country_id`='$country_id',
                    `staff_name_id`='$name_id',
                    `staff_surname_id`='$surname_id',
                    `staff_age`='$age'";
        $mysqli->query($sql);

        $staff_id = $mysqli->insert_id;

        $sql = "INSERT INTO `staffattribute` (`staffattribute_staff_id`, `staffattribute_attributestaff_id`, `staffattribute_value`)
                SELECT '$staff_id', `attributestaff_id`, '1'
                FROM `attributestaff`
                ORDER BY `attributestaff_id` ASC";
        $mysqli->query($sql);
    }
}

function f_igosja_player_leg($position_id)
//Рабочая нога игрока (левая/правая)
{
    global $LEFT_LEG_POSITION_ARRAY;

    $leg_array = array();

    if (in_array($position_id, $LEFT_LEG_POSITION_ARRAY))
    {
        $leg_array['leg_left']  = 10;
        $leg_array['leg_right'] = 0;
    }
    else
    {
        $leg_array['leg_left']  = 0;
        $leg_array['leg_right'] = 10;
    }

    return $leg_array;
}

function f_igosja_leg_name($leg_left, $leg_right)
{
    if (8 <= $leg_left &&
        8 <= $leg_right)
    {
        $leg_name = 'Обе';
    }
    elseif (8 <= $leg_left)
    {
        $leg_name = 'Левая';
    }
    else
    {
        $leg_name = 'Правая';
    }

    return $leg_name;
}

function f_igosja_progress_class($value)
{
    if (80 < $value)
    {
        $class = 'progress-bar-green';
    }
    elseif (50 < $value)
    {
        $class = 'progress-bar-yellow';
    }
    else
    {
        $class = 'progress-bar-red';
    }

    return $class;
}

function f_igosja_position_icon($value)
{
    if (80 < $value)
    {
        $icon = 1;
    }
    elseif(50 < $value)
    {
        $icon = 2;
    }
    else
    {
        $icon = 3;
    }
    
    return $icon;
}