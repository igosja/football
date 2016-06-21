<?php

function redirect($location)
//Перенаправление
{
    header('Location: ' . $location);
    exit;
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
        $return = $return . '<img class="img-' . $class . '" src="/img/star/' . $star . '.png" /> ';
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
                `history_date`=UNIX_TIMESTAMP()";
    $mysqli->query($sql);
}

function f_igosja_admin_permission($permission)
//Права доступа в админку
{
    if (10 > $permission)
    {
        redirect('/admin_login.php');
    }

    return true;
}

function f_igosja_generate_password()
//Генератор пароля
{
    $chars      = 'ABCDEFGHIJKLMNPQRSTVXYZabcdefghijklmnopqrstvxyz123456789'; 
    $max        = 10;
    $size       = strlen($chars) - 1; 
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
    if (!is_numeric($date))
    {
        $date = strtotime($date);
    }

    if ($date)
    {
        $date = date('d.m.Y', $date);
    }
    else
    {
        $date = '';
    }

    return $date;
}

function f_igosja_ufu_date_time($date)
//Форматирование даты
{
    if (!is_numeric($date))
    {
        $date = strtotime($date);
    }

    if ($date)
    {
        $date = date('H:i d.m.Y', $date);
    }
    else
    {
        $date = '';
    }

    return $date;
}

function f_igosja_ufu_last_visit($date)
//Время последнего посещения
{
    if (!is_numeric($date))
    {
        $min_5  = strtotime($date . '+5 min');
        $min_60 = strtotime($date . '+60 min');
        $now    = strtotime(date('Y-m-d H:i:s'));
        $date   = strtotime($date);
    }
    else
    {
        $min_5  = $date + 5 * 60;
        $min_60 = $date + 60 * 60;
        $now    = time();
    }

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

function f_igosja_ufu_last_visit_forum($date)
//Кто онлайн на форуме
{
    if (!is_numeric($date))
    {
        $min_5  = strtotime($date . '+5 min');
        $now    = strtotime(date('Y-m-d H:i:s'));
    }
    else
    {
        $min_5  = $date + 5 * 60;
        $now    = time();
    }

    if ($min_5 >= $now)
    {
        $date = '<p class="red">онлайн</p>';
    }
    else
    {
        $date = '';
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

function f_igosja_referee_create($country_id)
//Создание судьи
{
    global $mysqli;

    $country_id = (int) $country_id;

    $sql = "SELECT `countryname_name_id`,
                   `countrysurname_surname_id`
            FROM `countryname`
            LEFT JOIN
            (
                SELECT `countrysurname_surname_id`,
                       `countrysurname_country_id`
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

    $name_array = $name_sql->fetch_all(1);

    $name_id    = $name_array[0]['countryname_name_id'];
    $surname_id = $name_array[0]['countrysurname_surname_id'];
    $age        = rand(35, 50);
    $reputation = rand(1,100);

    $sql = "INSERT INTO `referee`
            SET `referee_country_id`='$country_id',
                `referee_name_id`='$name_id',
                `referee_age`='$age',
                `referee_surname_id`='$surname_id',
                `referee_reputation`='$reputation'";
    $mysqli->query($sql);
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

    $position_array = $position_sql->fetch_all(1);

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

    $team_array = $team_sql->fetch_all(1);

    $country_id = $team_array[0]['city_country_id'];

    $sql = "SELECT `countryname_name_id`,
                   `countrysurname_surname_id`
            FROM `countryname`
            LEFT JOIN
            (
                SELECT `countrysurname_surname_id`,
                       `countrysurname_country_id`
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

    $name_array = $name_sql->fetch_all(1);

    $name_id    = $name_array[0]['countryname_name_id'];
    $surname_id = $name_array[0]['countrysurname_surname_id'];
    $height     = rand (165, 195);
    $weight     = $height - rand (95, 110);
    $age        = rand (17, 30);

    $sql = "INSERT INTO `player`
            SET `player_country_id`='$country_id',
                `player_national_id`='$country_id',
                `player_name_id`='$name_id',
                `player_age`='$age',
                `player_surname_id`='$surname_id',
                `player_team_id`='$team_id',
                `player_leg_left`='$leg_left',
                `player_leg_right`='$leg_right',
                `player_ability`='5',
                `player_height`='$height',
                `player_weight`='$weight',
                `player_position_id`='$position_id'";
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

    $post_array = $post_sql->fetch_all(1);
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

        $team_array = $team_sql->fetch_all(1);

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

        $name_array = $name_sql->fetch_all(1);

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
    global $RAND_LEG_POSITION_ARRAY;

    $leg_array = array();

    if (in_array($position_id, $LEFT_LEG_POSITION_ARRAY))
    {
        $leg_array['leg_left']  = 10;
        $leg_array['leg_right'] = 0;
    }
    elseif (in_array($position_id, $RAND_LEG_POSITION_ARRAY))
    {
        $leg = rand(1, 5);

        if (1 == $leg)
        {
            $leg_array['leg_left']  = 10;
            $leg_array['leg_right'] = 0;
        }
        else
        {
            $leg_array['leg_left']  = 0;
            $leg_array['leg_right'] = 10;
        }
    }
    else
    {
        $leg_array['leg_left']  = 0;
        $leg_array['leg_right'] = 10;
    }

    return $leg_array;
}

function f_igosja_leg_name($leg_left, $leg_right)
//Название рабочей ноги игрока (левая/правая)
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
//Цветная полоса состояния
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
//Цвет иконки позиции в зависимости от навыков игры
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

function f_igosja_social_array($user_array = '')
//Ссылки на авторизацию через соцсети
{
    $fb_params  = array('client_id' => FB_CLIENT_ID, 'redirect_uri' => FB_REDIRECT_URI, 'response_type' => 'code');
    $fb_url     = 'https://www.facebook.com/dialog/oauth?' . urldecode(http_build_query($fb_params));

    if (isset($user_array[0]['user_social_fb']))
    {
        if (empty($user_array[0]['user_social_fb']))
        {
            $fb_text = 'Связать';
        }
        else
        {
            $fb_url  = '';
            $fb_text = 'Отвязать';
        }
    }
    else
    {
        $fb_text = '';
    }

    $gl_params  = array('redirect_uri' => GL_REDIRECT_URI, 'response_type' => 'code', 'client_id' => GL_CLIENT_ID, 'scope' => 'https://www.googleapis.com/auth/userinfo.profile');
    $gl_url     = 'https://accounts.google.com/o/oauth2/auth?' . urldecode(http_build_query($gl_params));

    if (isset($user_array[0]['user_social_gl']))
    {
        if (empty($user_array[0]['user_social_gl']))
        {
            $gl_text = 'Связать';
        }
        else
        {
            $gl_url  = '';
            $gl_text = 'Отвязать';
        }
    }
    else
    {
        $gl_text = '';
    }

    $vk_params  = array('client_id' => VK_CLIENT_ID, 'redirect_uri' => VK_REDIRECT_URI, 'response_type' => 'code');
    $vk_url     = 'http://oauth.vk.com/authorize?' . urldecode(http_build_query($vk_params));

    if (isset($user_array[0]['user_social_vk']))
    {
        if (empty($user_array[0]['user_social_vk']))
        {
            $vk_text = 'Связать';
        }
        else
        {
            $vk_url  = '';
            $vk_text = 'Отвязать';
        }
    }
    else
    {
        $vk_text = '';
    }

    $social_array = array
    (
        array('alt' => 'Facebook',  'img' => 'facebook',    'url' => $fb_url, 'text' => $fb_text),
        array('alt' => 'Google',    'img' => 'google',      'url' => $gl_url, 'text' => $gl_text),
        array('alt' => 'Вконтакте', 'img' => 'vkontakte',   'url' => $vk_url, 'text' => $vk_text),
    );

    return $social_array;
}

function f_igosja_nearest_game_sort($a, $b)
{
    $a_date         = $a['shedule_date'];
    $b_date         = $b['shedule_date'];
    $sort_result    = strcmp($a_date, $b_date);

    return $sort_result;
}

function f_igosja_trophy_sort($a, $b)
{
    $a_date         = $a['season_id'];
    $b_date         = $b['season_id'];
    $sort_result    = strcmp($b_date, $a_date);

    return $sort_result;
}

function f_igosja_player_to_scout_and_fire_button($player_id)
{
    global $mysqli;
    global $authorization_team_id;

    $button_array = array();

    if (isset($authorization_team_id))
    {
        $sql = "SELECT COUNT(`scout_id`) AS `count`
                FROM `scout`
                WHERE `scout_player_id`='$player_id'
                AND `scout_team_id`='$authorization_team_id'";
        $scout_sql = $mysqli->query($sql);

        $scout_array = $scout_sql->fetch_all(1);
        $count_scout = $scout_array[0]['count'];

        $sql = "SELECT COUNT(`player_id`) AS `count`
                FROM `player`
                WHERE `player_id`='$player_id'
                AND `player_team_id`='$authorization_team_id'";
        $player_sql = $mysqli->query($sql);

        $player_array = $player_sql->fetch_all(1);
        $count_player = $player_array[0]['count'];

        $sql = "SELECT COUNT(`scoutnearest_id`) AS `count`
                FROM `scoutnearest`
                WHERE `scoutnearest_player_id`='$player_id'
                AND `scoutnearest_team_id`='$authorization_team_id'";
        $scoutnearest_sql = $mysqli->query($sql);

        $scoutnearest_array = $scoutnearest_sql->fetch_all(1);
        $count_scoutnearest = $scoutnearest_array[0]['count'];

        if (0 == $count_scout &&
            0 == $count_scoutnearest &&
            0 == $count_player)
        {
            $button_array[] = array('href' => 'player_home_scout.php?num=' . $player_id, 'class' => '', 'text' => 'Изучить');
        }

        if (1 == $count_player)
        {
            $button_array[] = array('href' => 'player_home_fire.php?num=' . $player_id, 'class' => '', 'text' => 'Уволить');
        }
    }

    return $button_array;
}

function f_igosja_penalty_player_select($team_id, $country_id, $game_id, $event_minute, $i = 0)
{
    $i++;

    if ($i < 7)
    {
        if (0 != $team_id)
        {
            $sql = "SELECT `team_penalty_player_id_" . $i . "`
                    FROM `team`
                    WHERE `team_id`='$team_id'
                    LIMIT 1";
            $penalty_sql = f_igosja_mysqli_query($sql);

            $penalty_array = $penalty_sql->fetch_all(1);

            $penalty_player_id = $penalty_array[0]['team_penalty_player_id_' . $i];
        }
        else
        {
            $sql = "SELECT `country_penalty_player_id_" . $i . "`
                    FROM `country`
                    WHERE `country_id`='$country_id'
                    LIMIT 1";
            $penalty_sql = f_igosja_mysqli_query($sql);

            $penalty_array = $penalty_sql->fetch_all(1);

            $penalty_player_id = $penalty_array[0]['country_penalty_player_id_' . $i];
        }

        if (0 == $penalty_player_id)
        {
            $penalty_array = f_igosja_penalty_player_select($team_id, $country_id, $game_id, $event_minute, $i);
        }
        else
        {
            $sql = "SELECT `lineup_id`,
                           `lineup_player_id`
                    FROM `lineup`
                    WHERE `lineup_team_id`='$team_id'
                    AND `lineup_country_id`='$country_id'
                    AND `lineup_player_id`='$penalty_player_id'
                    AND `lineup_game_id`='$game_id'
                    AND `lineup_red`='0'
                    AND `lineup_yellow`<'2'
                    AND ((`lineup_position_id` BETWEEN '2' AND '25'
                    AND (`lineup_out`='0'
                    OR `lineup_out`>='$event_minute'))
                    OR (`lineup_in`<='$event_minute'
                    AND `lineup_in`!='0'))
                    LIMIT 1";
            $player_sql = f_igosja_mysqli_query($sql);

            $count_player = $player_sql->num_rows;

            if (0 == $count_player)
            {
                $penalty_array = f_igosja_penalty_player_select($team_id, $country_id, $game_id, $event_minute, $i);
            }
            else
            {
                $player_array = $player_sql->fetch_all(1);

                $lineup_id = $player_array[0]['lineup_id'];
                $player_id = $player_array[0]['lineup_player_id'];

                $penalty_array = array('lineup_id' => $lineup_id, 'player_id' => $player_id);
            }
        }
    }
    else
    {
        $penalty_array = array();
    }

    return $penalty_array;
}