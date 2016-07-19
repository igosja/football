<?php

include (__DIR__ . '/include/include.php');

if (!isset($authorization_user_id))
{
    include (__DIR__ . '/view/only_logged.php');
    exit;
}

if (isset($_POST['data']))
{
    $post_data  = $_POST['data'];
    $question   = $post_data['question'];
    $answer     = $post_data['answer'];
    $answer     = array_filter($answer);

    if (!empty($question) && count($answer))
    {
        $sql = "INSERT INTO `vote`
                SET `vote_question`=?,
                    `vote_date`=UNIX_TIMESTAMP(),
                    `vote_user_id`='$authorization_user_id'";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $question);
        $prepare->execute();
        $question_id = $mysqli->insert_id;
        $prepare->close();

        foreach ($answer as $item) {
            $sql = "INSERT INTO `voteanswer`
                    SET `voteanswer_vote_id`='$question_id',
                        `voteanswer_answer`=?";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $item);
            $prepare->execute();
            $prepare->close();
        }

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Опрос успешно сохранен. Он будет опубликован после проверки администратором.';

        redirect('vote_list.php');
    }
    else
    {
        $_SESSION['message_class']  = 'error';
        $_SESSION['message_text']   = 'Опрос создать не удалось. Попробуйте еще раз.';

        redirect('vote_add.php');
    }
}

$header_title       = 'Создание опроса';
$seo_title          = $header_title . '. ' . $seo_title;
$seo_description    = $header_title . '. ' . $seo_description;
$seo_keywords       = $header_title . ', ' . $seo_keywords;

include (__DIR__ . '/view/main.php');