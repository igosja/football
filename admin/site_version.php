<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/include/include.php');

if (isset($_GET['version']))
{
    $get_num = (int) $_GET['version'];

    if (1 == $get_num)
    {
        $sql = "UPDATE `site`
                SET `site_version_1`=`site_version_1`+'1',
                    `site_version_2`='0',
                    `site_version_3`='0',
                    `site_version_4`='0',
                    `site_version_date`=UNIX_TIMESTAMP()
                WHERE `site_id`='1'
                LIMIT 1";
    }
    elseif (2 == $get_num)
    {
        $sql = "UPDATE `site`
                SET `site_version_2`=`site_version_2`+'1',
                    `site_version_3`='0',
                    `site_version_4`='0',
                    `site_version_date`=UNIX_TIMESTAMP()
                WHERE `site_id`='1'
                LIMIT 1";
    }
    elseif (3 == $get_num)
    {
        $sql = "UPDATE `site`
                SET `site_version_3`=`site_version_3`+'1',
                    `site_version_4`='0',
                    `site_version_date`=UNIX_TIMESTAMP()
                WHERE `site_id`='1'
                LIMIT 1";
    }
    elseif (4 == $get_num)
    {
        $sql = "UPDATE `site`
                SET `site_version_4`=`site_version_4`+'1',
                    `site_version_date`=UNIX_TIMESTAMP()
                WHERE `site_id`='1'
                LIMIT 1";
    }

    $mysqli->query($sql);

    redirect('site_version.php');
}

include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin_main.php');