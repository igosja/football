<?php

include (__DIR__ . '/include/include.php');

$result = false;

if (isset($_GET['code']))
{
    $params = array
    (
        'client_id'     => FB_CLIENT_ID,
        'redirect_uri'  => FB_REDIRECT_URI,
        'client_secret' => FB_CLIENT_SECRET,
        'code'          => $_GET['code']
    );

    $url    = 'https://graph.facebook.com/oauth/access_token';
    $token  = null;
    parse_str(file_get_contents($url . '?' . http_build_query($params)), $token);

    if (isset($token['access_token']))
    {
        $params     = array('access_token' => $token['access_token']);
        $user_info  = json_decode(file_get_contents('https://graph.facebook.com/me' . '?' . urldecode(http_build_query($params))), true);

        if (isset($user_info['id']))
        {
            $fb_id  = $user_info['id'];
            $result = true;
        }
    }
}

if ($result)
{
    $sql = "SELECT `user_id`,
                   `user_login`
            FROM `user`
            WHERE `user_social_fb`='$fb_id'
            LIMIT 1";
    $user_sql = $mysqli->query($sql);

    $count_user = $user_sql->num_rows;

    if (1 == $count_user)
    {
        $user_array = $user_sql->fetch_all(1);

        $user_id    = $user_array[0]['user_id'];
        $user_login = $user_array[0]['user_login'];
        $user_ip    = $_SERVER['REMOTE_ADDR'];

        $_SESSION['authorization_user_id']  = $user_id;
        $_SESSION['authorization_login']    = $user_login;

        $sql = "SELECT COUNT(`ip_id`) AS `count`
                FROM `ip`
                WHERE `ip_user_id`='$user_id'";
        $ip_sql = $mysqli->query($sql);

        $ip_array = $ip_sql->fetch_all(1);
        $count_ip = $ip_array[0]['count'];

        if (10 == $count_ip)
        {
            $sql = "UPDATE `ip`
                    SET `ip_ip`='$user_ip',
                        `ip_date`=UNIX_TIMESTAMP()
                    WHERE `ip_user_id`='$user_id'
                    ORDER BY `ip_date` ASC
                    LIMIT 1";
        }
        else
        {
            $sql = "INSERT INTO `ip`
                    SET `ip_ip`='$user_ip',
                        `ip_date`=UNIX_TIMESTAMP(),
                        `ip_user_id`='$user_id'";
        }

        $mysqli->query($sql);

        $sql = "UPDATE `user`
                SET `user_letter`='0'
                WHERE `user_id`='$user_id'
                LIMIT 1";
        $mysqli->query($sql);

        redirect('profile_home_home.php');
    }
    else
    {
        if (isset($authorization_user_id))
        {
            $sql = "UPDATE `user`
                    SET `user_social_fb`='$fb_id'
                    WHERE `user_id`='$authorization_user_id'
                    LIMIT 1";
            $mysqli->query($sql);

            redirect('questionary.php');
        }
        else
        {
            if (isset($_COOKIE['referal']))
            {
                $referrer = (int) $_COOKIE['referal'];
            }
            else
            {
                $referrer = 0;
            }

            $sql = "INSERT INTO `user`
                    SET `user_login`='fb_$fb_id',
                        `user_referrer`='$referrer',
                        `user_registration_date`=UNIX_TIMESTAMP(),
                        `user_activation`='1'";
            $mysqli->query($sql);

            $_SESSION['authorization_id']    = $mysqli->insert_id;
            $_SESSION['authorization_login'] = $fb_id;

            redirect('questionary.php');
        }
    }
}

redirect('index.php');