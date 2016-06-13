<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Административный раздел">
        <title>Административный раздел</title>
        <link href="/css/admin.css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/admin/">
                        ВФЛ (<?=$site_array[0]['site_version_1']?>.<?=$site_array[0]['site_version_2']?>.<?=$site_array[0]['site_version_3']?>.<?=$site_array[0]['site_version_4']?> <?=date('d.m.Y', $site_array[0]['site_version_date'])?>)
                    </a>
                </div>

                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a href="support_list.php">
                            <i class="fa fa-comment-o fa-fw"></i> <span class="badge" id="admin-support-badge"><?= $count_admin_support; ?></span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-gear fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="generator_debug.php"><i class="fa fa-bug fa-fw"></i> Дебагер запросов генератора</a></li>
                            <li class="divider"></li>
                            <li><a href="site_version.php"><i class="fa fa-level-up fa-fw"></i> Обновить версию сайта</a></li>
                            <li class="divider"></li>
                            <li>
                                <a href="site_status.php"><i class="fa fa-power-off fa-fw"></i>
                                    <?php if (SITE_CLOSED == $site_array[0]['site_status']) { ?>
                                        Открыть сайт
                                    <?php } else { ?>
                                        Закрыть сайт
                                    <?php } ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a href="#">Новости<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="news_list.php">Новости</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Горизонтальное меню<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="horizontalmenupage_list.php">Страницы</a>
                                    </li>
                                    <li>
                                        <a href="horizontalmenuchapter_list.php">Разделы</a>
                                    </li>
                                    <li>
                                        <a href="horizontalmenu_list.php">Первая строка меню</a>
                                    </li>
                                    <li>
                                        <a href="horizontalsubmenu_list.php">Вторая строка меню</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Игроки<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="name_list.php">Имена</a>
                                    </li>
                                    <li>
                                        <a href="surname_list.php">Фамилии</a>
                                    </li>
                                    <li>
                                        <a href="attributechapter_list.php">Группы характеристик</a>
                                    </li>
                                    <li>
                                        <a href="attribute_list.php">Характеристики</a>
                                    </li>
                                    <li>
                                        <a href="mood_list.php">Настроение</a>
                                    </li>
                                    <li>
                                        <a href="statusteam_list.php">Командный статус</a>
                                    </li>
                                    <li>
                                        <a href="statusrent_list.php">Арендный статус</a>
                                    </li>
                                    <li>
                                        <a href="statustransfer_list.php">Трансферный статус</a>
                                    </li>
                                    <li>
                                        <a href="statusnational_list.php">Доступность для сборной</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">История действий<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="historytext_list.php">Варианты действий</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Команды<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="continent_list.php">Континенты</a>
                                    </li>
                                    <li>
                                        <a href="country_list.php">Страны</a>
                                    </li>
                                    <li>
                                        <a href="city_list.php">Города</a>
                                    </li>
                                    <li>
                                        <a href="team_list.php">Команды</a>
                                    </li>
                                    <li>
                                        <a href="stadiumquality_list.php">Состояние газона</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Новости<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="inboxtheme_list.php">Темы новостных сообщений</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Персонал<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="post_list.php">Должности</a>
                                    </li>
                                    <li>
                                        <a href="attributechapter_staff_list.php">Группы характеристик</a>
                                    </li>
                                    <li>
                                        <a href="attribute_staff_list.php">Характеристики</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Пользователи<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="user_list.php">Список</a>
                                    </li>
                                    <li>
                                        <a href="gender_list.php">Пол</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Правила<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="rule_list.php">Правила</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Рекорды<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="seriestype_list.php">Серии матчей</a>
                                    </li>
                                    <li>
                                        <a href="recordtournamenttype_list.php">Турнирные рекорды</a>
                                    </li>
                                    <li>
                                        <a href="recordteamtype_list.php">Командные рекорды</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Сделки<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="offertype_list.php">Виды сделок</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">События матча<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="eventtype_list.php">Варианты событий</a>
                                    </li>
                                    <li>
                                        <a href="weather_list.php">Погода</a>
                                    </li>
                                    <li>
                                        <a href="injurytype_list.php">Травмы</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Тактика<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="gamestyle_list.php">Стиль игры</a>
                                    </li>
                                    <li>
                                        <a href="gamemood_list.php">Настрой на игру</a>
                                    </li>
                                    <li>
                                        <a href="instructionchapter_list.php">Группы инструкций</a>
                                    </li>
                                    <li>
                                        <a href="instruction_list.php">Инструкции команде</a>
                                    </li>
                                    <li>
                                        <a href="formation_list.php">Расстановки команд</a>
                                    </li>
                                    <li>
                                        <a href="position_list.php">Позиции на поле</a>
                                    </li>
                                    <li>
                                        <a href="positionmain_list.php">Главные позиции</a>
                                    </li>
                                    <li>
                                        <a href="positioncreate_list.php">Позиции при создании команды</a>
                                    </li>
                                    <li>
                                        <a href="role_list.php">Роли игроков</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Турниры<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="tournamenttype_list.php">Типы турниров</a>
                                    </li>
                                    <li>
                                        <a href="tournament_list.php">Турниры</a>
                                    </li>
                                    <li>
                                        <a href="stage_list.php">Стадии</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Форум<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="forumchapter_list.php">Разделы</a>
                                    </li>
                                    <li>
                                        <a href="forumthemegroup_list.php">Форумы</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="page-wrapper">

                <?php include ($_SERVER['DOCUMENT_ROOT'] . '/view/admin/' . $tpl . '.php'); ?>

            </div>
        </div>
        <script src="/js/jquery.js"></script>
        <script src="/js/admin.min.js"></script>
        <script src="/js/highcharts.js"></script>
        <script src="/js/admin.js"></script>
    </body>
</html>