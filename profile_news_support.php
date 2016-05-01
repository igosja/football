<?php

include (__DIR__ . '/include/include.php');

if (isset($authorization_id))
{
    $num_get = $authorization_id;
}
else
{
    include (__DIR__ . '/view/wrong_page.php');
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
    $inbox_text  = strip_tags($_POST['data']['inbox_text']);

    if (!empty($inbox_text))
    {
        $sql = "INSERT INTO `inbox`
                SET `inbox_date`=SYSDATE(),
                    `inbox_text`=?,
                    `inbox_support`='1',
                    `inbox_sender_id`='$num_get'";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $inbox_text);
        $prepare->execute();
        $prepare->close();

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Сообщение успешно отправлено.';
    }

    redirect('profile_news_support.php?num=' . $num_get);
}

$sql = "SELECT `inbox_id`,
               `inbox_date`,
               `inbox_read`,
               `inbox_text`,
               `inbox_user_id`,
               `user_login`
        FROM `inbox`
        LEFT JOIN `user`
        ON `user_id`=`inbox_user_id`
        WHERE (`inbox_sender_id`='$num_get'
        OR `inbox_user_id`='$num_get')
        AND `inbox_support`='1'
        ORDER BY `inbox_date` DESC, `inbox_id` DESC";
$inbox_sql = $mysqli->query($sql);

$inbox_array = $inbox_sql->fetch_all(MYSQLI_ASSOC);

$sql = "UPDATE `inbox`
        SET `inbox_read`='1'
        WHERE `inbox_read`='0'
        AND `inbox_user_id`='$num_get'";
$mysqli->query($sql);

$num                = $authorization_id;
$header_title       = $authorization_login;
$seo_title          = $header_title . '. Техподдержка. ' . $seo_title;
$seo_description    = $header_title . '. Техподдержка. ' . $seo_description;
$seo_keywords       = $header_title . ', техподдержка, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');