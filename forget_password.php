<?php

include (__DIR__ . '/include/include.php');

if (isset($_POST['data']))
{
    $email = $_POST['data']['email'];

    $sql = "SELECT `user_id`,
                   `user_login`
            FROM `user`
            WHERE `user_email`=?
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $email);
    $prepare->execute();

    $check_sql   = $prepare->get_result();
    $count_check = $check_sql->num_rows;

    $prepare->close();

    if (0 == $count_check)
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Пользователь с таким email-ом не найден.';

        redirect('forget_password.php');
    }

    $user_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    $user_id        = $user_array[0]['user_id'];
    $user_login     = $user_array[0]['user_login'];
    $password       = f_igosja_generate_password();
    $password_sql   = f_igosja_chiper_password($password);

    $sql = "UPDATE `user` 
            SET `user_password`='$password_sql'
            WHERE `user_email`=?
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $forget_email);
    $prepare->execute();
    $prepare->close();

    $subject    = 'Восстановление пароля в футбольном онлайн менеджере';
    $message    =
'Вы можете зайти на сайт под логином ' . $user_login . ' и паролем ' . $password . '

Команда Виртуальной футбольной лиги';
    $from       = 'From: noreply@' . SITE_URL;
    $mail       = mail($email, $subject, $message, $from);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Пароль успешно выслан на email ' . $forget_email  . '.';

    redirect('forget_password.php');
}

$header_title       = 'Восстановление пароля';
$seo_title          = 'Восстановление пароля. ' . $seo_title;
$seo_description    = 'Восстановление пароля. ' . $seo_description;
$seo_keywords       = 'восстановление пароля, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');