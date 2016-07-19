<?php

include (__DIR__ . '/../include/include.php');

$sql = "SELECT `user_login`,
               `user_id`,
               `vote_date`,
               `vote_id`,
               `vote_question`,
               `vote_view`
        FROM `vote`
        LEFT JOIN `user`
        ON `user_id`=`vote_user_id`
        ORDER BY `vote_id` DESC";
$vote_sql = $mysqli->query($sql);

$vote_array = $vote_sql->fetch_all(1);

include (__DIR__ . '/../view/admin_main.php');