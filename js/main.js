$(document).ready(function($)
{
    var select_on_page_array = $('select');
    var input_on_page_array  = $('input');
    var div_on_page_array  = $('div');

    if ($(select_on_page_array).is('#autocomplete'))
    //Автозаполнение
    {
        $('#autocomplete').editableSelect();
    }

    if ($(div_on_page_array).is('#previous-position'))
    //Прошлые позиции команд в чемпионате
    {
        $('#previous-position').highcharts({
            title: {
                text: ''
            },
            xAxis: {
                title: {
                    text: 'Тур'
                },
                categories: position_stage
            },
            yAxis: {
                title: {
                    text: 'Позиция'
                },
                min: 1,
                max: 20,
                reversed: true,
                plotLines: [{
                    value: 0,
                    width: 0.5,
                    color: '#808080'
                }]
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br />',
                pointFormat: 'Тур: <b>{point.x}</b><br />Позиция: <b>{point.y}</b>'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            plotOptions: {
                series: {
                    marker: {
                        enabled: false,
                        states: {
                            hover: {
                                radius: 2,
                                radiusPlus: 2
                            }
                        }
                    }
                }
            },
            series: position_series,
            credits: {
                enabled: false
            }
        });
    }

    $('#tournament-stage-select').on('change',function()
    //Смена тура турнира на странице результатов
    {
        $('#tournament-stage-form').submit();
    });

    $('#horizontal-menu-tr').on('click', 'a', function()
    //Переключалка меню справа сверху
    {
        var horizontal_menu     = $('.horizontal-menu-second');
        var horizontal_menu_tr  = $('#horizontal-menu-tr');
        var id                  = this.id;
        var tr_id               = '#' + id + '-tr';

        $(horizontal_menu_tr).find('a').removeClass();
        $('#' + id).addClass('active');
        $(horizontal_menu).addClass('none');
        $(horizontal_menu).removeClass('horizontal-menu-second');
        $(tr_id).removeClass();
        $(horizontal_menu_tr).removeClass();
        $(horizontal_menu_tr).addClass('horizontal-menu');
        $(tr_id).addClass('horizontal-menu-second');
    });

    $('.alert').delay(3000).fadeOut(); //Отключение всплывающих сообщений

    $('#note-create').on('click', function()
    //Создание заметки
    {
        $('#note-table').addClass('none');
        $('#note-form').removeClass('none');
        $('#note-id').val('0');
    });

    $('.note-edit').on('click', function()
    //Редактирование заметки
    {
        var note_id = $(this).data('id');

        $.ajax
        (
            {
                beforeSend: function(){$('#note-block').addClass('loading');},
                url: 'json.php?note_id=' + note_id,
                dataType: "json",
                success: function(data)
                {
                    $('#note-input').val(data.note_array[0].note_title);
                    $('#note-textarea').text(data.note_array[0].note_text);

                    $('#note-table').addClass('none');
                    $('#note-form').removeClass('none');
                    $('#note-id').val(note_id);
                    $('#note-block').removeClass('loading');
                }
            }
        );
    });

    $('.note-view').on('click', function()
    //Просмотр заметки
    {
        var note_id = $(this).data('id');

        $.ajax
        (
            {
                beforeSend: function(){$('#note-block').addClass('loading');},
                url: 'json.php?note_id=' + note_id,
                dataType: "json",
                success: function(data)
                {
                    $('#note-title').html('<h1>' + data.note_array[0].note_title + '</h1>');
                    $('#note-text').html(data.note_array[0].note_text_nl2br);

                    $('#note-form').addClass('none');
                    $('#note-table').removeClass('none');
                    $('#note-block').removeClass('loading');
                }
            }
        );
    });

    if ($(input_on_page_array).is('#tactic-player-formation'))
    //Загрузка стриницы тактики
    {
        tactic_player_field();
    }

    if ($(input_on_page_array).is('#tactic-player-formation-national'))
    //Загрузка стриницы тактики
    {
        tactic_player_field_national();
    }

    $('.player-tactic-shirt').on('click', function()
    //Роль игрока при редактировании индивидуальной тактики
    {
        var position_id = $(this).data('position');
        var game_id     = $('#tactic-player-game').val();

        $.ajax
        (
            {
                url: 'json.php?player_tactic_position_id=' + position_id + '&game_id=' + game_id,
                dataType: "json",
                success: function(data)
                {
                    var role_select = '<select id="role-id" name="data[role]">';

                    for (var i=0; i<data.role_array.length; i++)
                    {
                        role_select = role_select + '<option value="' + data.role_array[i].role_id + '"';

                        if (data.role_array[i].role_id == data.role_id)
                        {
                            role_select = role_select + ' selected';
                        }

                        role_select = role_select + '>' + data.role_array[i].role_name + '</option>';
                    }

                    role_select = role_select + '</select>';

                    $('#position-name').text(data.position_name);
                    $('#table-player-position-name').text(data.position_description);
                    $('#table-player-position-game').text(data.game);
                    $('#table-player-mark').text(data.mark);
                    $('#player-name').text(data.player_name + ' на позиции ' + data.position_name);
                    $('#table-player-name').text(data.player_name);
                    $('#role-name').html(role_select);
                    $('#role-description').html(data.role_description);
                    $('#player-table').removeClass('none');
                    $('#lineup-id').val(data.lineup_id);
                    $('#submit-role').show();

                    $('#role-id').on('change', function()
                        //Смена роли игрока
                    {
                        var role_id = $(this).val();

                        $.ajax
                        (
                            {
                                url: 'json.php?change_role_id=' + role_id + '&position_id=' + position_id,
                                dataType: "json",
                                success: function(data)
                                {
                                    $('#role-description').html(data.role_array[0].role_description);
                                }
                            }
                        );
                    });
                }
            }
        );
    });

    $('.player-tactic-shirt-national').on('click', function()
    //Роль игрока при редактировании индивидуальной тактики
    {
        var position_id = $(this).data('position');
        var game_id     = $('#tactic-player-game').val();

        $.ajax
        (
            {
                url: 'json.php?national_player_tactic_position_id=' + position_id + '&game_id=' + game_id,
                dataType: "json",
                success: function(data)
                {
                    var role_select = '<select id="role-id" name="data[role]">';

                    for (var i=0; i<data.role_array.length; i++)
                    {
                        role_select = role_select + '<option value="' + data.role_array[i].role_id + '"';

                        if (data.role_array[i].role_id == data.role_id)
                        {
                            role_select = role_select + ' selected';
                        }

                        role_select = role_select + '>' + data.role_array[i].role_name + '</option>';
                    }

                    role_select = role_select + '</select>';

                    $('#position-name').text(data.position_name);
                    $('#table-player-position-name').text(data.position_description);
                    $('#table-player-position-game').text(data.game);
                    $('#table-player-mark').text(data.mark);
                    $('#player-name').text(data.player_name + ' на позиции ' + data.position_name);
                    $('#table-player-name').text(data.player_name);
                    $('#role-name').html(role_select);
                    $('#role-description').html(data.role_description);
                    $('#player-table').removeClass('none');
                    $('#lineup-id').val(data.lineup_id);
                    $('#submit-role').show();

                    $('#role-id').on('change', function()
                        //Смена роли игрока
                    {
                        var role_id = $(this).val();

                        $.ajax
                        (
                            {
                                url: 'json.php?change_role_id=' + role_id + '&position_id=' + position_id,
                                dataType: "json",
                                success: function(data)
                                {
                                    $('#role-description').html(data.role_array[0].role_description);
                                }
                            }
                        );
                    });
                }
            }
        );
    });

    $('#tournament-game-prev').on('click', function()
    //Список игр предыдущего тура
    {
        var tournament_id = $(this).data('tournament');
        var shedule_id    = $(this).data('shedule');

        $.ajax
        (
            {
                beforeSend: function(){$('#game-block').addClass('loading');},
                url: 'json.php?shedule_prev=' + shedule_id + '&tournament=' + tournament_id,
                dataType: "json",
                success: function(data)
                {
                    var table_data = '';

                    for (var i=0; i<data.game_array.length; i++)
                    {
                        if (1 == data.game_array[i].game_played)
                        {
                            var score = data.game_array[i].game_home_score
                                + ':'
                                + data.game_array[i].game_guest_score
                        }
                        else
                        {
                            var score = '';
                        }

                        table_data = table_data
                            + '<tr><td class="right w45"><a href="team_team_review_profile.php?num='
                            + data.game_array[i].game_home_team_id
                            + '">'
                            + data.game_array[i].home_team_name
                            + '</a></td><td class="center"><a href="game_review_main.php?num='
                            + data.game_array[i].game_id
                            + '">'
                            + score
                            + '</a></td><td class="w45"><a href="team_team_review_profile.php?num='
                            + data.game_array[i].game_guest_team_id
                            + '">'
                            + data.game_array[i].guest_team_name
                            + '</a></td></tr>';
                    }

                    var shedule_date = data.game_array[0].shedule_day + ', ' + data.game_array[0].shedule_date;

                    $('#tournament-game').html(table_data);
                    $('#shedule-date').html(shedule_date);

                    $('#tournament-game-prev').data('shedule', data.game_array[0].shedule_id);
                    $('#tournament-game-next').data('shedule', data.game_array[0].shedule_id);
                    $('#game-block').removeClass('loading');
                }
            }
        );
    });

    $('#tournament-game-next').on('click', function()
    //Список игр следующего тура
    {
        var tournament_id = $(this).data('tournament');
        var shedule_id    = $(this).data('shedule');

        $.ajax
        (
            {
                beforeSend: function(){$('#game-block').addClass('loading');},
                url: 'json.php?shedule_next=' + shedule_id + '&tournament=' + tournament_id,
                dataType: "json",
                success: function(data)
                {
                    var table_data = '';

                    for (var i=0; i<data.game_array.length; i++)
                    {
                        if (1 == data.game_array[i].game_played)
                        {
                            var score = data.game_array[i].game_home_score
                                + ':'
                                + data.game_array[i].game_guest_score
                        }
                        else
                        {
                            var score = '';
                        }

                        table_data = table_data
                            + '<tr><td class="right w45"><a href="team_team_review_profile.php?num='
                            + data.game_array[i].game_home_team_id
                            + '">'
                            + data.game_array[i].home_team_name
                            + '</a></td><td class="center"><a href="game_review_main.php?num='
                            + data.game_array[i].game_id
                            + '">'
                            + score
                            + '</a></td><td class="w45"><a href="team_team_review_profile.php?num='
                            + data.game_array[i].game_guest_team_id
                            + '">'
                            + data.game_array[i].guest_team_name
                            + '</a></td></tr>';
                    }

                    var shedule_date = data.game_array[0].shedule_day + ', ' + data.game_array[0].shedule_date;

                    $('#tournament-game').html(table_data);
                    $('#shedule-date').html(shedule_date);

                    $('#tournament-game-prev').data('shedule', data.game_array[0].shedule_id);
                    $('#tournament-game-next').data('shedule', data.game_array[0].shedule_id);
                    $('#game-block').removeClass('loading');
                }
            }
        );
    });

    $('#tournament-stage-prev').on('click', function()
    //Предыдущая стадия
    {
        var tournament_id   = $(this).data('tournament');
        var stage_id        = $(this).data('stage');

        $.ajax
        (
            {
                beforeSend: function(){$('#stage-block').addClass('loading');},
                url: 'json.php?stage_prev=' + stage_id + '&tournament=' + tournament_id,
                dataType: "json",
                success: function(data)
                {
                    console.log(data);
                    if (undefined !== data.stage_array[0].game_played_1)
                    {
                        var table_data  = '';

                        for (var i=0; i<data.stage_array.length; i++)
                        {
                            if (1 == data.stage_array[i].game_played_1)
                            {
                                var score_1 = data.stage_array[i].home_score_1
                                    + ':'
                                    + data.stage_array[i].guest_score_1
                            }
                            else
                            {
                                var score_1 = '';
                            }

                            if (1 == data.stage_array[i].game_played_2)
                            {
                                var score_2 = data.stage_array[i].home_score_2
                                    + ':'
                                    + data.stage_array[i].guest_score_2
                            }
                            else
                            {
                                var score_2 = '';
                            }

                            table_data = table_data
                                + '<tr><td class="right w40"><a href="team_team_review_profile.php?num='
                                + data.stage_array[i].game_home_team_id
                                + '">'
                                + data.stage_array[i].home_team_name
                                + '</a></td><td class="center"><a href="game_review_main.php?num='
                                + data.stage_array[i].game_id_2
                                + '">'
                                + score_2
                                + '</a> (<a href="game_review_main.php?num='
                                + data.stage_array[i].game_id_1
                                + '">'
                                + score_1
                                + '</a>)</td><td class="w40"><a href="team_team_review_profile.php?num='
                                + data.stage_array[i].game_guest_team_id
                                + '">'
                                + data.stage_array[i].guest_team_name
                                + '</a></td></tr>';
                        }

                        var stage_name  = data.stage_array[0].stage_name;
                        var stage_id    = data.stage_array[0].stage_id;
                    }
                    else
                    {
                        var group       = '';
                        var table_data  = '';

                        for (var i=0; i<data.stage_array.length; i++)
                        {
                            if (group != data.stage_array[i].league_group)
                            {
                                group = data.stage_array[i].league_group;

                                table_data = table_data
                                + '<tr><th class="w8">№</th><th>Группа '
                                + group
                                + '</th><th class="w8">И</th><th class="w8">В</th><th class="w8">Н</th><th class="w8">П</th><th class="w8">О</th></tr>';
                            }

                            table_data = table_data
                                + '<tr><td class="center">'
                                + data.stage_array[i].league_place
                                + '</td><td><img alt="'
                                + data.stage_array[i].team_name
                                + ' class="img-12" src="/img/team/12/'
                                + data.stage_array[i].team_id
                                + '.png" /> '
                                + data.stage_array[i].team_name
                                + '</td><td class="center">'
                                + data.stage_array[i].league_game
                                + '</td><td class="center">'
                                + data.stage_array[i].league_win
                                + '</td><td class="center">'
                                + data.stage_array[i].league_draw
                                + '</td><td class="center">'
                                + data.stage_array[i].league_loose
                                + '</td><td class="center">'
                                + data.stage_array[i].league_point
                                + '</td></tr>';
                        }

                        var stage_name  = 'Групповой этап';
                        var stage_id    = '1';
                    }

                    $('#tournament-stage').html(table_data);
                    $('#stage-name').html(stage_name);

                    $('#tournament-stage-prev').data('stage', stage_id);
                    $('#tournament-stage-next').data('stage', stage_id);
                    $('#stage-block').removeClass('loading');
                }
            }
        );
    });

    $('#tournament-stage-next').on('click', function()
    //Следующая стадия
    {
        var tournament_id   = $(this).data('tournament');
        var stage_id        = $(this).data('stage');

        $.ajax
        (
            {
                beforeSend: function(){$('#stage-block').addClass('loading');},
                url: 'json.php?stage_next=' + stage_id + '&tournament=' + tournament_id,
                dataType: "json",
                success: function(data)
                {
                    if (undefined !== data.stage_array[0].game_played_1)
                    {
                    var table_data  = '';
                    var stage_id    = data.stage_array[0].stage_id;

                    for (var i=0; i<data.stage_array.length; i++)
                    {
                        if (1 == data.stage_array[i].game_played_1)
                        {
                            var score_1 = data.stage_array[i].home_score_1
                                + ':'
                                + data.stage_array[i].guest_score_1
                        }
                        else
                        {
                            var score_1 = '';
                        }

                        if (1 == data.stage_array[i].game_played_2)
                        {
                            var score_2 = data.stage_array[i].home_score_2
                                + ':'
                                + data.stage_array[i].guest_score_2
                        }
                        else
                        {
                            var score_2 = '';
                        }

                        table_data = table_data
                            + '<tr><td class="right w40"><a href="team_team_review_profile.php?num='
                            + data.stage_array[i].game_home_team_id
                            + '">'
                            + data.stage_array[i].home_team_name
                            + '</a></td><td class="center">';

                        if (49 != stage_id || 3 == tournament_id)
                        {
                            table_data = table_data
                                + '<a href="game_review_main.php?num='
                                + data.stage_array[i].game_id_2
                                + '">'
                                + score_2
                                + '</a> (';
                        }

                        table_data = table_data
                            + '<a href="game_review_main.php?num='
                            + data.stage_array[i].game_id_1
                            + '">'
                            + score_1
                            + '</a>';

                        if (49 != stage_id || 3 == tournament_id)
                        {
                            table_data = table_data
                                + ')';
                        }

                        table_data = table_data
                            + '</td><td class="w40"><a href="team_team_review_profile.php?num='
                            + data.stage_array[i].game_guest_team_id
                            + '">'
                            + data.stage_array[i].guest_team_name
                            + '</a></td></tr>';
                    }
                        var stage_name  = data.stage_array[0].stage_name;
                        var stage_id    = data.stage_array[0].stage_id;
                    }
                    else
                    {
                        var group       = '';
                        var table_data  = '';

                        for (var i=0; i<data.stage_array.length; i++)
                        {
                            if (group != data.stage_array[i].league_group)
                            {
                                group = data.stage_array[i].league_group;

                                table_data = table_data
                                + '<tr><th class="w8">№</th><th>Группа '
                                + group
                                + '</th><th class="w8">И</th><th class="w8">В</th><th class="w8">Н</th><th class="w8">П</th><th class="w8">О</th></tr>';
                            }

                            table_data = table_data
                                + '<tr><td class="center">'
                                + data.stage_array[i].league_place
                                + '</td><td><img alt="'
                                + data.stage_array[i].team_name
                                + ' class="img-12" src="/img/team/12/'
                                + data.stage_array[i].team_id
                                + '.png" /> '
                                + data.stage_array[i].team_name
                                + '</td><td class="center">'
                                + data.stage_array[i].league_game
                                + '</td><td class="center">'
                                + data.stage_array[i].league_win
                                + '</td><td class="center">'
                                + data.stage_array[i].league_draw
                                + '</td><td class="center">'
                                + data.stage_array[i].league_loose
                                + '</td><td class="center">'
                                + data.stage_array[i].league_point
                                + '</td></tr>';
                        }

                        var stage_name  = 'Групповой этап';
                        var stage_id    = 1;
                    }

                    $('#tournament-stage').html(table_data);
                    $('#stage-name').html(stage_name);

                    $('#tournament-stage-prev').data('stage', stage_id);
                    $('#tournament-stage-next').data('stage', stage_id);
                    $('#stage-block').removeClass('loading');
                }
            }
        );
    });

    $('#worldcup-game-prev').on('click', function()
    //Список игр предыдущего тура
    {
        var tournament_id = $(this).data('tournament');
        var shedule_id    = $(this).data('shedule');

        $.ajax
        (
            {
                beforeSend: function(){$('#game-block').addClass('loading');},
                url: 'json.php?shedule_worldcup_prev=' + shedule_id + '&tournament=' + tournament_id,
                dataType: "json",
                success: function(data)
                {
                    var table_data = '';

                    for (var i=0; i<data.game_array.length; i++)
                    {
                        if (1 == data.game_array[i].game_played)
                        {
                            var score = data.game_array[i].game_home_score
                                + ':'
                                + data.game_array[i].game_guest_score
                        }
                        else
                        {
                            var score = '';
                        }

                        table_data = table_data
                            + '<tr><td class="right w45"><a href="national_team_review_profile.php?num='
                            + data.game_array[i].game_home_country_id
                            + '">'
                            + data.game_array[i].home_country_name
                            + '</a></td><td class="center"><a href="game_review_main.php?num='
                            + data.game_array[i].game_id
                            + '">'
                            + score
                            + '</a></td><td class="w45"><a href="national_team_review_profile.php?num='
                            + data.game_array[i].game_guest_country_id
                            + '">'
                            + data.game_array[i].guest_country_name
                            + '</a></td></tr>';
                    }

                    var shedule_date = data.game_array[0].shedule_day + ', ' + data.game_array[0].shedule_date;

                    $('#tournament-game').html(table_data);
                    $('#shedule-date').html(shedule_date);

                    $('#worldcup-game-prev').data('shedule', data.game_array[0].shedule_id);
                    $('#worldcup-game-next').data('shedule', data.game_array[0].shedule_id);
                    $('#game-block').removeClass('loading');
                }
            }
        );
    });

    $('#worldcup-game-next').on('click', function()
    //Список игр следующего тура
    {
        var tournament_id = $(this).data('tournament');
        var shedule_id    = $(this).data('shedule');

        $.ajax
        (
            {
                beforeSend: function(){$('#game-block').addClass('loading');},
                url: 'json.php?shedule_worldcup_next=' + shedule_id + '&tournament=' + tournament_id,
                dataType: "json",
                success: function(data)
                {
                    var table_data = '';

                    for (var i=0; i<data.game_array.length; i++)
                    {
                        if (1 == data.game_array[i].game_played)
                        {
                            var score = data.game_array[i].game_home_score
                                + ':'
                                + data.game_array[i].game_guest_score
                        }
                        else
                        {
                            var score = '';
                        }

                        table_data = table_data
                            + '<tr><td class="right w45"><a href="national_team_review_profile.php?num='
                            + data.game_array[i].game_home_country_id
                            + '">'
                            + data.game_array[i].home_country_name
                            + '</a></td><td class="center"><a href="game_review_main.php?num='
                            + data.game_array[i].game_id
                            + '">'
                            + score
                            + '</a></td><td class="w45"><a href="national_team_review_profile.php?num='
                            + data.game_array[i].game_guest_country_id
                            + '">'
                            + data.game_array[i].guest_country_name
                            + '</a></td></tr>';
                    }

                    var shedule_date = data.game_array[0].shedule_day + ', ' + data.game_array[0].shedule_date;

                    $('#tournament-game').html(table_data);
                    $('#shedule-date').html(shedule_date);

                    $('#worldcup-game-prev').data('shedule', data.game_array[0].shedule_id);
                    $('#worldcup-game-next').data('shedule', data.game_array[0].shedule_id);
                    $('#game-block').removeClass('loading');
                }
            }
        );
    });

    $('#outbox-create').on('click', function()
    //Написать личное сообщение
    {
        $('.inbox-header').empty();
        $('.inbox-text').empty();
        $('.inbox-button').empty();
        $('#outbox-form').show();
    });

    $('.inbox-title').on('click', function()
    //Текст новости
    {
        var inbox_id = $(this).data('id');
        $(this).removeClass('strong');

        $.ajax
        (
            {
                beforeSend: function(){$('#inbox-block').addClass('loading');},
                url: 'json.php?inbox_id=' + inbox_id,
                dataType: "json",
                success: function(data)
                {
                    $('.inbox-header').html(data.inbox_array[0].inbox_title);
                    $('.inbox-text').html(data.inbox_array[0].inbox_text);
                    $('.inbox-button').html(data.inbox_array[0].inbox_button);
                    $('#inbox-block').removeClass('loading');
                }
            }
        );
    });

    $('.outbox-title').on('click', function()
    //Текст новости
    {
        var inbox_id = $(this).data('id');
        $('#outbox-form').hide();

        $.ajax
        (
            {
                beforeSend: function(){$('#inbox-block').addClass('loading');},
                url: 'json.php?outbox_id=' + inbox_id,
                dataType: "json",
                success: function(data)
                {
                    $('.inbox-header').html(data.inbox_array[0].inbox_title);
                    $('.inbox-text').html(data.inbox_array[0].inbox_text);
                    $('.inbox-button').html(data.inbox_array[0].inbox_button);
                    $('#inbox-block').removeClass('loading');
                }
            }
        );
    });

    if ($(select_on_page_array).is('#tactic-select'))
    //Загрузка страницы тактики
    {
        tactic_field();
    }

    $('#tactic-select').on('change', function()
    //Смена расстановки на странице тактики
    {
        tactic_field();
    });

    $('.position-select').on('change', function()
    //Смена позиции игрока на странице тактики
    {
        tactic_name(this);
    });

    $('.role-select').on('change', function()
    //Выбор ролей игроков
    {
        var role_select_array = $('.role-select');

        for (var i=0; i<role_select_array.length; i++)
        {
            var role_value   = $(role_select_array[i]).val();

            var select_array    = $(role_select_array[i]).parent().parent().find('option', '.position-select');
            var selected_item   = $(role_select_array[i]).parent().parent().find('option:selected', '.position-select');
            var select_index    = select_array.index(selected_item);

            if (0 < select_index)
            {
                $('#input-role-' + select_index).val(role_value);
            }
        }
    });

    $('#gamestyle-select').on('change', function()
    //Смена командного стиля игры
    {
        var style_id = $(this).val();

        $('.gamestyle-td').hide();
        $('#gamestyle-' + style_id).show();
    });

    $('#gamestyle-select-national').on('change', function()
    //Смена командного стиля игры
    {
        var style_id = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#tactic-block').addClass('loading');},
                url: 'json.php?national_style_id=' + style_id,
                dataType: "json",
                success: function(data)
                {
                    $('#gamestyle').html('<h6>' + data.gamestyle_array[0].gamestyle_name + '</h6>' + data.gamestyle_array[0].gamestyle_description);
                    $('#tactic-block').removeClass('loading');
                }
            }
        );
    });

    $('#gamemood-select').on('change', function()
    //Смена командного настроя на игру
    {
        var mood_id = $(this).val();

        $('.gamemood-td').hide();
        $('#gamemood-' + mood_id).show();
    });

    $('#gamemood-select-national').on('change', function()
    //Смена командного настроя на игру
    {
        var mood_id = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#tactic-block').addClass('loading');},
                url: 'json.php?national_mood_id=' + mood_id,
                dataType: "json",
                success: function(data)
                {
                    $('#gamemood').html('<h6>' + data.gamemood_array[0].gamemood_name + '</h6>' + data.gamemood_array[0].gamemood_description);
                    $('#tactic-block').removeClass('loading');
                }
            }
        );
    });

    if ($(select_on_page_array).is('#select-captain-1'))
    //Загрузка капитана
    {
        captain_select();
    }

    $('.select-captain').on('change', function()
    //Выбор капитана
    {
        captain_select();
    });

    if ($(select_on_page_array).is('#select-penalty-1'))
    //Загрузка страницы пенальтистов
    {
        penalty_select();
    }

    $('.select-penalty').on('change', function()
    //Выбор пенальтистов
    {
        penalty_select();
    });

    if ($(select_on_page_array).is('#select-corner-left-1'))
    //Загрузка страницы исполнителей стандартов
    {
        corner_left_select();
        corner_right_select();
        freekick_left_select();
        freekick_right_select();
        out_left_select();
        out_right_select();
    }

    $('.select-corner-left').on('change', function()
    //Выбор исполнителей стандартов
    {
        corner_left_select();
    });

    $('.select-corner-right').on('change', function()
    //Выбор исполнителей стандартов
    {
        corner_right_select();
    });

    $('.select-freekick-left').on('change', function()
    //Выбор исполнителей стандартов
    {
        freekick_left_select();
    });

    $('.select-freekick-right').on('change', function()
    //Выбор исполнителей стандартов
    {
        freekick_right_select();
    });

    $('.select-out-left').on('change', function()
    //Выбор исполнителей стандартов
    {
        out_left_select();
    });

    $('.select-out-right').on('change', function()
    //Выбор исполнителей стандартов
    {
        out_right_select();
    });

    $('#page-select').on('change', function()
    //Смена страницы
    {
        $('#page-form').submit();
    });

    $('.finance-link').on('click', function()
    //Переключение вкладок на странице финансов
    {
        var data_id = $(this).data('id');
        $('.finance-link').removeClass('active');
        $(this).addClass('active');
        $('.striped').hide();
        $('#finance-' + data_id).show();
    });

    $('.player-number-national').on('change', function()
    //Смена номера игрока
    {
        $('#player-info').addClass('loading');

        var player_id   = $(this).data('player');
        var number      = $(this).val();

        $.ajax
        (
            {
                url: 'json.php?player_id=' + player_id + '&number_national=' + number,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#player-info').removeClass('loading');
                    }
                }
            }
        );
    });

    $('.instruction-checkbox-national').on('change', function()
    //Смена командных инкструкций
    {
        $('#instruction-block').addClass('loading');

        var instruction = $(this).val();

        $.ajax
        (
            {
                url: 'json.php?national_instruction_id=' + instruction,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#instruction-block').removeClass('loading');
                    }
                }
            }
        );
    });

    $('.asktoplay-link').on('click', function()
    //Просмотр инфо о доступном дне для тов матчей
    {
        var shedule_id = $(this).data('shedule');

        $.ajax
        (
            {
                beforeSend: function(){$('#asktoplay').addClass('loading');},
                url: 'json.php?asktoplay=' + shedule_id,
                dataType: "json",
                success: function(data)
                {
                    var select = '<option value="0">-</option>';

                    for (var i=0; i<data.team_array.length; i++)
                    {
                        select = select
                            + '<option value="'
                            + data.team_array[i].team_id
                            + '">'
                            + data.team_array[i].team_name
                            + '</option>';
                    }

                    var invitee     = '<table class="striped w100"><tr><th colspan="4">Полученные приглашения</th></tr>';
                    var home_guest  = '';

                    for (var i=0; i<data.invitee_array.length; i++)
                    {
                        if (1 == data.invitee_array[i].asktoplay_home)
                        {
                            home_guest = 'В гостях';
                        }
                        else
                        {
                            home_guest = 'Дома';
                        }

                        invitee = invitee
                            + '<tr><td class="w1"><img src="/img/team/12/'
                            + data.invitee_array[i].team_id
                            + '.png" alt="'
                            + data.invitee_array[i].team_name
                            + '"></td><td><a href="team_team_review_profile.php?num='
                            + data.invitee_array[i].team_id
                            + '">'
                            + data.invitee_array[i].team_name
                            + '</a></td><td class="center w30">'
                            + home_guest
                            + '</td><td class="center w20"><a href="?num='
                            + data.num
                            + '&ok='
                            + data.invitee_array[i].asktoplay_id
                            + '&shedule='
                            + shedule_id
                            + '&team='
                            + data.invitee_array[i].team_id
                            + '" class="link-img link-ok" /> <a href="javascript:;" data-delete="'
                            + data.invitee_array[i].asktoplay_id
                            + '" data-shedule="'
                            + shedule_id
                            + '" class="link-img link-delete asktoplay-delete" /></td></tr>';
                    }

                    invitee = invitee + '</table>';

                    var inviter = '<table class="striped w100"><tr><th colspan="4">Отправленные приглашения</th></tr>';

                    for (var i=0; i<data.inviter_array.length; i++)
                    {
                        if (1 == data.inviter_array[i].asktoplay_home)
                        {
                            home_guest = 'Дома';
                        }
                        else
                        {
                            home_guest = 'В гостях';
                        }

                        inviter = inviter
                            + '<tr><td class="w1"><img src="/img/team/12/'
                            + data.inviter_array[i].team_id
                            + '.png" alt="'
                            + data.inviter_array[i].team_name
                            + '"></td><td><a href="team_team_review_profile.php?num='
                            + data.inviter_array[i].team_id
                            + '">'
                            + data.inviter_array[i].team_name
                            + '</a></td><td class="center w30">'
                            + home_guest
                            + '</td><td class="center w20"><a href="javascript:;" data-delete="'
                            + data.inviter_array[i].asktoplay_id
                            + '" data-shedule="'
                            + shedule_id
                            + '" class="link-img link-delete asktoplay-delete" /></td></tr>';
                    }

                    inviter = inviter + '</table>';

                    $('#astoplay-select-team').html(select);
                    $('#asktoplay-invitee').html(invitee);
                    $('#asktoplay-inviter').html(inviter);
                    $('#asktoplay-submit').data('shedule', shedule_id);
                    $('#asktoplay-date').html(data.shedule_date);
                    $('#asktoplay-table').show();
                    $('#asktoplay').removeClass('loading');

                    asktoplay_delete();
                }
            }
        );
    });

    $('#asktoplay-submit').on('click', function()
    //Отправка приглашения на товарищеский матч
    {
        $('#asktoplay').addClass('loading');

        var shedule_id  = $(this).data('shedule');
        var home_flag   = $('#asktoplay-home').val();
        var team_id     = $('#astoplay-select-team').val();

        $.ajax
        (
            {
                url: 'json.php?asktoplay=' + shedule_id + '&invite=' + team_id + '&home=' + home_flag,
                dataType: "json",
                success: function(data)
                {
                    var select = '<option value="0">-</option>';

                    for (var i=0; i<data.team_array.length; i++)
                    {
                        select = select
                            + '<option value="'
                            + data.team_array[i].team_id
                            + '">'
                            + data.team_array[i].team_name
                            + '</option>';
                    }

                    var invitee     = '<table class="striped w100"><tr><th colspan="4">Полученные приглашения</th></tr>';
                    var home_guest  = '';

                    for (var i=0; i<data.invitee_array.length; i++)
                    {
                        if (1 == data.invitee_array[i].asktoplay_home)
                        {
                            home_guest = 'В гостях';
                        }
                        else
                        {
                            home_guest = 'Дома';
                        }

                        invitee = invitee
                            + '<tr><td class="w1"><img src="/img/team/12/'
                            + data.invitee_array[i].team_id
                            + '.png" alt="'
                            + data.invitee_array[i].team_name
                            + '"></td><td><a href="team_team_review_profile.php?num='
                            + data.invitee_array[i].team_id
                            + '">'
                            + data.invitee_array[i].team_name
                            + '</a></td><td class="center w30">'
                            + home_guest
                            + '</td><td class="center w20"><a href="?ok='
                            + data.invitee_array[i].asktoplay_id
                            + '" class="link-img link-ok" /> <a href="javascript:;" data-delete="'
                            + data.invitee_array[i].asktoplay_id
                            + '" data-shedule="'
                            + shedule_id
                            + '" class="link-img link-delete asktoplay-delete" /></td></tr>';
                    }

                    invitee = invitee + '</table>';

                    var inviter = '<table class="striped w100"><tr><th colspan="4">Отправленные приглашения</th></tr>';

                    for (var i=0; i<data.inviter_array.length; i++)
                    {
                        if (1 == data.inviter_array[i].asktoplay_home)
                        {
                            home_guest = 'Дома';
                        }
                        else
                        {
                            home_guest = 'В гостях';
                        }

                        inviter = inviter
                            + '<tr><td class="w1"><img src="/img/team/12/'
                            + data.inviter_array[i].team_id
                            + '.png" alt="'
                            + data.inviter_array[i].team_name
                            + '"></td><td><a href="team_team_review_profile.php?num='
                            + data.inviter_array[i].team_id
                            + '">'
                            + data.inviter_array[i].team_name
                            + '</a></td><td class="center w30">'
                            + home_guest
                            + '</td><td class="center w20"><a href="javascript:;" data-delete="'
                            + data.inviter_array[i].asktoplay_id
                            + '" data-shedule="'
                            + shedule_id
                            + '" class="link-img link-delete asktoplay-delete" /></td></tr>';
                    }

                    inviter = inviter + '</table>';

                    $('#astoplay-select-team').html(select);
                    $('#asktoplay-invitee').html(invitee);
                    $('#asktoplay-inviter').html(inviter);
                    $('#asktoplay-submit').data('shedule', shedule_id);
                    $('#asktoplay-date').html(data.shedule_date);
                    $('#asktoplay-table').show();
                    $('#asktoplay').removeClass('loading');

                    asktoplay_delete();
                }
            }
        );
    });

    $('.player-national-include').on('click', function()
    //Добавление игрока в сборную
    {
        var player_id = $(this).data('player');

        $('#player-block').addClass('loading');

        $.ajax
        (
            {
                url: 'json.php?to_national_player_id=' + player_id,
                dataType: "json",
                success: function(data)
                {
                    $('#player-block').removeClass('loading');
                }
            }
        );
    });

    $('#application-country-id').on('change', function()
    //Просмотр своей заявки на должность тренера
    {
        var country_id = $(this).val();

        $('#application-block').addClass('loading');

        $.ajax
        (
            {
                url: 'json.php?application_country_id=' + country_id,
                dataType: "json",
                success: function(data)
                {
                    $('#application-text').text(data.coachapplication_text);
                    $('#application-block').removeClass('loading');
                }
            }
        );
    });

    $('#pay2pay-button').on('click', function()
    //Описание pay2pay
    {
        var text = $(this).text();

        if ('Подробнее' == text)
        {
            $(this).text('Свернуть');
        }
        else
        {
            $(this).text('Подробнее');
        }

        $('#pay2pay-description').toggle('slow');
    });

    $('#registration-login-input').on('change', function()
    //Регистрация - проверка логина
    {
        var login = $(this).val();

        $.ajax
        (
            {
                url: 'json.php?registration_login=' + login,
                dataType: "json",
                success: function(data)
                {
                    if (0 == data.count_user)
                    {
                        $('#registration-login-tr').hide();
                    }
                    else
                    {
                        $('#registration-login-tr').show();
                    }
                }
            }
        );
    });

    $('#registration-email-input').on('change', function()
    //Регистрация - проверка email
    {
        var email = $(this).val();

        $.ajax
        (
            {
                url: 'json.php?registration_email=' + email,
                dataType: "json",
                success: function(data)
                {
                    if (0 == data.count_user)
                    {
                        $('#registration-email-tr').hide();
                    }
                    else
                    {
                        $('#registration-email-tr').show();
                    }
                }
            }
        );
    });

    $('#questionary-login-input').on('change', function()
    //Анкета - проверка логина
    {
        var login = $(this).val();

        $.ajax
        (
            {
                url: 'json.php?questionary_login=' + login,
                dataType: "json",
                success: function(data)
                {
                    if (0 == data.count_user)
                    {
                        $('#questionary-login-span').hide();
                    }
                    else
                    {
                        $('#questionary-login-span').show();
                    }
                }
            }
        );
    });

    $('#questionary-email-input').on('change', function()
    //Анкета - проверка email
    {
        var email = $(this).val();

        $.ajax
        (
            {
                url: 'json.php?questionary_email=' + email,
                dataType: "json",
                success: function(data)
                {
                    if (0 == data.count_user)
                    {
                        $('#questionary-email-span').hide();
                    }
                    else
                    {
                        $('#questionary-email-span').show();
                    }
                }
            }
        );
    });
});