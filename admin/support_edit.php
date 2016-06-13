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

$sql = "SELECT `inbox_date`,
               `inbox_sender_id`,
               `inbox_title`,
               `inbox_text`,
               `user_login`
        FROM `inbox`
        LEFT JOIN `user`
        ON `user_id`=`inbox_sender_id`
        WHERE `inbox_id`='$num_get'
        LIMIT 1";
$inbox_sql = $mysqli->query($sql);

$count_inbox = $inbox_sql->num_rows;

if (0 == $count_inbox)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

$sql = "UPDATE `inbox`
        SET `inbox_read`='1'
        WHERE `inbox_id`='$num_get'
        LIMIT 1";
$mysqli->query($sql);

if (isset($_POST['inbox_text']))
{
    $inbox_text = strip_tags($_POST['inbox_text']);
    $user_id    = (int) $_POST['user_id'];

    if (!empty($inbox_text))
    {
        $sql = "INSERT INTO `inbox`
                SET `inbox_text`=?,
                    `inbox_title`='Ответ на обращение',
                    `inbox_date`=UNIX_TIMESTAMP(),
                    `inbox_sender_id`='0',
                    `inbox_support`='1',
                    `inbox_inboxtheme_id`='" . INBOXTHEME_PERSONAL . "',
                    `inbox_user_id`='$user_id'";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $inbox_text);
        $prepare->execute();
        $prepare->close();
    }

    redirect('support_list.php');
}

$inbox_array = $inbox_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');