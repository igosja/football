<?php

include (__DIR__ . '/../include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `news_title`,
               `news_text`
        FROM `news`
        WHERE `news_id`='$num_get'
        LIMIT 1";
$news_sql = $mysqli->query($sql);

$count_news = $news_sql->num_rows;

if (0 == $count_news)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_POST['news_title']))
{
    $news_title = $_POST['news_title'];
    $news_text  = $_POST['news_text'];

    $sql = "UPDATE `news`
            SET `news_title`=?,
                `news_text`=?
            WHERE `news_id`='$num_get'
            LIMIT 1";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $news_title, $news_text);
    $prepare->execute();
    $prepare->close();

    redirect('news_list.php');
}

$news_array = $news_sql->fetch_all(1);

$tpl = 'news_create';

include (__DIR__ . '/../view/admin_main.php');