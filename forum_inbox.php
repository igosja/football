<?php

include ('include/include.php');

$sql = "SELECT `forummessage_date`,
               `forummessage_name`,
               `forummessage_text`,
               `user_login`
        FROM `forummessage`
        LEFT JOIN `user`
        ON `forummessage_user_id_from`=`user_id`
        WHERE `forummessage_user_id_to`='$authorization_id'
        ORDER BY `forummessage_id` ASC";
$forum_sql = $mysqli->query($sql);

$forum_array = $forum_sql->fetch_all(MYSQLI_ASSOC);

$smarty->assign('forum_array', $forum_array);

$smarty->display('main.html');