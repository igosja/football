<pre>
<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

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
        $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

        $user_id    = $user_array[0]['user_id'];
        $user_login = $user_array[0]['user_login'];

        $_SESSION['authorization_id']    = $user_id;
        $_SESSION['authorization_login'] = $user_login;

        redirect('profile_home_home.php');
        exit;
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
            exit;
        }
        else
        {
            $sql = "INSERT INTO `user`
                    SET `user_social_fb`='$fb_id',
                        `user_registration_date`=SYSDATE(),
                        `user_activation`='1'";
            $mysqli->query($sql);

            $_SESSION['authorization_id']    = $mysqli->insert_id;
            $_SESSION['authorization_login'] = $fb_id;

            redirect('questionary.php');
            exit;
        }
    }
}

redirect('index.php');