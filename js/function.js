function asktoplay_delete()
{
    $('.asktoplay-delete').on('click', function()
    //Удаления предложения тов матча
    {
        $('#asktoplay').addClass('loading');

        var delete_id = $(this).data('delete');
        var shedule_id = $(this).data('shedule');

        $.ajax
        (
            {
                url: 'json.php?asktoplay=' + shedule_id + '&delete=' + delete_id,
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
                    $('#asktoplay-date').html(data.shedule_date);
                    $('#asktoplay-table').show();
                    $('#asktoplay').removeClass('loading');

                    asktoplay_delete();
                }
            }
        );
    });
}

function tactic_player_field()
//Построение на поле на странице индивидуальных заданий игрокам
{
    var formation = $('#tactic-player-formation').val();
    formation = parseInt(formation);
    formation--;
    formation = formation_array[formation];

    var field_icon = $('#field-icon');

    $(field_icon).empty();

    for (var i=0; i<formation.length; i++)
    {
        var position = formation[i];
        position = parseInt(position);
        position--;
        var coordinate = coordinate_array[position];
        var icon_width = coordinate[0];
        var icon_length = coordinate[1];
        icon_width = parseInt(icon_width) * 25;
        icon_length = parseInt(icon_length) * 11 + 3;
        position = position_array[position];
        var icon_img = '<table class="w1" style="position: absolute; top: ' + icon_width + 'px; left: ' + icon_length + 'px;">' +
            '<tr>' +
            '<td class="center">' +
            '<a href="javascript:;" class="player-tactic-shirt" data-position="' + position[0] + '">' +
            '<img alt="" class="img-20" src="/img/shirt.png" />' +
            '</a>' +
            '</td>' +
            '</tr>' +
            '</table>';

        $(field_icon).append(icon_img);
    }
}

function tactic_player_field_national()
//Построение на поле на странице индивидуальных заданий игрокам в сборной
{
    var formation = $('#tactic-player-formation-national').val();
    formation = parseInt(formation);
    formation--;
    formation = formation_array[formation];

    var field_icon = $('#field-icon');

    $(field_icon).empty();

    for (var i=0; i<formation.length; i++)
    {
        var position = formation[i];
        position = parseInt(position);
        position--;
        var coordinate = coordinate_array[position];
        var icon_width = coordinate[0];
        var icon_length = coordinate[1];
        icon_width = parseInt(icon_width) * 25;
        icon_length = parseInt(icon_length) * 11 + 3;
        position = position_array[position];
        var icon_img = '<table class="w1" style="position: absolute; top: ' + icon_width + 'px; left: ' + icon_length + 'px;">' +
            '<tr>' +
            '<td class="center">' +
            '<a href="javascript:;" class="player-tactic-shirt-national" data-position="' + position[0] + '">' +
            '<img alt="" class="img-20" src="/img/shirt.png" />' +
            '</a>' +
            '</td>' +
            '</tr>' +
            '</table>';

        $(field_icon).append(icon_img);
    }
}

function tactic_name(player_select)
//Выбор игроков в стартовый состав
{
    var position_to_role    = position_to_role_array[$(player_select).val()];
    var role_select_array   = role_array[position_to_role];
    var role_select         = '';

    for (var j=0; j<role_select_array.length; j++)
    {
        role_select = role_select + '<option value="' + role_select_array[j][0] + '">' + role_select_array[j][1] + '</option>';
    }

    $(player_select).parent().parent().find('.role-select').empty();
    $(player_select).parent().parent().find('.role-select').html(role_select);

    var input_hidden = $('.hidden');

    for (i=0; i<input_hidden.length; i++)
    {
        $(input_hidden[i]).val('');
    }

    var player_select_array = $('.position-select');

    var select_value_array = [];

    for (i=0; i<player_select_array.length; i++)
    {
        var select_value    = $(player_select_array[i]).val();
        var player_id       = $(player_select_array[i]).data('id');
        var select_array    = $('option', player_select_array[i]);
        var selected_item   = $('option:selected', player_select_array[i]);
        var select_index    = select_array.index(selected_item);

        if (0 < select_index)
        {
            var role_value = $(player_select_array[i]).parent().parent().find('.role-select').val();

            $('#input-position-' + select_index).val(select_value);
            $('#input-player-' + select_index).val(player_id);
            $('#input-role-' + select_index).val(role_value);
        }

        select_value_array.push(select_value);
    }

    role_select_array = $('.role-select');

    for (i=0; i<role_select_array.length; i++)
    {
        select_value = $(role_select_array[i]).parent().parent().find('.position-select').val();
    }

    var player_option_array = $('.position-option');

    for (i=0; i<player_option_array.length; i++)
    {
        $(player_option_array[i]).show();

        var option_value = $(player_option_array[i]).val();

        if (-1 != $.inArray(option_value, select_value_array) &&
            0 != option_value)
        {
            $(player_option_array[i]).hide();
        }
    }
}

function tactic_field()
//Изменение положения футболок на поле при отправке состава
{
    var input_hidden = $('.hidden');

    for (i=0; i<input_hidden.length; i++)
    {
        $(input_hidden[i]).val('');
    }

    var formation = $('#tactic-select').val();
    formation = parseInt(formation);
    formation--;
    formation = formation_array[formation];

    var position_select_array = $('.position-select');
    var field_icon            = $('#field-icon');
    var role_select_array     = $('.role-select');

    $(field_icon).empty();
    $(position_select_array).html('<option value="0">-</option>');
    $(role_select_array).html('<option value="0">-</option>');

    for (var i=0; i<formation.length; i++)
    {
        var position    = formation[i];
        position        = parseInt(position);
        position--;
        var coordinate  = coordinate_array[position];
        var icon_width  = coordinate[0];
        var icon_length = coordinate[1];
        icon_width      = parseInt(icon_width) * 25;
        icon_length     = parseInt(icon_length) * 11 + 107;
        position        = position_array[position];
        var icon_img    = '<table class="w100p" style="position: absolute; top: '
                        + icon_width
                        + 'px; left: '
                        + icon_length
                        + 'px;">'
                        + '<tr><td class="center"><img alt="" class="img-20" src="/img/shirt.png" /></td></tr></table>';

        $(field_icon).append(icon_img);
        $(position_select_array).append('<option value="' + position[0] + '" class="position-option">' + position[1] + '</option>');
    }

    for (i=0; i<substitution_array.length; i++)
    {
        $(position_select_array).append('<option value="' + substitution_array[i][0] + '" class="position-option">' + substitution_array[i][1] + '</option>');
    }

    for (i=0; i<position_select_array.length; i++)
    {
        var data_position = $(position_select_array[i]).data('position');

        if ('' != data_position)
        {
            $(position_select_array[i]).find('[value=' + data_position + ']').prop('selected', true);
            tactic_name(position_select_array[i]);
        }
    }

    for (i=0; i<role_select_array.length; i++)
    {
        var data_role = $(role_select_array[i]).data('role');

        if ('' != data_role)
        {
            $(role_select_array[i]).find('[value=' + data_role + ']').prop('selected', true);
        }
    }
}

function penalty_select()
//Выбор исполнителей пенальти команды
{
    var count_player = player_array.length;
    var selected = '';

    var select_penalty_1 = parseInt($('#select-penalty-1').val());
    var select_penalty_2 = parseInt($('#select-penalty-2').val());
    var select_penalty_3 = parseInt($('#select-penalty-3').val());
    var select_penalty_4 = parseInt($('#select-penalty-4').val());
    var select_penalty_5 = parseInt($('#select-penalty-5').val());
    var select_penalty_6 = parseInt($('#select-penalty-6').val());
    var select_penalty_7 = parseInt($('#select-penalty-7').val());

    var option_1 = '<option value="0">-</option>';
    var option_2 = '<option value="0">-</option>';
    var option_3 = '<option value="0">-</option>';
    var option_4 = '<option value="0">-</option>';
    var option_5 = '<option value="0">-</option>';
    var option_6 = '<option value="0">-</option>';
    var option_7 = '<option value="0">-</option>';

    for (var i=0; i<count_player; i++)
    {
        if (-1 == $.inArray(player_array[i][0], [select_penalty_2, select_penalty_3, select_penalty_4, select_penalty_5, select_penalty_6, select_penalty_7]))
        {
            if (select_penalty_1 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_1 = option_1 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_penalty_1, select_penalty_3, select_penalty_4, select_penalty_5, select_penalty_6, select_penalty_7]))
        {
            if (select_penalty_2 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_2 = option_2 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_penalty_1, select_penalty_2, select_penalty_4, select_penalty_5, select_penalty_6, select_penalty_7]))
        {
            if (select_penalty_3 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_3 = option_3 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_penalty_1, select_penalty_2, select_penalty_3, select_penalty_5, select_penalty_6, select_penalty_7]))
        {
            if (select_penalty_4 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_4 = option_4 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_penalty_1, select_penalty_2, select_penalty_3, select_penalty_4, select_penalty_6, select_penalty_7]))
        {
            if (select_penalty_5 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_5 = option_5 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_penalty_1, select_penalty_2, select_penalty_3, select_penalty_4, select_penalty_5, select_penalty_7]))
        {
            if (select_penalty_6 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_6 = option_6 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_penalty_1, select_penalty_2, select_penalty_3, select_penalty_4, select_penalty_5, select_penalty_6]))
        {
            if (select_penalty_7 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_7 = option_7 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }
    }

    $('#select-penalty-1').html(option_1);
    $('#select-penalty-2').html(option_2);
    $('#select-penalty-3').html(option_3);
    $('#select-penalty-4').html(option_4);
    $('#select-penalty-5').html(option_5);
    $('#select-penalty-6').html(option_6);
    $('#select-penalty-7').html(option_7);
}

function captain_select()
//Выбор капитана команды
{
    var count_player = player_array.length;
    var selected = '';

    var select_captain_1 = parseInt($('#select-captain-1').val());
    var select_captain_2 = parseInt($('#select-captain-2').val());
    var select_captain_3 = parseInt($('#select-captain-3').val());
    var select_captain_4 = parseInt($('#select-captain-4').val());
    var select_captain_5 = parseInt($('#select-captain-5').val());

    var option_1 = '<option value="0">-</option>';
    var option_2 = '<option value="0">-</option>';
    var option_3 = '<option value="0">-</option>';
    var option_4 = '<option value="0">-</option>';
    var option_5 = '<option value="0">-</option>';

    for (var i=0; i<count_player; i++)
    {
        if (-1 == $.inArray(player_array[i][0], [select_captain_2, select_captain_3, select_captain_4, select_captain_5]))
        {
            if (select_captain_1 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_1 = option_1 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_captain_1, select_captain_3, select_captain_4, select_captain_5]))
        {
            if (select_captain_2 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_2 = option_2 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_captain_1, select_captain_2, select_captain_4, select_captain_5]))
        {
            if (select_captain_3 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_3 = option_3 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_captain_1, select_captain_2, select_captain_3, select_captain_5]))
        {
            if (select_captain_4 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_4 = option_4 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_captain_1, select_captain_2, select_captain_3, select_captain_4]))
        {
            if (select_captain_5 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_5 = option_5 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }
    }

    $('#select-captain-1').html(option_1);
    $('#select-captain-2').html(option_2);
    $('#select-captain-3').html(option_3);
    $('#select-captain-4').html(option_4);
    $('#select-captain-5').html(option_5);
}

function corner_left_select()
//Выбор исполнителя левого углового команды
{
    var count_player = player_array.length;
    var selected = '';

    var select_corner_1 = parseInt($('#select-corner-left-1').val());
    var select_corner_2 = parseInt($('#select-corner-left-2').val());
    var select_corner_3 = parseInt($('#select-corner-left-3').val());
    var select_corner_4 = parseInt($('#select-corner-left-4').val());
    var select_corner_5 = parseInt($('#select-corner-left-5').val());

    var option_1 = '<option value="0">-</option>';
    var option_2 = '<option value="0">-</option>';
    var option_3 = '<option value="0">-</option>';
    var option_4 = '<option value="0">-</option>';
    var option_5 = '<option value="0">-</option>';

    for (var i=0; i<count_player; i++)
    {
        if (-1 == $.inArray(player_array[i][0], [select_corner_2, select_corner_3, select_corner_4, select_corner_5]))
        {
            if (select_corner_1 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_1 = option_1 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_corner_1, select_corner_3, select_corner_4, select_corner_5]))
        {
            if (select_corner_2 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_2 = option_2 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_corner_1, select_corner_2, select_corner_4, select_corner_5]))
        {
            if (select_corner_3 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_3 = option_3 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_corner_1, select_corner_2, select_corner_3, select_corner_5]))
        {
            if (select_corner_4 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_4 = option_4 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_corner_1, select_corner_2, select_corner_3, select_corner_4]))
        {
            if (select_corner_5 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_5 = option_5 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }
    }

    $('#select-corner-left-1').html(option_1);
    $('#select-corner-left-2').html(option_2);
    $('#select-corner-left-3').html(option_3);
    $('#select-corner-left-4').html(option_4);
    $('#select-corner-left-5').html(option_5);
}

function corner_right_select()
//Выбор исполнителя правого углового команды
{
    var count_player = player_array.length;
    var selected = '';

    var select_corner_1 = parseInt($('#select-corner-right-1').val());
    var select_corner_2 = parseInt($('#select-corner-right-2').val());
    var select_corner_3 = parseInt($('#select-corner-right-3').val());
    var select_corner_4 = parseInt($('#select-corner-right-4').val());
    var select_corner_5 = parseInt($('#select-corner-right-5').val());

    var option_1 = '<option value="0">-</option>';
    var option_2 = '<option value="0">-</option>';
    var option_3 = '<option value="0">-</option>';
    var option_4 = '<option value="0">-</option>';
    var option_5 = '<option value="0">-</option>';

    for (var i=0; i<count_player; i++)
    {
        if (-1 == $.inArray(player_array[i][0], [select_corner_2, select_corner_3, select_corner_4, select_corner_5]))
        {
            if (select_corner_1 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_1 = option_1 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_corner_1, select_corner_3, select_corner_4, select_corner_5]))
        {
            if (select_corner_2 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_2 = option_2 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_corner_1, select_corner_2, select_corner_4, select_corner_5]))
        {
            if (select_corner_3 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_3 = option_3 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_corner_1, select_corner_2, select_corner_3, select_corner_5]))
        {
            if (select_corner_4 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_4 = option_4 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_corner_1, select_corner_2, select_corner_3, select_corner_4]))
        {
            if (select_corner_5 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_5 = option_5 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }
    }

    $('#select-corner-right-1').html(option_1);
    $('#select-corner-right-2').html(option_2);
    $('#select-corner-right-3').html(option_3);
    $('#select-corner-right-4').html(option_4);
    $('#select-corner-right-5').html(option_5);
}

function freekick_left_select()
//Выбор исполнителя левого штрафного команды
{
    var count_player = player_array.length;
    var selected = '';

    var select_freekick_1 = parseInt($('#select-freekick-left-1').val());
    var select_freekick_2 = parseInt($('#select-freekick-left-2').val());
    var select_freekick_3 = parseInt($('#select-freekick-left-3').val());
    var select_freekick_4 = parseInt($('#select-freekick-left-4').val());
    var select_freekick_5 = parseInt($('#select-freekick-left-5').val());

    var option_1 = '<option value="0">-</option>';
    var option_2 = '<option value="0">-</option>';
    var option_3 = '<option value="0">-</option>';
    var option_4 = '<option value="0">-</option>';
    var option_5 = '<option value="0">-</option>';

    for (var i=0; i<count_player; i++)
    {
        if (-1 == $.inArray(player_array[i][0], [select_freekick_2, select_freekick_3, select_freekick_4, select_freekick_5]))
        {
            if (select_freekick_1 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_1 = option_1 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_freekick_1, select_freekick_3, select_freekick_4, select_freekick_5]))
        {
            if (select_freekick_2 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_2 = option_2 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_freekick_1, select_freekick_2, select_freekick_4, select_freekick_5]))
        {
            if (select_freekick_3 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_3 = option_3 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_freekick_1, select_freekick_2, select_freekick_3, select_freekick_5]))
        {
            if (select_freekick_4 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_4 = option_4 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_freekick_1, select_freekick_2, select_freekick_3, select_freekick_4]))
        {
            if (select_freekick_5 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_5 = option_5 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }
    }

    $('#select-freekick-left-1').html(option_1);
    $('#select-freekick-left-2').html(option_2);
    $('#select-freekick-left-3').html(option_3);
    $('#select-freekick-left-4').html(option_4);
    $('#select-freekick-left-5').html(option_5);
}

function freekick_right_select()
//Выбор исполнителя правого штрафного команды
{
    var count_player = player_array.length;
    var selected = '';

    var select_freekick_1 = parseInt($('#select-freekick-right-1').val());
    var select_freekick_2 = parseInt($('#select-freekick-right-2').val());
    var select_freekick_3 = parseInt($('#select-freekick-right-3').val());
    var select_freekick_4 = parseInt($('#select-freekick-right-4').val());
    var select_freekick_5 = parseInt($('#select-freekick-right-5').val());

    var option_1 = '<option value="0">-</option>';
    var option_2 = '<option value="0">-</option>';
    var option_3 = '<option value="0">-</option>';
    var option_4 = '<option value="0">-</option>';
    var option_5 = '<option value="0">-</option>';

    for (var i=0; i<count_player; i++)
    {
        if (-1 == $.inArray(player_array[i][0], [select_freekick_2, select_freekick_3, select_freekick_4, select_freekick_5]))
        {
            if (select_freekick_1 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_1 = option_1 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_freekick_1, select_freekick_3, select_freekick_4, select_freekick_5]))
        {
            if (select_freekick_2 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_2 = option_2 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_freekick_1, select_freekick_2, select_freekick_4, select_freekick_5]))
        {
            if (select_freekick_3 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_3 = option_3 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_freekick_1, select_freekick_2, select_freekick_3, select_freekick_5]))
        {
            if (select_freekick_4 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_4 = option_4 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_freekick_1, select_freekick_2, select_freekick_3, select_freekick_4]))
        {
            if (select_freekick_5 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_5 = option_5 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }
    }

    $('#select-freekick-right-1').html(option_1);
    $('#select-freekick-right-2').html(option_2);
    $('#select-freekick-right-3').html(option_3);
    $('#select-freekick-right-4').html(option_4);
    $('#select-freekick-right-5').html(option_5);
}

function out_left_select()
//Выбор исполнителя левого аута команды
{
    var count_player = player_array.length;
    var selected = '';

    var select_out_1 = parseInt($('#select-out-left-1').val());
    var select_out_2 = parseInt($('#select-out-left-2').val());
    var select_out_3 = parseInt($('#select-out-left-3').val());
    var select_out_4 = parseInt($('#select-out-left-4').val());
    var select_out_5 = parseInt($('#select-out-left-5').val());

    var option_1 = '<option value="0">-</option>';
    var option_2 = '<option value="0">-</option>';
    var option_3 = '<option value="0">-</option>';
    var option_4 = '<option value="0">-</option>';
    var option_5 = '<option value="0">-</option>';

    for (var i=0; i<count_player; i++)
    {
        if (-1 == $.inArray(player_array[i][0], [select_out_2, select_out_3, select_out_4, select_out_5]))
        {
            if (select_out_1 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_1 = option_1 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_out_1, select_out_3, select_out_4, select_out_5]))
        {
            if (select_out_2 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_2 = option_2 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_out_1, select_out_2, select_out_4, select_out_5]))
        {
            if (select_out_3 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_3 = option_3 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_out_1, select_out_2, select_out_3, select_out_5]))
        {
            if (select_out_4 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_4 = option_4 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_out_1, select_out_2, select_out_3, select_out_4]))
        {
            if (select_out_5 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_5 = option_5 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }
    }

    $('#select-out-left-1').html(option_1);
    $('#select-out-left-2').html(option_2);
    $('#select-out-left-3').html(option_3);
    $('#select-out-left-4').html(option_4);
    $('#select-out-left-5').html(option_5);
}

function out_right_select()
//Выбор исполнителя правого аута команды
{
    var count_player = player_array.length;
    var selected = '';

    var select_out_1 = parseInt($('#select-out-right-1').val());
    var select_out_2 = parseInt($('#select-out-right-2').val());
    var select_out_3 = parseInt($('#select-out-right-3').val());
    var select_out_4 = parseInt($('#select-out-right-4').val());
    var select_out_5 = parseInt($('#select-out-right-5').val());

    var option_1 = '<option value="0">-</option>';
    var option_2 = '<option value="0">-</option>';
    var option_3 = '<option value="0">-</option>';
    var option_4 = '<option value="0">-</option>';
    var option_5 = '<option value="0">-</option>';

    for (var i=0; i<count_player; i++)
    {
        if (-1 == $.inArray(player_array[i][0], [select_out_2, select_out_3, select_out_4, select_out_5]))
        {
            if (select_out_1 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_1 = option_1 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_out_1, select_out_3, select_out_4, select_out_5]))
        {
            if (select_out_2 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_2 = option_2 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_out_1, select_out_2, select_out_4, select_out_5]))
        {
            if (select_out_3 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_3 = option_3 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_out_1, select_out_2, select_out_3, select_out_5]))
        {
            if (select_out_4 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_4 = option_4 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }

        if (-1 == $.inArray(player_array[i][0], [select_out_1, select_out_2, select_out_3, select_out_4]))
        {
            if (select_out_5 == player_array[i][0])
            {
                selected = 'selected';
            }
            else
            {
                selected = '';
            }

            option_5 = option_5 + '<option value="' + player_array[i][0] + '" ' + selected + '>' + player_array[i][1] + '</option>';
        }
    }

    $('#select-out-right-1').html(option_1);
    $('#select-out-right-2').html(option_2);
    $('#select-out-right-3').html(option_3);
    $('#select-out-right-4').html(option_4);
    $('#select-out-right-5').html(option_5);
}

var formation_array =
[
    [1,2,5,7,10,16,19,21,27,33,35],
    [1,2,5,7,10,13,16,19,21,33,35],
    [1,4,6,8,10,12,14,16,24,30,34],
    [1,4,6,8,17,19,21,23,32,34,36],
    [1,4,6,8,13,17,23,27,32,34,36],
    [1,4,6,8,17,18,20,22,23,33,35],
    [1,4,6,8,10,12,14,16,26,28,34],
    [1,3,5,7, 9,13,19,21,27,33,35],
    [1,3,5,7, 9,13,18,20,22,33,35],
    [1,3,5,7, 9,13,17,19,21,23,34],
    [1,3,5,7, 9,12,14,19,21,33,35],
    [1,3,5,7, 9,19,21,25,27,29,34],
    [1,3,5,7, 9,13,17,22,25,30,34],
    [1,3,5,7, 9,12,14,24,27,30,34],
    [1,3,5,7, 9,18,20,22,27,33,35],
    [1,3,5,7, 9,17,20,23,26,28,34],
    [1,3,5,7, 9,18,20,22,32,34,36],
    [1,3,5,7, 9,17,19,21,23,27,34],
    [1,3,5,7, 9,17,19,21,23,33,35],
    [1,3,5,7, 9,13,17,23,27,33,35],
    [1,3,5,7, 9,13,19,21,24,30,34],
    [1,3,4,6, 8, 9,18,20,22,33,35],
    [1,3,4,6, 8, 9,17,19,21,23,34]
];

var coordinate_array =
[
    [7,7],
    [6,7],
    [5,13],
    [5,10],
    [5,9],
    [5,7],
    [5,5],
    [5,4],
    [5,1],
    [4,13],
    [4,10],
    [4,9],
    [4,7],
    [4,5],
    [4,4],
    [4,1],
    [3,13],
    [3,10],
    [3,9],
    [3,7],
    [3,5],
    [3,4],
    [3,1],
    [2,13],
    [2,10],
    [2,9],
    [2,7],
    [2,5],
    [2,4],
    [2,1],
    [1,13],
    [1,10],
    [1,9],
    [1,7],
    [1,5],
    [1,4],
    [1,1],
    [7,19],
    [6,19],
    [5,19],
    [4,19],
    [3,19],
    [2,19],
    [1,19]
];

var position_array =
[
    [1,'В'],
    [2,'Ч'],
    [3,'ЗП'],
    [4,'ЗЦ'],
    [4,'ЗЦ'],
    [5,'ЗЦ'],
    [6,'ЗЦ'],
    [6,'ЗЦ'],
    [7,'ЗЛ'],
    [8,'КЗП'],
    [9,'ОП'],
    [9,'ОП'],
    [10,'ОП'],
    [11,'ОП'],
    [11,'ОП'],
    [12,'КЗЛ'],
    [13,'ПП'],
    [14,'ПЦ'],
    [14,'ПЦ'],
    [15,'ПЦ'],
    [16,'ПЦ'],
    [16,'ПЦ'],
    [17,'ПЛ'],
    [18,'АПП'],
    [19,'АПЦ'],
    [19,'АПЦ'],
    [20,'АПЦ'],
    [21,'АПЦ'],
    [21,'АПЦ'],
    [22,'АПЛ'],
    [24,'НП'],
    [23,'НП'],
    [23,'НП'],
    [24,'НП'],
    [25,'НП'],
    [25,'НП'],
    [24,'НП']
];

var substitution_array =
[
    [26, 'З1'],
    [27, 'З2'],
    [28, 'З3'],
    [29, 'З4'],
    [30, 'З5'],
    [31, 'З6'],
    [32, 'З7']
];

var position_to_role_array = [0, 1, 2, 3, 4, 4, 4, 3, 5, 6, 6, 6, 5, 7, 8, 8, 8, 7, 9, 10, 10, 10, 9, 11, 11, 11, 0, 0, 0, 0, 0, 0, 0];

var role_array =
[
    [[0, '-']],
    [[1, 'ВР'], [2, 'ВЧ']],
    [[3, 'ЛБ'], [4, 'ЧСТ']],
    [[5, 'ФЗ'], [6, 'КЗ'], [7, 'ОФЗ'], [8, 'УКЗ']],
    [[9, 'ЦЗ'], [10, 'СЗ'], [11, 'ЧЗ']],
    [[6, 'КЗ'], [8, 'УКЗ']],
    [[12, 'ОП'], [13, 'ОПЛ'], [14, 'МОП'], [15, 'СИ'], [16, 'ХБ'], [17, 'РЖД']],
    [[18, 'ФП'], [19, 'КП'], [20, 'КПО']],
    [[21, 'ЦП'], [13, 'ОПЛ'], [22, 'СвП'], [23, 'ВПЛ'], [14, 'МОП']],
    [[19, 'КП'], [23, 'ВПЛ'], [24, 'ОВП'], [20, 'КПО'], [25, 'ФТМ']],
    [[26, 'АП'], [23, 'ВПЛ'], [27, 'СвХ'], [28, 'ЭНГ'], [29, 'ТНП']],
    [[30, 'ФГ'], [31, 'ЧФ'], [32, 'ТГМ'], [33, 'СкН'], [34, 'УН'], [35, 'НОО'], [36, 'ЛД']]
];