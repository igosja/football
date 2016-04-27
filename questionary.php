<?php

include (__DIR__ . '/include/include.php');

if (isset($_POST['data']))
{
    $firstname  = strip_tags($_POST['data']['firstname']);
    $lastname   = strip_tags($_POST['data']['lastname']);
    $day        = (int) $_POST['data']['birth']['day'];
    $month      = (int) $_POST['data']['birth']['month'];
    $year       = (int) $_POST['data']['birth']['year'];
    $country_id = (int) $_POST['data']['country'];

    if (isset($_POST['data']['gender']))
    {
        $gender = (int) $_POST['data']['gender'];
    }
    else
    {
        $gender = 1;
    }

    $sql = "UPDATE `user`
            SET `user_firstname`=?,
                `user_lastname`=?,
                `user_gender`=?,
                `user_birth_day`=?,
                `user_birth_month`=?,
                `user_birth_year`=?,
                `user_country_id`=?
            WHERE `user_id`='$authorization_id'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ssiiiii', $firstname, $lastname, $gender, $day, $month, $year, $country_id);
    $prepare->execute();
    $prepare->close();

    if (!empty($_POST['password']))
    {
        $password = f_igosja_chiper_password($_POST['password']);

        $sql = "UPDATE `user`
                SET `user_password`='$password'
                WHERE `user_id`='$authorization_id'
                LIMIT 1";
        $mysqli->query($sql);
    }

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Данные успешно сохранены';

    if (isset($_POST['data']['email']))
    {
        $email = $_POST['data']['email'];

        $sql = "SELECT `user_id`
                FROM `user`
                WHERE `user_id`!='$authorization_id'
                AND `user_email`=?
                LIMIT 1";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $email);
        $prepare->execute();

        $check_sql      = $prepare->get_result();
        $count_check    = $check_sql->num_rows;

        $prepare->close();

        if (0 == $count_check)
        {
            $sql = "UPDATE `user`
                    SET `user_email`=?
                    WHERE `user_id`='$authorization_id'
                    LIMIT 1";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $email);
            $prepare->execute();
            $prepare->close();
        }
        else
        {
            $_SESSION['message_class']  = 'error';
            $_SESSION['message_text']   = 'Пользователь с таким e-mail уже зарегистрирован';
        }
    }

    if (isset($_POST['data']['login']))
    {
        $login = $_POST['data']['login'];

        $sql = "SELECT `user_id`
                FROM `user`
                WHERE `user_id`!='$authorization_id'
                AND `user_login`=?
                LIMIT 1";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $login);
        $prepare->execute();

        $check_sql      = $prepare->get_result();
        $count_check    = $check_sql->num_rows;

        $prepare->close();

        if (0 == $count_check)
        {
            $sql = "UPDATE `user`
                    SET `user_login`=?
                    WHERE `user_id`='$authorization_id'
                    LIMIT 1";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $login);
            $prepare->execute();
            $prepare->close();

            $_SESSION['authorization_login'] = $login;
        }
        else
        {
            $_SESSION['message_class']  = 'error';
            $_SESSION['message_text']   = 'Пользователь с таким логином уже зарегистрирован';
        }
    }

    redirect('questionary.php');
}

$sql = "SELECT `user_birth_day`,
               `user_birth_month`,
               `user_birth_year`,
               `user_country_id`,
               `user_email`,
               `user_firstname`,
               `user_gender`,
               `user_lastname`,
               `user_login`,
               `user_social_fb`,
               `user_social_gl`,
               `user_social_vk`
        FROM `user`
        WHERE `user_id`='$authorization_id'
        LIMIT 1";
$user_sql = $mysqli->query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$social_array = f_igosja_social_array($user_array);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_id`!='0'
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `gender_id`,
               `gender_name`
        FROM `gender`
        ORDER BY `gender_id` ASC";
$gender_sql = $mysqli->query($sql);

$gender_array = $gender_sql->fetch_all(MYSQLI_ASSOC);

$header_title = $authorization_login;

include (__DIR__ . '/view/main.php');