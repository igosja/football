<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `news_date`,
               `news_text`,
               `news_title`
        FROM `news`
        WHERE `news_id`='$num_get'";
$news_sql = $mysqli->query($sql);

$count_check = $news_sql->num_rows;

if (0 == $count_check)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

if (isset($_POST['newscomment_text']) && isset($authorization_user_id))
{
    $newscomment_text = strip_tags($_POST['newscomment_text']);

    if (!empty($newscomment_text))
    {
        $sql = "INSERT INTO `newscomment`
                SET `newscomment_date`=UNIX_TIMESTAMP(),
                    `newscomment_news_id`='$num_get',
                    `newscomment_user_id`='$authorization_user_id',
                    `newscomment_text`=?";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $newscomment_text);
        $prepare->execute();
        $prepare->close();

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Комментарий успешно сохранен.';
    }

    redirect('newscomment.php?num=' . $num_get);
}

$news_array = $news_sql->fetch_all(1);

$sql = "SELECT `newscomment_date`,
               `newscomment_text`,
               `user_id`,
               `user_login`
        FROM `newscomment`
        LEFT JOIN `user`
        ON `newscomment_user_id`=`user_id`
        WHERE `newscomment_news_id`='$num_get'
        ORDER BY `newscomment_id` ASC";
$newscomment_sql = $mysqli->query($sql);

$newscomment_array = $newscomment_sql->fetch_all(1);

$header_title       = 'Новости';
$seo_title          = $header_title . '. Комментарии. ' . $seo_title;
$seo_description    = $header_title . '. Комментарии. ' . $seo_description;
$seo_keywords       = $header_title . ', комментарии, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');