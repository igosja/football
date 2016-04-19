<!DOCTYPE html>
<html>

<head>
    <title>Виртуальная футбольная лига</title>
    <meta name="description" content="Футбольный онлайн менеджер" />
    <meta name="keywords" content="футбол, игра, менеджер, онлайн" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <noscript>
        <p class="center warning">
            В вашем браузере отключен javasript. Для корректной работы сайт рекомендуем включить javasript.
        </p>
    </noscript>
    <!--LiveInternet counter-->
    <script type="text/javascript">
        new Image().src = "//counter.yadro.ru/hit?r"
                        + escape(document.referrer)
                        + ((typeof(screen)=="undefined")?"" : ";s"
                        + screen.width
                        + "*"
                        + screen.height
                        + "*"
                        + (screen.colorDepth?screen.colorDepth:screen.pixelDepth))
                        + ";u"+escape(document.URL)
                        +  ";" +Math.random();
    </script>
    <!--/LiveInternet-->
    <!--GoogleAnalytics-->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-61508685-1', 'auto');
        ga('send', 'pageview');
    </script>
    <!--/GoogleAnalytics-->
    <div class="page-header">
        <table class="header-inner">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                <ul class="main-menu">
                                    <li><a href="javascript:;" class="main-menu-link">Меню</a>
                                        <ul>
                                            <li><a href="continent_review_profile.php?num=1">Лига</a></li>
                                            <li><a href="worldcup_review_profile.php?num=<?= TOURNAMENT_WORLD_CUP; ?>">Чемпионат мира</a></li>
                                            <li><a href="league_review_profile.php?num=<?= TOURNAMENT_CHAMPIONS_LEAGUE; ?>">Лига чемпионов</a></li>
                                        </ul>
                                    </li>
                                    <?php if (!isset($authorization_id)) { ?>
                                        <li><a href="login.php" class="main-menu-link">Войти</a></li>
                                    <?php } else { ?>
                                        <li><a href="profile_home_home.php" class="main-menu-link"><?= $authorization_login; ?></a>
                                            <ul>
                                                <li><a href="questionary.php">Личные данные</a></li>
                                                <li><a href="logout.php">Выйти</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="profile_news_inbox.php" class="main-menu-link">
                                                <img
                                                    alt="Сообщения"
                                                    class="img-12"
                                                    src="img/envelope.png"
                                                />
                                                <?php if (isset($count_message) && 0 < $count_message) { ?>
                                                    <sup class="inbox-sup"><?= $count_message; ?></sup>
                                                <?php } ?>
                                            </a>
                                        </li>
                                        <?php if (isset($authorization_team_id)) { ?>
                                            <li>
                                                <a href="team_lineup_team_player.php?num=<?= $authorization_team_id ?>" class="main-menu-link">
                                                    <?= $authorization_team_name; ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (isset($authorization_country_id)) { ?>
                                            <li>
                                                <a href="national_lineup_team_player.php?num=<?= $authorization_country_id ?>" class="main-menu-link">
                                                    <?= $authorization_country_name; ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if (!empty($coach_link)) { ?>
                                            <li>
                                                <a href="<?=$coach_link?>" class="main-menu-link main-menu-link-red">
                                                    Выборы
                                                </a>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <li><a href="forum.php" class="main-menu-link">Форум</a></li>
                                    <?php if (isset($authorization_id)) { ?>
                                        <li><a href="shop.php" class="main-menu-link">Магазин</a></li>
                                    <?php } ?>
                                    <li><a href="rule.php" class="main-menu-last">Правила</a></li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="center" rowspan="2">
                    <a href="/">
                        <img
                            alt="Футбольная Лига"
                            src="/img/logo.png"
                        />
                    </a>
                </td>
            </tr>
            <tr>
                <td class="right">
                    <span class="logo-text"><?= SPACE; ?></span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="w100">
                        <tr>
                            <td><span class="header-text"><?= $header_title; ?></span></td>
                            <td class="right fright">
                                <table class="horizontal-menu-table">
                                    <tr class="horizontal-menu" id="horizontal-menu-tr">
                                        <td class="right">
                                            <table>
                                                <tr>
                                                    <?php for ($i=0, $count_menu=count($horizontalmenu_array); $i<$count_menu; $i++) { ?>
                                                        <?php

                                                        if (((!isset($horizontalmenu_array[$i-1]['horizontalmenu_name']) ||
                                                            $horizontalmenu_array[$i-1]['horizontalmenu_name'] != $horizontalmenu_array[$i]['horizontalmenu_name']) &&
                                                            ((1 == $horizontalmenu_array[$i]['horizontalmenu_authorization'] &&
                                                            isset($authorization_id)) ||
                                                            0 == $horizontalmenu_array[$i]['horizontalmenu_authorization'])) &&
                                                            ((1 == $horizontalmenu_array[$i]['horizontalmenu_myteam'] &&
                                                            isset($_GET['num']) &&
                                                            isset($authorization_team_id) &&
                                                            $_GET['num'] == $authorization_team_id) ||
                                                            0 == $horizontalmenu_array[$i]['horizontalmenu_myteam'] ||
                                                            (1 == $horizontalmenu_array[$i]['horizontalmenu_myteam'] &&
                                                            !isset($_GET['num']))))
                                                        {
                                                            $css_class = '';

                                                        ?>
                                                            <td class="horizontal-menu-td">
                                                                <a href="javascript:;" id="horizontal-menu-<?= $i + 1; ?>"
                                                                    <?php foreach ($horizontalmenu_array as $item) { ?>
                                                                        <?php

                                                                        if ($horizontalmenu_array[$i]['horizontalmenu_name'] == $item['horizontalmenu_name'] &&
                                                                            $item['horizontalsubmenu_href'] == $chapter)
                                                                        {
                                                                            $css_class = 'active';
                                                                        }

                                                                        ?>
                                                                    <?php } ?>
                                                                    class="<?= $css_class; ?>"
                                                                >
                                                                    <?= $horizontalmenu_array[$i]['horizontalmenu_name']; ?>
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php for ($i=0, $count_menu=count($horizontalmenu_array); $i<$count_menu; $i++) { ?>
                                        <?php

                                        if (!isset ($horizontalmenu_array[$i-1]['horizontalmenu_name']) ||
                                            $horizontalmenu_array[$i-1]['horizontalmenu_name'] != $horizontalmenu_array[$i]['horizontalmenu_name'])
                                        {
                                            $css_class = 'none';

                                        ?>
                                            <tr
                                                <?php foreach ($horizontalmenu_array as $item) { ?>
                                                    <?php

                                                    if ($horizontalmenu_array[$i]['horizontalmenu_name'] == $item['horizontalmenu_name'] &&
                                                        $item['horizontalsubmenu_href'] == $chapter)
                                                    {
                                                        $css_class = 'horizontal-menu-second';
                                                    }

                                                    ?>
                                                <?php } ?>
                                                class="<?= $css_class; ?>"
                                                id="horizontal-menu-<?= $i + 1; ?>-tr"
                                            >
                                                <td class="horizontal-menu-td">
                                                    <table>
                                                        <tr>
                                        <?php } ?>
                                        <?php

                                        if (($horizontalmenu_array[$i]['horizontalsubmenu_name'] &&
                                            (0 == $horizontalmenu_array[$i]['horizontalsubmenu_authorization'] ||
                                            (1 == $horizontalmenu_array[$i]['horizontalsubmenu_authorization'] &&
                                            isset($authorization_id)))) &&
                                            ((1 == $horizontalmenu_array[$i]['horizontalmenu_myteam'] &&
                                            isset($_GET['num']) &&
                                            isset($authorization_team_id) &&
                                            $_GET['num'] == $authorization_team_id) ||
                                            0 == $horizontalmenu_array[$i]['horizontalmenu_myteam'] ||
                                            (1 == $horizontalmenu_array[$i]['horizontalmenu_myteam'] &&
                                            !isset($_GET['num']))))
                                        {

                                        ?>
                                            <td>
                                                <a href="<?= $horizontalmenu_array[$i]['horizontalsubmenu_href']; ?><?php if (isset($_GET['num'])) { ?>?num=<?= (int) $_GET['num']; ?><?php } ?>"
                                                    <?php if ($horizontalmenu_array[$i]['horizontalsubmenu_href'] == $chapter) { ?>
                                                        class="active"
                                                    <?php } ?>
                                                >
                                                    <?= $horizontalmenu_array[$i]['horizontalsubmenu_name']; ?>
                                                </a>
                                            </td>
                                        <?php } ?>
                                        <?php

                                        if (!isset($horizontalmenu_array[$i+1]['horizontalmenu_name']) ||
                                            $horizontalmenu_array[$i+1]['horizontalmenu_name'] != $horizontalmenu_array[$i]['horizontalmenu_name'])
                                        {

                                        ?>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="header-button">
        <?php if (isset($button_array)) { ?>
            <?php foreach ($button_array as $item) { ?>
                <a href="<?= $item['href']; ?>" class="<?= $item['class']; ?>"><?= $item['text']; ?></a>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="page-content">
        <?php if (isset($alert_message)) { ?>
            <p class="alert center <?= $alert_message['class']; ?>"><?= $alert_message['text']; ?></p>
        <?php } ?>