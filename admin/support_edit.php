<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['num']))
{
    $get_num = (int) $_GET['num'];
}
else
{
    $get_num = 1;
}

$sql = "SELECT `inbox_sender_id`,
               `inbox_title`,
               `inbox_text`
        FROM `inbox`
        WHERE `inbox_id`='$get_num'
        LIMIT 1";
$inbox_sql = $mysqli->query($sql);

$count_inbox = $inbox_sql->num_rows;

if (0 == $count_inbox)
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

if (isset($_POST['inbox_text']))
{
    $inbox_text = trim($_POST['inbox_text']);
    $user_id    = (int) $_POST['user_id'];

    if (!empty($inbox_text))
    {
        $sql = "INSERT INTO `inbox`
            SET `inbox_text`=?,
                `inbox_title`='Ответ на обращение',
                `inbox_date`=SYSDATE(),
                `inbox_sender_id`='-1',
                `inbox_inboxtheme_id`='" . INBOXTHEME_PERSONAL . "',
                `inbox_user_id`='$user_id'";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $inbox_text);
        $prepare->execute();
        $prepare->close();
    }

    $sql = "UPDATE `inbox`
            SET `inbox_read`='1'
            WHERE `inbox_id`='$get_num'
            LIMIT 1";
    $mysqli->query($sql);

    redirect('support_list.php');
    exit;
}

$inbox_array = $inbox_sql->fetch_all(MYSQLI_ASSOC);

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');