<?php

include ('include/include.php');

if (isset($_POST['forget_email']))
{
    $forget_email = $_POST['forget_email'];

    $sql = "SELECT `user_id`,
                   `user_login`
            FROM `user`
            WHERE `user_email`=?
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $forget_email);
    $prepare->execute();

    $check_sql   = $prepare->get_result();
    $count_check = $check_sql->num_rows;

    $prepare->close();

    if (0 != $count_check)
    {
        $user_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        $user_id    = $user_array[0]['user_id'];
        $user_login = $user_array[0]['user_login'];

        $password     = f_igosja_generate_password();
        $password_sql = f_igosja_chiper_password($password);

        $sql = "UPDATE `user` 
                SET `user_password`='$password_sql'
                WHERE `user_email`=?
                LIMIT 1";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $forget_email);
        $prepare->execute();
        $prepare->close();

        $subject    = 'Восстановление пароля в футбольном онлайн менеджере';
        $message    = 'Вы можете зайти на сайт под логином ' . $user_login . ' и паролем ' . $password;
        $from       = 'From: admin@' . SITE_URL;
        $mail       = mail($forget_email, $subject, $message, $from);

        $success_message = 'Пароль успешно выслан на email ' . $forget_email  . '.';

        $smarty->assign('success_message', $success_message);
    }
    else
    {
        $error_message = 'Пользователь с таким email-ом не зарегистрирован.';

        $smarty->assign('error_message', $error_message);
    }
}

$smarty->assign('header_title', 'Восстановление пароля');

$smarty->display('main.html');