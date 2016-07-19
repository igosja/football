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

$sql = "SELECT `vote_date`,
               `vote_question`,
               `vote_user_id`,
               `vote_view`,
               `voteanswer_answer`,
               `user_login`,
               `user_id`
        FROM `vote`
        LEFT JOIN `user`
        ON `user_id`=`vote_user_id`
        LEFT JOIN `voteanswer`
        ON `vote_id`=`voteanswer_vote_id`
        WHERE `vote_id`='$num_get'";
$vote_sql = $mysqli->query($sql);

$count_vote = $vote_sql->num_rows;

if (0 == $count_vote)
{
    include (__DIR__ . '/../view/wrong_page.php');
    exit;
}

if (isset($_GET['ok']))
{
    $sql = "UPDATE `vote`
            SET `vote_view`='1',
                `vote_date`=UNIX_TIMESTAMP()
          WHERE `vote_id`='$num_get'";
    $mysqli->query($sql);

    redirect('vote_list.php');
}
elseif (isset($_GET['del']))
{
    $sql = "DELETE FROM `vote`
            WHERE `vote_id`='$num_get'";
    $mysqli->query($sql);

    $sql = "DELETE FROM `voteanswer`
            WHERE `voteanswer_vote_id`='$num_get'";
    $mysqli->query($sql);

    redirect('vote_list.php');
}

$vote_array = $vote_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');