<?php

include (__DIR__ . '/include/include.php');

if (isset($_POST['data']))
{
    $registration_login     = strip_tags($_POST['data']['registration_login']);
    $registration_email     = strip_tags($_POST['data']['registration_email']);
    $registration_password  = $_POST['data']['registration_password'];

    if (empty($registration_login) ||
        empty($registration_email) ||
        empty($registration_password))
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Заполнены не все поля.';

        redirect('registration.php');
    }

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

    if (0 != $count_check)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Пользователь с таким логином/email-ом уже зарегистрирован.';

        redirect('registration.php');
    }

    $password = f_igosja_chiper_password($registration_password);

    if (isset($_COOKIE['referal']))
    {
        $referrer = (int) $_COOKIE['referal'];
    }
    else
    {
        $referrer = 0;
    }

    $sql = "INSERT INTO `user`
            SET `user_login`=?,
                `user_email`=?,
                `user_password`=?,
                `user_referrer`='$referrer',
                `user_registration_date`=UNIX_TIMESTAMP()";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('sss', $registration_login, $registration_email, $password);
    $prepare->execute();
    $prepare->close();

    $user_id    = $mysqli->insert_id;
    $code       = f_igosja_chiper_password($user_id);
    $href       = 'http://' . SITE_URL . '/activation.php?id=' . $user_id . '&code=' . $code;
    $subject    = 'Регистрация в футбольном онлайн менеджере';
    $message    =
'Для завершения регистрации перейдите по следующей ссылке - ' . $href . '

Команда Виртуальной футбольной лиги';
    $from       = 'From: noreply@' . SITE_URL;
    $mail       = mail($registration_email, $subject, $message, $from);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Профиль создан успешно.<br />Для завершения регистрации перейдите по ссылке, которая выслана вам на электронную почту.';

    redirect('registration.php');
}

$header_title       = 'Регистрация';
$social_array       = f_igosja_social_array();
$seo_title          = $header_title . '. ' . $seo_title;
$seo_description    = $header_title . '. ' . $seo_description;
$seo_keywords       = $header_title . ', ' . $seo_keywords;

include (__DIR__ . '/view/main.php');