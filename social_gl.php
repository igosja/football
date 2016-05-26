<?php

include (__DIR__ . '/include/include.php');

$result = false;

if (isset($_GET['code']))
{
    $params = array
    (
        'client_id'     => GL_CLIENT_ID,
        'client_secret' => GL_CLIENT_SECRET,
        'redirect_uri'  => GL_REDIRECT_URI,
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code']
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    curl_close($curl);

    $token = json_decode($result, true);


    if (isset($token['access_token']))
    {
        $params['access_token'] = $token['access_token'];

        $user_info = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);

        if (isset($user_info['id']))
        {
            $gl_id  = $user_info['id'];
            $result = true;
        }
    }
}

if ($result)
{
    $sql = "SELECT `user_id`,
                   `user_login`
            FROM `user`
            WHERE `user_social_gl`='$gl_id'
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
                SET `user_letter_first`='0',
                    `user_letter_second`='0',
                    `user_letter_third`='0'
                WHERE `user_id`='$authorization_user_id'
                LIMIT 1";
        $mysqli->query($sql);

        redirect('profile_home_home.php');
    }
    else
    {
        if (isset($authorization_user_id))
        {
            $sql = "UPDATE `user`
                    SET `user_social_gl`='$gl_id'
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
                    SET `user_login`='gl_$gl_id',
                        `user_social_gl`='$gl_id',
                        `user_referrer`='$referrer',
                        `user_registration_date`=UNIX_TIMESTAMP(),
                        `user_activation`='1'";
            $mysqli->query($sql);

            $_SESSION['authorization_id']    = $mysqli->insert_id;
            $_SESSION['authorization_login'] = $gl_id;

            redirect('questionary.php');
        }
    }
}

redirect('index.php');