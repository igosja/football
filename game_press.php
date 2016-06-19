<?php

include (__DIR__ . '/include/include.php');

if (isset($_GET['num']))
{
    $num_get = (int) $_GET['num'];
}
else
{
    $num_get = 1;
}

$sql = "SELECT `game_home_team_id`,
               `game_tournament_id`,
               `game_shedule_id`,
               `tournament_tournamenttype_id`
        FROM `game`
        LEFT JOIN `tournament`
        ON `tournament_id`=`game_tournament_id`
        WHERE `game_id`='$num_get'
        LIMIT 1";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;

if (0 == $count_game)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$game_array = $game_sql->fetch_all(1);

$home_team_id       = $game_array[0]['game_home_team_id'];
$tournamenttype_id  = $game_array[0]['tournament_tournamenttype_id'];
$tournament_id      = $game_array[0]['game_tournament_id'];
$shedule_id         = $game_array[0]['game_shedule_id'];

if (0 != $home_team_id)
{
    $team_country = 'team';
}
else
{
    $team_country = 'country';
}

$sql = "SELECT `game_guest_" . $team_country . "_id`,
               `t2`.`" . $team_country . "_name` AS `game_guest_" . $team_country . "_name`,
               `game_guest_score`,
               `game_guest_shoot_out`,
               `game_home_" . $team_country . "_id`,
               `t1`.`" . $team_country . "_name` AS `game_home_" . $team_country . "_name`,
               `game_home_score`,
               `game_home_shoot_out`,
               `game_id`,
               `game_played`
        FROM `game`
        LEFT JOIN `" . $team_country . "` AS `t1`
        ON `game_home_" . $team_country . "_id`=`t1`.`" . $team_country . "_id`
        LEFT JOIN `" . $team_country . "` AS `t2`
        ON `game_guest_" . $team_country . "_id`=`t2`.`" . $team_country . "_id`
        LEFT JOIN `tournament`
        ON `game_tournament_id`=`tournament_id`
        LEFT JOIN `shedule`
        ON `shedule_id`=`game_shedule_id`
        LEFT JOIN `referee`
        ON `game_referee_id`=`referee_id`
        LEFT JOIN `name`
        ON `name_id`=`referee_name_id`
        LEFT JOIN `surname`
        ON `surname_id`=`referee_surname_id`
        LEFT JOIN `stadium`
        ON `game_stadium_id`=`stadium_id`
        LEFT JOIN `stadiumquality`
        ON `stadium_stadiumquality_id`=`stadiumquality_id`
        LEFT JOIN `team` AS `t3`
        ON `t3`.`team_id`=`stadium_team_id`
        LEFT JOIN `city`
        ON `city_id`=`t3`.`team_city_id`
        WHERE `game_id`='$num_get'
        LIMIT 1";
$game_sql = $mysqli->query($sql);

$count_game = $game_sql->num_rows;

if (0 == $count_game)
{
    include (__DIR__ . '/view/wrong_page.php');
    exit;
}

$game_array = $game_sql->fetch_all(1);

$game_played            = $game_array[0]['game_played'];
$header_2_home_id       = $game_array[0]['game_home_' . $team_country . '_id'];
$header_2_home_name     = $game_array[0]['game_home_' . $team_country . '_name'];
$header_2_guest_id      = $game_array[0]['game_guest_' . $team_country . '_id'];
$header_2_guest_name    = $game_array[0]['game_guest_' . $team_country . '_name'];

if (0 == $game_played)
{
    $header_2_score = '-';
}
else
{
    $home_score     = $game_array[0]['game_home_score'];
    $guest_score    = $game_array[0]['game_guest_score'];
    $header_2_score = $home_score . ':' . $guest_score;
    $home_shootout  = $game_array[0]['game_home_shoot_out'];
    $guest_shootout = $game_array[0]['game_guest_shoot_out'];

    if (0 != $home_shootout && 0 != $guest_shootout)
    {
        $header_2_shootout = '(пен. ' . $home_shootout . ':' . $guest_shootout . ')';
    }
    else
    {
        $header_2_shootout = '';
    }

    $header_2_score = $header_2_score . ' ' . $header_2_shootout;
}

if (isset($_POST['gamecomment_text']) && isset($authorization_user_id))
{
    $gamecomment_text = strip_tags($_POST['gamecomment_text']);

    if (!empty($gamecomment_text))
    {
        $sql = "INSERT INTO `gamecomment`
                SET `gamecomment_date`=UNIX_TIMESTAMP(),
                    `gamecomment_game_id`='$num_get',
                    `gamecomment_user_id`='$authorization_user_id',
                    `gamecomment_text`=?";
        $prepare = $mysqli->prepare($sql);
        $prepare->bind_param('s', $gamecomment_text);
        $prepare->execute();
        $prepare->close();

        $_SESSION['message_class']  = 'success';
        $_SESSION['message_text']   = 'Комментарий успешно сохранен.';
    }

    redirect('game_press.php?num=' . $num_get);
}

$news_array = $news_sql->fetch_all(1);

$sql = "SELECT `gamecomment_date`,
               `gamecomment_text`,
               `user_id`,
               `user_login`
        FROM `gamecomment`
        LEFT JOIN `user`
        ON `gamecomment_user_id`=`user_id`
        WHERE `gamecomment_game_id`='$num_get'
        ORDER BY `gamecomment_id` ASC";
$gamecomment_sql = $mysqli->query($sql);

$gamecomment_array = $gamecomment_sql->fetch_all(1);

$num                = $num_get;
$header_title       = $header_2_home_name . ' ' . $header_2_score . ' ' . $header_2_guest_name;
$seo_title          = $header_title . '. Комментарии к матчу. ' . $seo_title;
$seo_description    = $header_title . '. Комментарии к матчу. ' . $seo_description;
$seo_keywords       = $header_title . ', комментарии к матчу, ' . $seo_keywords;

include (__DIR__ . '/view/main.php');