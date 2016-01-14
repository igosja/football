<?php

include('include/include.php');

if (isset($_POST['registration_login']))
{
    $registration_login     = $_POST['registration_login'];
    $registration_email     = $_POST['registration_email'];
    $registration_password  = $_POST['registration_password'];

    $sql = "SELECT `user_id`
            FROM `user`
            WHERE `user_login`=?
            OR `user_email`=?
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $registration_login, $registration_email);
    $prepare->execute();

    $check_sql      = $prepare->get_result();
    $count_check    = $check_sql->num_rows;

    $prepare->close();

    if (0 == $count_check)
    {
        $password = f_igosja_chiper_password($registration_password);

        $sql = "INSERT INTO `user`
                SET `user_login`=?,
                    `user_email`=?,
                    `user_password`=?,
                    `user_registration_date`=SYSDATE()";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('sss', $registration_login, $registration_email, $password);
        $prepare->execute();
        $prepare->close();

        $user_id    = $mysqli->insert_id;
        $code       = f_igosja_chiper_password($user_id);
        $href       = SITE_URL . '/activation.php?id=' . $user_id . '&code=' . $code;
        $subject    = 'Регистрация в футбольном онлайн менеджере';
        $message    = 'Для завершения регистрации перейдите по следующей ссылке - ' . $href;
        $from       = 'From: admin@' . SITE_URL;
        $mail       = mail($registration_email, $subject, $message, $from);

        $success_message = 'Профиль создан успешно.<br/>
                            Для завершения регистрации перейдите по ссылке, которая выслана вам на электронную почту.';

        $smarty->assign('success_message', $success_message);
    }
    else
    {
        $error_message = 'Пользователь с таким логином/email-ом уже зарегистрирован.';

        $smarty->assign('error_message', $error_message);
    }
}

$smarty->assign('header_title', 'Регистрация');

$smarty->display('main.html');