<?php

include (__DIR__ . '/include/include.php');

$result = false;

if (isset($_GET['code']))
{
    $params = array
    (
        'client_id'     => VK_CLIENT_ID,
        'client_secret' => VK_CLIENT_SECRET,
        'code'          => $_GET['code'],
        'redirect_uri'  => VK_REDIRECT_URI
    );

    try
    {
        $token = json_decode(@file_get_contents('https://oauth.vk.com/access_token?' . urldecode(http_build_query($params))), true);
    }
    catch (Exception $e)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Сайт Вконтакте предоставил не правильный ответ. Попробуйте еще раз.';

        redirect('index.php');
    }

    if (isset($token['access_token']))
    {
        $params     = array('uids' => $token['user_id'], 'fields' => 'uid', 'access_token' => $token['access_token']);

        try
        {
            $user_info  = json_decode(@file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
        }
        catch (Exception $e)
        {
            $_SESSION['message_class']  = 'error';
            $_SESSION['message_text']   = 'Сайт Вконтакте предоставил не правильный ответ. Попробуйте еще раз.';

            redirect('index.php');
        }

        if (isset($user_info['response'][0]['uid']))
        {
            $vk_id  = $user_info['response'][0]['uid'];
            $result = true;
        }
    }
}

if ($result)
{
    $sql = "SELECT `user_id`,
                   `user_login`
            FROM `user`
            WHERE `user_social_vk`='$vk_id'
            LIMIT 1";
    $user_sql = $mysqli->query($sql);

    $count_user = $user_sql->num_rows;

    if (1 == $count_user)
    {
        $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

        $user_id    = $user_array[0]['user_id'];
        $user_login = $user_array[0]['user_login'];
        $user_ip    = $_SERVER['REMOTE_ADDR'];

        $_SESSION['authorization_id']    = $user_id;
        $_SESSION['authorization_login'] = $user_login;

        $sql = "SELECT COUNT(`ip_id`) AS `count`
                FROM `ip`
                WHERE `ip_user_id`='$user_id'";
        $ip_sql = $mysqli->query($sql);

        $ip_array = $ip_sql->fetch_all(MYSQLI_ASSOC);
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
                    SET `user_social_vk`='$vk_id'
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
                    SET `user_login`='vk_$vk_id',
                        `user_social_vk`='$vk_id',
                        `user_referrer`='$referrer',
                        `user_registration_date`=UNIX_TIMESTAMP(),
                        `user_activation`='1'";
            $mysqli->query($sql);

            $_SESSION['authorization_id']    = $mysqli->insert_id;
            $_SESSION['authorization_login'] = $vk_id;

            redirect('questionary.php');
        }
    }
}

redirect('index.php');