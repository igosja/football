<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "SELECT COUNT(`team_id`) AS `count`
        FROM `team`
        WHERE `team_id`!='0'
        AND `team_user_id`='0'";
$freeteam_sql = $mysqli->query($sql);

$freeteam_array = $freeteam_sql->fetch_all(MYSQLI_ASSOC);
$count_freeteam = $freeteam_array[0]['count'];

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');