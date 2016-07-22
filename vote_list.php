<?php

include (__DIR__ . '/include/include.php');

$sql = "UPDATE `vote`
        SET `vote_ready`='1'
        WHERE `vote_ready`='0'
        AND `vote_date`<UNIX_TIMESTAMP()-'7'*'24'*'60'*'60'";
$mysqli->query($sql);

$sql = "SELECT `vote_id`,
               `vote_question`,
               `vote_ready`,
               `voteanswer_answer`,
               `voteanswer_value`
        FROM `vote`
        LEFT JOIN `voteanswer`
        ON `vote_id`=`voteanswer_vote_id`
        WHERE `vote_view`='1'
        ORDER BY `vote_id` DESC, `voteanswer_value` DESC";
$vote_sql = $mysqli->query($sql);

$count_vote = $vote_sql->num_rows;
$vote_array = $vote_sql->fetch_all(1);

if (isset($authorization_user_id))
{
    $sql = "SELECT `vote_id`
            FROM `vote`
            WHERE `vote_view`='1'
            AND `vote_ready`='0'
            ORDER BY `vote_id` DESC
            LIMIT 1";
    $check_vote_sql = $mysqli->query($sql);

    $count_check_vote = $check_vote_sql->num_rows;

    if (0 != $count_check_vote)
    {
        $check_vote_array = $check_vote_sql->fetch_all(1);

        $vote_id = $check_vote_array[0]['vote_id'];

        $sql = "SELECT `voteuser_vote_id`
                FROM `voteuser`
                WHERE `voteuser_user_id`='$authorization_user_id'
                ORDER BY `voteuser_vote_id` DESC 
                LIMIT 1";
        $voteuser_sql = $mysqli->query($sql);

        $count_voteuser = $voteuser_sql->num_rows;

        if (0 == $count_voteuser)
        {
            redirect('vote.php?num=' . $vote_id);
        }

        $voteuser_array = $voteuser_sql->fetch_all(1);

        $voteuser_vote_id = $voteuser_array[0]['voteuser_vote_id'];

        if ($vote_id > $voteuser_vote_id)
        {
            redirect('vote.php?num=' . $vote_id);
        }
    }
}

$header_title       = 'Опросы';
$seo_title          = $header_title . '. ' . $seo_title;
$seo_description    = $header_title . '. ' . $seo_description;
$seo_keywords       = $header_title . ', ' . $seo_keywords;

include (__DIR__ . '/view/main.php');