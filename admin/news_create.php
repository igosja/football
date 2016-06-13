<?php

include (__DIR__ . '/../include/include.php');

unset ($continent_array);

if (isset($_POST['news_text']))
{
    $news_text  = $_POST['news_text'];
    $news_title = $_POST['news_title'];

    $sql = "INSERT INTO `news`
            SET `news_text`=?,
                `news_title`=?,
                `news_date`=UNIX_TIMESTAMP()";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $news_text, $news_title);
    $prepare->execute();
    $prepare->close();

    redirect('news_list.php');
}

include (__DIR__ . '/../view/admin_main.php');