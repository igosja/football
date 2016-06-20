<?php

include (__DIR__ . '/include/include.php');

if (!isset($authorization_id))
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

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

    if (isset($_FILES['logo']))
    {
        $file = $_FILES['logo'];

        if (in_array($file['type'], array('image/jpeg', 'image/png', 'image/gif')))
        {
            $sizeh          = 90;
            $sizew          = 90;
            $image_url      = $file['tmp_name'];
            $image_info     = getimagesize($image_url);
            $image_height   = $image_info[1];
            $image_width    = $image_info[0];
            $h_koef         = $sizeh / $image_height;
            $w_koef         = $sizew / $image_width;

            if ($h_koef > $w_koef)
            {
                $sizew_new = $image_width * $h_koef;
                $sizeh_new = $sizeh;
            }
            else
            {
                $sizeh_new = $image_height * $w_koef;
                $sizew_new = $sizew;
            }

            if ($image_info[2] == IMAGETYPE_JPEG)
            {
                $src = imagecreatefromjpeg($image_url);
            }
            elseif($image_info[2] == IMAGETYPE_GIF)
            {
                $src = imagecreatefromgif($image_url);
            }
            elseif($image_info[2] == IMAGETYPE_PNG)
            {
                $src = imagecreatefrompng($image_url);
            }

            $im         = imagecreatetruecolor($sizew, $sizeh);
            $back       = imagecolorallocate($im, 255, 255, 255);
            imagefill($im, 0, 0, $back);
            $file_name  = $authorization_user_id . '.png';
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/img/user/90/';
            $file_url   = $upload_dir . $file_name;
            $offset_x   = ($sizew_new - $sizew) / $h_koef / 2;

            if(0 > $offset_x)
            {
                $offset_x = -$offset_x;
            }

            $offset_y = ($sizeh_new - $sizeh) / $w_koef / 2;

            if(0 > $offset_y)
            {
                $offset_y = -$offset_y;
            }

            imagecopyresampled($im, $src, 0, 0, $offset_x, $offset_y, $sizew_new, $sizeh_new, imagesx($src), imagesy($src));
            imagejpeg($im, $file_url);
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

$user_array = $user_sql->fetch_all(1);

$social_array = f_igosja_social_array($user_array);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_id`!='0'
        ORDER BY `country_id` ASC";
$country_sql = $mysqli->query($sql);

$country_array = $country_sql->fetch_all(1);

$sql = "SELECT `gender_id`,
               `gender_name`
        FROM `gender`
        ORDER BY `gender_id` ASC";
$gender_sql = $mysqli->query($sql);

$gender_array = $gender_sql->fetch_all(1);

$header_title       = $authorization_login;
$seo_title          = $header_title . '. Анкета менеджера. ' . $seo_title;
$seo_description    = $header_title . '. Анкета менеджера. ' . $seo_description;
$seo_keywords       = $header_title . ', анкета менеджера, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');