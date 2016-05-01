<?php

include (__DIR__ . '/include/include.php');

if (!isset($authorization_id))
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

if (isset($_POST['note_id']))
{
    $note_id    = (int) $_POST['note_id'];
    $note_title = strip_tags($_POST['note_title']);
    $note_text  = strip_tags($_POST['note_text']);

    if (0 < $note_id)
    {
        $sql = "UPDATE `note`
                SET `note_title`=?,
                    `note_text`=?
                WHERE `note_id`='$note_id'
                AND `note_user_id`='$authorization_id'
                LIMIT 1";
    }
    else
    {
        $sql = "INSERT INTO `note`
                SET `note_title`=?,
                    `note_text`=?,
                    `note_user_id`='$authorization_id'";
    }

    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('ss', $note_title, $note_text);
    $prepare->execute();
    $prepare->close();

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Данные успешно сохранены';

    redirect('profile_history_note.php');
}
elseif (isset($_GET['note']))
{
    $note_id = (int) $_GET['note'];

    $sql = "DELETE FROM `note`
            WHERE `note_user_id`='$authorization_id'
            AND `note_id`='$note_id'";
    $mysqli->query($sql);

    $_SESSION['message_class']  = 'success';
    $_SESSION['message_text']   = 'Данные успешно удалены';

    redirect('profile_history_note.php');
}

$sql = "SELECT `note_id`,
               `note_title`
        FROM `note`
        WHERE `note_user_id`='$authorization_id'
        ORDER BY `note_id` DESC";
$note_sql = $mysqli->query($sql);

$note_array = $note_sql->fetch_all(MYSQLI_ASSOC);

$num                = $authorization_id;
$header_title       = $authorization_login;
$seo_title          = $header_title . '. Записная книжка. ' . $seo_title;
$seo_description    = $header_title . '. Записная книжка. ' . $seo_description;
$seo_keywords       = $header_title . ', записная книжка, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');