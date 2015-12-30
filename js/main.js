$(document).ready(function($)
{
    var select_on_page_array = $('select');
    var input_on_page_array  = $('input');

    $('#tournament-stage-select').on('change',function()
    //Смена тура турнира на странице результатов
    {
        $('#tournament-stage-form').submit();
    });

    $('#horizontal-menu-tr').on('click', 'a', function()
    //Переключалка меню справа сверху
    {
        var horizontal_menu     = $('.horizontal-menu');
        var horizontal_menu_tr  = $('#horizontal-menu-tr');
        var id                  = this.id;
        var tr_id               = '#' + id + '-tr';

        $(horizontal_menu_tr).find('a').removeClass();
        $('#' + id).addClass('active');
        $(horizontal_menu).addClass('none');
        $(horizontal_menu).removeClass('horizontal-menu');
        $(tr_id).removeClass();
        $(horizontal_menu_tr).removeClass();
        $(horizontal_menu_tr).addClass('horizontal-menu');
        $(tr_id).addClass('horizontal-menu');
    });

    $('.alert').delay(3000).fadeOut(); //Отключение всплывающих сообщений

    $('#select-ajax-give-1').change(function()
    //Зависимые селекты
    {
        var ajax_give_2     = $("#select-ajax-give-2");
        var option_selected = $(this).find("option:selected");
        var value_select    = $(option_selected).val();
        var give            = $(option_selected).attr("data-give");
        var need            = $(option_selected).attr("data-need");

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

    //Записная книжка менеджера
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
                    $('#note-text').html(data.note_array[0].note_text);

                    $('#note-form').addClass('none');
                    $('#note-table').removeClass('none');
                    $('#note-block').removeClass('loading');
                }
            }
        );
    });

    $('.note-delete').on('click', function()
    //Удаление заметки
    {
        window.location.href = '/profile_history_note.php?note=' + $(this).data('id');
    });

    if ($(input_on_page_array).is('#tactic-player-formation'))
    //Загрузка стриницы тактики
    {
        tactic_player_field();
    }

    $('.player-tactic-shirt').on('click', function()
    //Роль игрока при редактировании индивидуальной тактики
    {
        var position_id = $(this).data('position');

        $.ajax
        (
            {
                url: 'json.php?player_tactic_position_id=' + position_id,
                dataType: "json",
                success: function(data)
                {
                    var role_select = '<select id="role-id" data-position="' + data.position + '">';

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

                    $('#role-id').on('change', function()
                    //Смена роли игрока
                    {
                        var role_id = $(this).val();
                        var position_id = $(this).data('position');

                        $.ajax
                        (
                            {
                                beforeSend: function(){$('#position-block').addClass('loading');},
                                url: 'json.php?change_role_id=' + role_id + '&position_id=' + position_id,
                                dataType: "json",
                                success: function(data)
                                {
                                    $('#role-description').html(data.role_array[0].role_description);
                                    $('#position-block').removeClass('loading');
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

    $('#status-transfer').on('change', function()
    //Изменение трансферного статуса
    {
        var player_id   = $(this).data('player');
        var status      = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#transfer-info').addClass('loading');},
                url: 'json.php?player_id=' + player_id + '&statustransfer_id=' + status,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#transfer-info').removeClass('loading');
                    }
                }
            }
        );
    });

    $('#status-rent').on('change', function()
    //Изменение арендного статуса
    {
        var player_id   = $(this).data('player');
        var status      = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#transfer-info').addClass('loading');},
                url: 'json.php?player_id=' + player_id + '&statusrent_id=' + status,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#transfer-info').removeClass('loading');
                    }
                }
            }
        );
    });

    $('#status-team').on('change', function()
    //Изменение командного статуса
    {
        var player_id   = $(this).data('player');
        var status      = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#transfer-info').addClass('loading');},
                url: 'json.php?player_id=' + player_id + '&statusteam_id=' + status,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#transfer-info').removeClass('loading');
                    }
                }
            }
        );
    });

    $('#transfer-price').on('change', function()
    //Изменение трансферной цены
    {
        var player_id   = $(this).data('player');
        var price       = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#transfer-info').addClass('loading');},
                url: 'json.php?player_id=' + player_id + '&transfer_price=' + price,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#transfer-info').removeClass('loading');
                    }
                }
            }
        );
    });

    $('#offer-price, #offer-type').on('change', function()
    //Стоимость трансферного предложения
    {
        var player_id   = $(this).data('player');
        var price       = $('#offer-price').val();
        var offer_type  = $('#offer-type').val();

        $.ajax
        (
            {
                beforeSend: function(){$('#offer-info').addClass('loading');},
                url: 'json.php?player_id=' + player_id + '&offer_price=' + price + '&offer_type=' + offer_type,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#offer-info').removeClass('loading');
                    }
                }
            }
        );
    });

    $('.inbox-title').on('click', function()
    //Текст новости
    {
        var inbox_id = $(this).data('id');

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

                    $('body #inbox-asktoplay-no').on('click', function()
                    //Отказ сыграть товарищеский матч
                    {
                        var asktoplay   = $(this).data('id');
                        var inbox_id     = $(this).data('inbox');

                        $.ajax
                        (
                            {
                                beforeSend: function(){$('#inbox-block').addClass('loading');},
                                url: 'json.php?asktoplay_reject=' + asktoplay + '&asktoplay_inbox_id=' + inbox_id,
                                dataType: "json",
                                success: function(data)
                                {
                                    $('.inbox-button').empty();
                                    $('#inbox-block').removeClass('loading');
                                }
                            }
                        )
                    });
                }
            }
        );
    });

    if ($(select_on_page_array).is('#tactic-select'))
    //Загрузка страницы такстики
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
            var select_value = $(role_select_array[i]).parent().parent().find('.position-select').val();
            var role_name    = $('option:selected',role_select_array[i]).text();
            var role_value   = $(role_select_array[i]).val();

            $('#tactic-role-' + select_value).text(role_name);

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

        $.ajax
        (
            {
                beforeSend: function(){$('#tactic-block').addClass('loading');},
                url: 'json.php?style_id=' + style_id,
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

        $.ajax
        (
            {
                beforeSend: function(){$('#tactic-block').addClass('loading');},
                url: 'json.php?mood_id=' + mood_id,
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

        var captain_id = $(this).data('id');
        var player_id  = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#player-block').addClass('loading');},
                url: 'json.php?captain_id=' + captain_id + '&player_id=' + player_id,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#player-block').removeClass('loading');
                    }
                }
            }
        );
    });

    $('.training-position').on('change', function()
    //Тренировка новой позиции
    {
        var player_id   = $(this).data('player');
        var position_id = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#training-block').addClass('loading');},
                url: 'json.php?training_position_id=' + position_id + '&player_id=' + player_id,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#training-block').removeClass('loading');
                    }
                }
            }
        );
    });

    $('.training-attribute').on('change', function()
    //Тренировка характеристики игока
    {
        var player_id   = $(this).data('player');
        var attribute_id = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#training-block').addClass('loading');},
                url: 'json.php?training_attribute_id=' + attribute_id + '&player_id=' + player_id,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#training-block').removeClass('loading');
                    }
                }
            }
        );
    });

    $('.training-intensity').on('change', function()
    //Тренировка характеристики игока
    {
        var player_id = $(this).data('player');
        var intensity = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#training-block').addClass('loading');},
                url: 'json.php?training_intensity=' + intensity + '&player_id=' + player_id,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#training-block').removeClass('loading');
                    }
                }
            }
        );
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

        var penalty_id = $(this).data('id');
        var player_id  = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#player-block').addClass('loading');},
                url: 'json.php?penalty_id=' + penalty_id + '&player_id=' + player_id,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#player-block').removeClass('loading');
                    }
                }
            }
        );
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

        var standard_id     = $(this).data('id');
        var player_id       = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#corner-block').addClass('loading');},
                url: 'json.php?corner_left=' + standard_id + '&player_id=' + player_id,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#corner-block').removeClass('loading');
                    }
                }
            }
        );
    });

    $('.select-corner-right').on('change', function()
    //Выбор исполнителей стандартов
    {
        corner_right_select();

        var standard_id     = $(this).data('id');
        var player_id       = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#corner-block').addClass('loading');},
                url: 'json.php?corner_right=' + standard_id + '&player_id=' + player_id,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#corner-block').removeClass('loading');
                    }
                }
            }
        );
    });

    $('.select-freekick-left').on('change', function()
    //Выбор исполнителей стандартов
    {
        freekick_left_select();

        var standard_id     = $(this).data('id');
        var player_id       = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#freekick-block').addClass('loading');},
                url: 'json.php?freekick_left=' + standard_id + '&player_id=' + player_id,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#freekick-block').removeClass('loading');
                    }
                }
            }
        );
    });

    $('.select-freekick-right').on('change', function()
    //Выбор исполнителей стандартов
    {
        freekick_right_select();

        var standard_id     = $(this).data('id');
        var player_id       = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#freekick-block').addClass('loading');},
                url: 'json.php?freekick_right=' + standard_id + '&player_id=' + player_id,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#freekick-block').removeClass('loading');
                    }
                }
            }
        );
    });

    $('.select-out-left').on('change', function()
    //Выбор исполнителей стандартов
    {
        out_left_select();

        var standard_id     = $(this).data('id');
        var player_id       = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#out-block').addClass('loading');},
                url: 'json.php?out_left=' + standard_id + '&player_id=' + player_id,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#out-block').removeClass('loading');
                    }
                }
            }
        );
    });

    $('.select-out-right').on('change', function()
    //Выбор исполнителей стандартов
    {
        out_right_select();

        var standard_id     = $(this).data('id');
        var player_id       = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#out-block').addClass('loading');},
                url: 'json.php?out_right=' + standard_id + '&player_id=' + player_id,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#out-block').removeClass('loading');
                    }
                }
            }
        );
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

    $('.status-national').on('change', function()
    //Изменение трансферного статуса
    {
        var player_id   = $(this).data('player');
        var status      = $(this).val();

        $.ajax
        (
            {
                beforeSend: function(){$('#national-info').addClass('loading');},
                url: 'json.php?player_id=' + player_id + '&statusnational_id=' + status,
                dataType: "json",
                success: function(data)
                {
                    if (1 == data.success)
                    {
                        $('#national-info').removeClass('loading');
                    }
                }
            }
        );
    });

    if ($(select_on_page_array).is('.player-number'))
    //Загрузка номеров игроков
    {
        player_number();
    }

    $('.player-number').on('change', function()
    //Смена номера игрока
    {
        $('#player-info').addClass('loading');

        player_number();

        var player_id   = $(this).data('player');
        var number      = $(this).val();

        $.ajax
        (
            {
                url: 'json.php?player_id=' + player_id + '&number=' + number,
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

    $('.instruction-checkbox').on('change', function()
    //Смена командных инкструкций
    {
        $('#instruction-block').addClass('loading');

        var instruction = $(this).val();

        $.ajax
        (
            {
                url: 'json.php?instruction_id=' + instruction,
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
        $('#asktoplay').addClass('loading');

        var shedule_id = $(this).data('shedule');

        $.ajax
        (
            {
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
                            + '</td><td class="center w20"><a href="asktoplay.php?ok='
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
                            + '</td><td class="center w20"><a href="asktoplay.php?ok='
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
});