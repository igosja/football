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

    $token = json_decode(file_get_contents('https://oauth.vk.com/access_token?' . urldecode(http_build_query($params))), true);

    if (isset($token['access_token']))
    {
        $params     = array('uids' => $token['user_id'], 'fields' => 'uid', 'access_token' => $token['access_token']);
        $user_info  = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);

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

        $_SESSION['authorization_id']    = $user_id;
        $_SESSION['authorization_login'] = $user_login;

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
            $sql = "INSERT INTO `user`
                    SET `user_social_vk`='$vk_id',
                        `user_registration_date`=SYSDATE(),
                        `user_activation`='1'";
            $mysqli->query($sql);

            $_SESSION['authorization_id']    = $mysqli->insert_id;
            $_SESSION['authorization_login'] = $vk_id;

            redirect('questionary.php');
        }
    }
}

redirect('index.php');