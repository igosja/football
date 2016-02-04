<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Административный раздел">
        <title>Административный раздел</title>
        <link href="/admin-css-js/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/admin-css-js/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="/admin-css-js/dist/css/timeline.css" rel="stylesheet">
        <link href="/admin-css-js/dist/css/sb-admin-2.css" rel="stylesheet">
        <link href="/admin-css-js/bower_components/morrisjs/morris.css" rel="stylesheet">
        <link href="/admin-css-js/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/admin-css-js/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                    <a class="navbar-brand" href="/admin/">Административный раздел</a>
                </div>

                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <a href="#">
                                    <div>
                                        <strong>John Smith</strong>
                                        <span class="pull-right text-muted">
                                            <em>Yesterday</em>
                                        </span>
                                    </div>
                                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <strong>John Smith</strong>
                                        <span class="pull-right text-muted">
                                            <em>Yesterday</em>
                                        </span>
                                    </div>
                                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <strong>John Smith</strong>
                                        <span class="pull-right text-muted">
                                            <em>Yesterday</em>
                                        </span>
                                    </div>
                                    <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>Read All Messages</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-tasks">
                            <li>
                                <a href="#">
                                    <div>
                                        <p>
                                            <strong>Task 1</strong>
                                            <span class="pull-right text-muted">40% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                <span class="sr-only">40% Complete (success)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p>
                                            <strong>Task 2</strong>
                                            <span class="pull-right text-muted">20% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p>
                                            <strong>Task 3</strong>
                                            <span class="pull-right text-muted">60% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                                <span class="sr-only">60% Complete (warning)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p>
                                            <strong>Task 4</strong>
                                            <span class="pull-right text-muted">80% Complete</span>
                                        </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                                <span class="sr-only">80% Complete (danger)</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Tasks</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> New Comment
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> Message Sent
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-tasks fa-fw"></i> New Task
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="/logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="sidebar-search">
                                <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" placeholder="Поиск...">
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                                </div>
                            </li>
                            <li>
                                <a href="index.php">Общая информация</a>
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
                                        <a href="gameready_list.php">Готовность к матчу</a>
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
        <script src="/admin-css-js/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="/admin-css-js/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/admin-css-js/bower_components/metisMenu/dist/metisMenu.min.js"></script>
        <script src="/admin-css-js/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="/admin-css-js/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
<!--        <script src="/admin-css-js/bower_components/raphael/raphael-min.js"></script>-->
<!--        <script src="/admin-css-js/bower_components/morrisjs/morris.min.js"></script>-->
<!--        <script src="/admin-css-js/js/morris-data.js"></script>-->
        <script src="/admin-css-js/dist/js/sb-admin-2.js"></script>
        <script>
            $(document).ready(function()
            {
                $('#bootstrap-table').DataTable
                (
                    {
                        responsive: true
                    }
                );
            });

            $('#select-ajax-give-1').change(function()
                //Зависимые селекты
            {
                var ajax_give_2     = $("#select-ajax-give-2");
                var option_selected = $(this).find("option:selected");
                var value_select    = $(this).val();
                var give            = $(this).attr("data-give");
                var need            = $(this).attr("data-need");

                $.ajax
                (
                    {
                        url: '/json.php?select_value=' + value_select + '&select_give=' + give + '&select_need=' + need,
                        dataType: "json",
                        success: function(data)
                        {
                            var select = '';

                            for (var i=0; i<data.select_array.length; i++)
                            {
                                select = select
                                    + '<option value="'
                                    + data.select_array[i].value
                                    + '">'
                                    + data.select_array[i].text
                                    + '</option>';
                            }

                            $(ajax_give_2).html(select);
                        }
                    }
                );
            });
        </script>
    </body>
</html>