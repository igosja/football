<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['group']))
{
    $get_group = (int) $_GET['group'];

    if (isset($_POST['text']))
    {
        $name = $_POST['name'];

        if (empty($name))
        {
            $name = 'Без названия';
        }

        $text = strip_tags($_POST['text']);

        $sql = "INSERT INTO `forumtheme`
                SET `forumtheme_forumthemegroup_id`='$get_group',
                    `forumtheme_name`=?,
                    `forumtheme_text`=?,
                    `forumtheme_user_id`='$authorization_id',
                    `forumtheme_date`=UNIX_TIMESTAMP(),
                    `forumtheme_edit`=UNIX_TIMESTAMP()";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('ss', $name, $text);
        $prepare->execute();
        $prepare->close();

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Сообщение успешно добавлено.';

        redirect('forum_group.php?num=' . $get_group);
    }

    $sql = "SELECT `forumthemegroup_name`
            FROM `forumthemegroup`
            WHERE `forumthemegroup_id`='$get_group'
            LIMIT 1";
    $forum_sql = $mysqli->query($sql);

    $forum_array = $forum_sql->fetch_all(1);
}
else
{
    if (isset($_GET['theme']))
    {
        $get_theme = (int) $_GET['theme'];
    }
    else
    {
        $get_theme = 1;
    }

    if (isset($_POST['text']))
    {
        $name = $_POST['name'];

        if (empty($name))
        {
            $name = 'Без названия';
        }

        $text = strip_tags($_POST['text']);

        $sql = "INSERT INTO `forumpost`
                SET `forumpost_forumtheme_id`='$get_theme',
                    `forumpost_name`=?,
                    `forumpost_text`=?,
                    `forumpost_user_id`='$authorization_id',
                    `forumpost_date`=UNIX_TIMESTAMP()";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('ss', $name, $text);
        $prepare->execute();
        $prepare->close();

        $sql = "UPDATE `forumtheme`
                SET `forumtheme_edit`=UNIX_TIMESTAMP()
                WHERE `forumtheme_id`='$get_theme'
                LIMIT 1";
        $mysqli->query($sql);

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Сообщение успешно добавлено.';

        redirect('forum_theme.php?num=' . $get_theme);
    }

    $sql = "SELECT `forumtheme_name`
            FROM `forumtheme`
            WHERE `forumtheme_id`='$get_theme'";
    $forum_sql = $mysqli->query($sql);

    $forum_array = $forum_sql->fetch_all(1);

    if (isset($_GET['answer']))
    {
        $answer = (int) $_GET['answer'];

        $sql = "SELECT `forumpost_text`
                FROM `forumpost`
                WHERE `forumpost_id`='$answer'
                LIMIT 1";
        $answer_sql = $mysqli->query($sql);

        $answer_array = $answer_sql->fetch_all(1);
    }
}

$header_title       = 'Форум';
$seo_title          = 'Форум. ' . $seo_title;
$seo_description    = 'Форум. ' . $seo_description;
$seo_keywords       = 'Форум, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');