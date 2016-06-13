<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['page']))
{
    $page = (int) $_GET['page'];
}
else
{
    $page = 1;
}

if (isset($authorization_user_id))
{
    $sql = "UPDATE `user`
            SET `user_news_id`=
            (
                SELECT MAX(`news_id`)
                FROM `news`
            )
            WHERE `user_id`='$authorization_user_id'
            LIMIT 1";
    $mysqli->query($sql);
}

$offset = ($page - 1) * 10;

$sql = "SELECT `newscomment_count`,
               `news_id`,
               `news_date`,
               `news_text`,
               `news_title`
        FROM `news`
        LEFT JOIN
        (
            SELECT COUNT(`newscomment_id`) AS `newscomment_count`,
                   `newscomment_news_id`
            FROM `newscomment`
            GROUP BY `newscomment_news_id`
        ) AS `t1`
        ON `newscomment_news_id`=`news_id`
        ORDER BY `news_id` DESC
        LIMIT $offset, 10";
$news_sql = $mysqli->query($sql);

$news_array = $news_sql->fetch_all(1);

$sql = "SELECT FOUND_ROWS() AS `count_page`";
$count_page = $mysqli->query($sql);
$count_page = $count_page->fetch_all(1);
$count_page = $count_page[0]['count_page'];
$count_page = ceil($count_page / 10);

if (20 < $count_page)
{
    $count_page = 20;
}

$header_title       = 'Новости';
$seo_title          = $header_title . '. ' . $seo_title;
$seo_description    = $header_title . '. ' . $seo_description;
$seo_keywords       = $header_title . ', ' . $seo_keywords;

include (__DIR__ . '/view/main.php');