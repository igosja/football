<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($authorization_id))
{
    $get_num = $authorization_id;
}
else
{
    include ($_SERVER['DOCUMENT_ROOT'] . '/view/wrong_page.html');
    exit;
}

if (isset($_GET['answer']))
{
    $answer = (int) $_GET['answer'];
}
else
{
    $answer = 0;
}

if (isset($_POST['data']))
{
    $inbox_user  = $_POST['data']['inbox_user_id'];
    $inbox_title = $_POST['data']['inbox_title'];
    $inbox_text  = $_POST['data']['inbox_text'];

    if (!empty($inbox_title) &&
        !empty($inbox_text) &&
        !empty($inbox_user))
    {
        $sql = "SELECT `user_id`
                FROM `user`
                WHERE `user_login`=?
                LIMIT 1";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $inbox_user);
        $prepare->execute();

        $user_sql = $prepare->get_result();

        $prepare->close();

        $count_user = $user_sql->num_rows;

        if (0 == $count_user)
        {
            redirect('profile_news_outbox.php?num=' . $get_num);
            exit;
        }

        $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

        $inbox_user_id = $user_array[0]['user_id'];

        $sql = "INSERT INTO `inbox`
                SET `inbox_date`=SYSDATE(),
                    `inbox_inboxtheme_id`='" . INBOXTHEME_PERSONAL . "',
                    `inbox_title`='$inbox_title',
                    `inbox_text`='$inbox_text',
                    `inbox_user_id`='$inbox_user_id',
                    `inbox_sender_id`='$get_num'";

        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('ssii', $inbox_title, $inbox_text, $inbox_user_id, $get_num);
        $prepare->execute();
        $prepare->close();

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Сообщение успешно отправлено.';
    }

    redirect('profile_news_outbox.php?num=' . $get_num);
    exit;
}

$sql = "SELECT `inbox_id`,
               `inbox_date`,
               `inbox_read`,
               `inbox_title`,
               `inbox_user_id`,
               `user_login`
        FROM `inbox`
        LEFT JOIN `user`
        ON `user_id`=`inbox_user_id`
        WHERE `inbox_sender_id`='$get_num'
        ORDER BY `inbox_date` DESC";
$inbox_sql = $mysqli->query($sql);

$inbox_array = $inbox_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `user_id`,
               `user_login`
        FROM `user`
        WHERE `user_last_visit`>DATE_ADD(CURDATE(), INTERVAL -7 DAY)
        AND `user_id` NOT IN ('-1', '0', '$get_num')
        ORDER BY `user_login` ASC";
$user_sql = $mysqli->query($sql);

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$num            = $authorization_id;
$header_title   = $authorization_login;

include ($_SERVER['DOCUMENT_ROOT'] . '/view/main.php');