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
                    `forumtheme_user_id`='$authorization_user_id',
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

        if (!isset($_GET['edit']))
        {
            $sql = "INSERT INTO `forumpost`
                    SET `forumpost_forumtheme_id`='$get_theme',
                        `forumpost_name`=?,
                        `forumpost_text`=?,
                        `forumpost_user_id`='$authorization_user_id',
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
        }
        else
        {
            $edit = (int) $_GET['edit'];

            $sql = "SELECT `forumpost_forumtheme_id`
                    FROM `forumpost`
                    WHERE `forumpost_id`='$edit'
                    LIMIT 1";
            $forumtheme_sql = $mysqli->query($sql);

            $forumtheme_array = $forumtheme_sql->fetch_all(1);

            $get_theme = $forumtheme_array[0]['forumpost_forumtheme_id'];

            $sql = "UPDATE `forumpost`
                    SET `forumpost_name`=?,
                        `forumpost_text`=?
                    WHERE `forumpost_id`='$edit'
                    AND `forumpost_user_id`='$authorization_user_id'
                    LIMIT 1";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('ss', $name, $text);
            $prepare->execute();
            $prepare->close();

            $_SESSION['message_class']  = 'success';
            $_SESSION['message_text']   = 'Сообщение успешно отредактировано.';
        }

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

        $count_answer = $answer_sql->num_rows;

        if (0 == $count_answer)
        {
            $_SESSION['message_class']  = 'success';
            $_SESSION['message_text']   = 'Сообщение выбрано неправильно.';

            redirect('forum_theme.php?num=' . $get_theme);
        }

        $answer_array = $answer_sql->fetch_all(1);
    }

    if (isset($_GET['edit']))
    {
        $edit = (int) $_GET['edit'];

        $sql = "SELECT `forumpost_name`,
                       `forumpost_text`
                FROM `forumpost`
                WHERE `forumpost_id`='$edit'
                AND `forumpost_user_id`='$authorization_user_id'
                LIMIT 1";
        $edit_sql = $mysqli->query($sql);

        $count_edit = $edit_sql->num_rows;

        if (0 == $count_edit)
        {
            $_SESSION['message_class']  = 'success';
            $_SESSION['message_text']   = 'Сообщение выбрано неправильно.';

            redirect('forum_theme.php?num=' . $get_theme);
        }

        $edit_array = $edit_sql->fetch_all(1);
    }
}

$header_title       = 'Форум';
$seo_title          = 'Форум. ' . $seo_title;
$seo_description    = 'Форум. ' . $seo_description;
$seo_keywords       = 'Форум, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');