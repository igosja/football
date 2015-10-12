<?php

include ('include/include.php');

$error_message = 'Неправильная комбинация логин/пароль.';

if (isset($_POST['authorization_login']))
{
    $authorization_login    = $_POST['authorization_login'];
    $authorization_password = $_POST['authorization_password'];
    $authorization_password = f_igosja_chiper_password($authorization_password);

    $sql = "SELECT `user_id`,
                   `user_password`,
                   `userrole_permission`,
                   `user_activation`,
                   `team_id`,
                   `team_name`
            FROM `user`
            LEFT JOIN `userrole`
            ON `user_userrole_id`=`userrole_id`
            LEFT JOIN `team`
            ON `team_user_id`=`user_id`
            WHERE `user_login`=?
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $authorization_login);
    $prepare->execute();

    $user_sql = $prepare->get_result();

    $prepare->close();

    $count_user = $user_sql->num_rows;

    if (0 != $count_user)
    {
        $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

        $user_password      = $user_array[0]['user_password'];
        $user_activation    = $user_array[0]['user_activation'];

        if ($authorization_password != $user_password)
        {
            $smarty->assign('error_message', $error_message);
        }
        elseif (0 == $user_activation)
        {
            $error_message = 'Профиль не активирован после регистрации.';

            $smarty->assign('error_message', $error_message);
        }
        else
        {
            $user_id                    = $user_array[0]['user_id'];
            $authorization_team_id      = $user_array[0]['team_id'];
            $authorization_team_name    = $user_array[0]['team_name'];
            $user_permission            = $user_array[0]['userrole_permission'];

            $_SESSION['authorization_id']           = $user_id;
            $_SESSION['authorization_login']        = $authorization_login;
            $_SESSION['authorization_password']     = $authorization_password;
            $_SESSION['authorization_team_id']      = $authorization_team_id;
            $_SESSION['authorization_team_name']    = $authorization_team_name;
            $_SESSION['authorization_permission']   = $user_permission;

            header('Location: profile_home_home.php');

            exit;
        }
    }
    else
    {
        $smarty->assign('error_message', $error_message);
    }
}

$smarty->display('main-1.html');