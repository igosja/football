<?php

include (__DIR__ . '/include/include.php');

if (!isset($authorization_user_id))
{
    include (__DIR__ . '/view/only_logged.php');
    exit;
}

if (isset($_POST['data']))
{
    $post_data  = $_POST['data'];
    $name       = $post_data['name'];
    $text       = $post_data['text'];

    if (!empty($name) && !empty($text))
    {
        $sql = "INSERT INTO `press`
                SET `press_name`=?,
                    `press_text`=?,
                    `press_date`=UNIX_TIMESTAMP(),
                    `press_user_id`='$authorization_user_id'";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('ss', $name, $text);
        $prepare->execute();
        $prepare->close();


        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Ваша статья успешно сохранена.';

        redirect('press_list.php');
    }
    else
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Статью создать не удалось. Попробуйте еще раз.';

        redirect('press_add.php');
    }
}

$header_title       = 'Создание статьи';
$seo_title          = $header_title . '. ' . $seo_title;
$seo_description    = $header_title . '. ' . $seo_description;
$seo_keywords       = $header_title . ', ' . $seo_keywords;

include (__DIR__ . '/view/main.php');