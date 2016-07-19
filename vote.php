<?php

include (__DIR__ . '/include/include.php');

if (!isset($_GET['num']))
{
    redirect('vote_list.php');
}

$num_get = (int) $_GET['num'];

$sql = "SELECT `vote_question`,
               `vote_ready`,
               `voteanswer_answer`,
               `voteanswer_id`,
               `voteanswer_value`
        FROM `vote`
        LEFT JOIN `voteanswer`
        ON `vote_id`=`voteanswer_vote_id`
        WHERE `vote_id`='$num_get'
        ORDER BY `voteanswer_value` DESC";
$vote_sql = $mysqli->query($sql);

$count_vote = $vote_sql->num_rows;

if (0 == $count_vote)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$vote_array = $vote_sql->fetch_all(1);

if (isset($authorization_user_id))
{
    $sql = "SELECT COUNT(`voteuser_id`) AS `count`
            FROM `voteuser`
            WHERE `voteuser_user_id`='$authorization_user_id'
            AND `voteuser_vote_id`='$num_get'";
    $voteuser_sql = $mysqli->query($sql);

    $voteuser_array = $voteuser_sql->fetch_all(1);
    $count_voteuser = $voteuser_array[0]['count'];

    if (isset($_POST['data']))
    {
        $answer_id = (int) $_POST['data'];

        if (0 == $count_voteuser)
        {
            $sql = "UPDATE `voteanswer`
                    SET `voteanswer_value`=`voteanswer_value`+'1'
                    WHERE `voteanswer_id`='$answer_id'
                    LIMIT 1";
            $mysqli->query($sql);

            $sql = "INSERT INTO `voteuser`
                    SET `voteuser_user_id`='$authorization_user_id',
                        `voteuser_vote_id`='$num_get'";
            $mysqli->query($sql);

            $_SESSION['message_class']  = 'success';
            $_SESSION['message_text']   = 'Ваш голос успешно сохранен.';
        }
        else
        {
            $_SESSION['message_class']  = 'error';
            $_SESSION['message_text']   = 'Вы уже проголосовали в этом опросе.';
        }

        redirect('vote.php?num=' . $num_get);
    }
}

$header_title       = 'Опрос';
$seo_title          = $header_title . '. ' . $seo_title;
$seo_description    = $header_title . '. ' . $seo_description;
$seo_keywords       = $header_title . ', ' . $seo_keywords;

include (__DIR__ . '/view/main.php');