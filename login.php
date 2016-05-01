<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_id))
{
    redirect('index.php');
}

if (isset($_POST['data']))
{
    $authorization_login    = $_POST['data']['login'];
    $authorization_password = $_POST['data']['password'];
    $authorization_password = f_igosja_chiper_password($authorization_password);

    $sql = "SELECT `country_id`,
                   `country_name`,
                   `team_id`,
                   `team_name`,
                   `user_id`,
                   `user_password`,
                   `userrole_permission`,
                   `user_activation`
            FROM `user`
            LEFT JOIN `userrole`
            ON `user_userrole_id`=`userrole_id`
            LEFT JOIN `team`
            ON `team_user_id`=`user_id`
            LEFT JOIN `country`
            ON `country_user_id`=`user_id`
            WHERE `user_login`=?
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $authorization_login);
    $prepare->execute();

    $user_sql = $prepare->get_result();

    $prepare->close();

    $count_user = $user_sql->num_rows;

    if (0 == $count_user)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Неправильная комбинация логин/пароль.';

        redirect('login.php');
    }

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    $user_password      = $user_array[0]['user_password'];
    $user_activation    = $user_array[0]['user_activation'];

    if ($authorization_password != $user_password)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Неправильная комбинация логин/пароль.';

        redirect('login.php');
    }
    elseif (0 == $user_activation)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Профиль не активирован после регистрации.';

        redirect('login.php');
    }

    $authorization_user_id      = $user_array[0]['user_id'];
    $authorization_team_id      = $user_array[0]['team_id'];
    $authorization_team_name    = $user_array[0]['team_name'];
    $authorization_country_id   = $user_array[0]['country_id'];
    $authorization_country_name = $user_array[0]['country_name'];
    $user_permission            = $user_array[0]['userrole_permission'];
    $user_ip                    = $_SERVER['REMOTE_ADDR'];

    $_SESSION['authorization_id']       = $authorization_user_id;
    $_SESSION['authorization_login']    = $authorization_login;

    $sql = "SELECT COUNT(`ip_id`) AS `count`
            FROM `ip`
            WHERE `ip_user_id`='$authorization_user_id'";
    $ip_sql = $mysqli->query($sql);

    $ip_array = $ip_sql->fetch_all(MYSQLI_ASSOC);
    $count_ip = $ip_array[0]['count'];

    if (10 == $count_ip)
    {
        $sql = "UPDATE `ip`
                SET `ip_ip`='$user_ip',
                    `ip_date`=UNIX_TIMESTAMP()
                WHERE `ip_user_id`='$authorization_user_id'
                ORDER BY `ip_date` ASC
                LIMIT 1";
    }
    else
    {
        $sql = "INSERT INTO `ip`
                SET `ip_ip`='$user_ip',
                    `ip_date`=UNIX_TIMESTAMP(),
                    `ip_user_id`='$authorization_user_id'";
    }

    $mysqli->query($sql);

    redirect('profile_home_home.php');
}

$header_title       = 'Вход';
$social_array       = f_igosja_social_array();
$seo_title          = $header_title . '. ' . $seo_title;
$seo_description    = $header_title . '. ' . $seo_description;
$seo_keywords       = $header_title . ', ' . $seo_keywords;

include (__DIR__ . '/view/main.php');