<?php

include ('include/include.php');

if (isset($_GET['group']))
{
    $get_group = (int) $_GET['group'];

    if (isset($_POST['text']))
    {
        $name = $_POST['name'];
        $text = strip_tags($_POST['text']);

        $sql = "INSERT INTO `forumtheme`
                SET `forumtheme_forumthemegroup_id`='$get_group',
                    `forumtheme_name`=?,
                    `forumtheme_text`=?,
                    `forumtheme_user_id`='$authorization_id',
                    `forumtheme_date`=SYSDATE()";
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

    $forum_array = $forum_sql->fetch_all(MYSQLI_ASSOC);
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
        $text = strip_tags($_POST['text']);

        $sql = "INSERT INTO `forumpost`
                SET `forumpost_forumtheme_id`='$get_theme',
                    `forumpost_name`=?,
                    `forumpost_text`=?,
                    `forumpost_user_id`='$authorization_id',
                    `forumpost_date`=SYSDATE()";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('ss', $name, $text);
        $prepare->execute();
        $prepare->close();

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Сообщение успешно добавлено.';

        redirect('forum_theme.php?num=' . $get_theme);
    }

    $sql = "SELECT `forumtheme_name`
            FROM `forumtheme`
            WHERE `forumtheme_id`='$get_theme'";
    $forum_sql = $mysqli->query($sql);

    $forum_array = $forum_sql->fetch_all(MYSQLI_ASSOC);
}

$header_title = 'Форум';

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');