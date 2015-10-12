<?php

include ('include/include.php');

if (!isset($authorization_id))
{
    $smarty->display('wrong_page.html');

    exit;
}

if (isset($_POST['note_id']))
{
    $note_id    = (int) $_POST['note_id'];
    $note_title = $_POST['note_title'];
    $note_text  = $_POST['note_text'];

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

    redirect('profile_history_note.php');

    exit;
}
elseif (isset($_GET['note']))
{
    $note_id = (int) $_GET['note'];

    $sql = "DELETE FROM `note`
            WHERE `note_user_id`='$authorization_id'
            AND `note_id`='$note_id'";
    $mysqli->query($sql);

    redirect('profile_history_note.php');

    exit;
}

$sql = "SELECT `note_id`,
               `note_title`
        FROM `note`
        WHERE `note_user_id`='$authorization_id'
        ORDER BY `note_id` DESC";
$note_sql = $mysqli->query($sql);

$note_array = $note_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('num', $authorization_id);
$smarty->assign('header_2_title', $authorization_login);
$smarty->assign('note_array', $note_array);

$smarty->display('main.html');