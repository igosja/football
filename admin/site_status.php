<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

$sql = "UPDATE `site`
        SET `site_status`='1'-`site_status`
        WHERE `site_id`='1'
        LIMIT 1";
$mysqli->query($sql);

redirect('index.php');