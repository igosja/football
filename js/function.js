﻿function player_number()
//Смена командных номеров
{
    var select_array = $('.player-number');
    var value_array  = [];
    var selected     = '';

    for (var i=0; i<select_array.length; i++)
    {
        value_array.push(parseInt($(select_array[i]).val()));
    }

    for (var i=0; i<select_array.length; i++)
    {
        var select_value = $(select_array[i]).val();

        $(select_array[i]).empty();
        $(select_array[i]).append('<option value="0">-</option>');

        for (var j=1; j<100; j++)
        {
            if (-1 == $.inArray(j, value_array) ||
                j == select_value)
            {
                if (j == select_value)
                {
                    selected = ' selected';
                }
                else
                {
                    selected = '';
                }

                $(select_array[i]).append('<option value="' + j + '"' + selected + '>' + j + '</option>');
            }
        }
    }
}

function tactic_player_field()
//Построение на поле на странице индивидуальных заданий игрокам
{
    var formation = $('#tactic-player-formation').val();
    formation = parseInt(formation);
    formation--;
    formation = formation_array[formation];

    var field_icon            = $('#field-icon');

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
            '<img alt="" class="img-20" src="img/shirt.png" />' +
            '</a>' +
            '</td>' +
            '</tr>' +
            '</table>';

        $(field_icon).append(icon_img);
    }
}

function tournament_type()
//Создание турнира в админке
{
    var tournament_value = $("#tournament-type").val();

    if (2 == tournament_value)
    {
        $('#tournament-name').show();
        $('#tournament-member').show();
        $('#tournament-level').show();
    }
    else
    {
        $('#tournament-name').hide();
        $('#tournament-member').hide();
        $('#tournament-level').hide();
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
        role_select = role_select +
            '<option value="' + role_select_array[j][0] + '">' + role_select_array[j][1] + '</option>';
    }

    $(player_select).parent().parent().find('.role-select').empty();
    $(player_select).parent().parent().find('.role-select').html(role_select);

    var player_name_array = $('.tactic-name');

    for (var i=0; i<player_name_array.length; i++)
    {
        $(player_name_array[i]).empty();
    }

    var player_role_array = $('.tactic-role');

    for (i=0; i<player_role_array.length; i++)
    {
        $(player_role_array[i]).empty();
    }

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
        var player_name     = $(player_select_array[i]).data('name');
        var player_id       = $(player_select_array[i]).data('id');
        var select_array    = $('option',player_select_array[i]);
        var selected_item   = $('option:selected',player_select_array[i]);
        var select_index    = select_array.index(selected_item);

        if (0 < select_index)
        {
            var role_value = $(player_select_array[i]).parent().parent().find('.role-select').val();

            $('#input-position-' + select_index).val(select_value);
            $('#input-player-' + select_index).val(player_id);
            $('#input-role-' + select_index).val(role_value);
        }

        select_value_array.push(select_value);

        $('#tactic-name-' + select_value).text(player_name);
    }

    role_select_array = $('.role-select');

    for (i=0; i<role_select_array.length; i++)
    {
        select_value     = $(role_select_array[i]).parent().parent().find('.position-select').val();
        var role_name    = $('option:selected',role_select_array[i]).text();

        $('#tactic-role-' + select_value).text(role_name);
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
        icon_width      = parseInt(icon_width) * 61;
        icon_length     = parseInt(icon_length) * 18 + 3;
        position        = position_array[position];
        var icon_img    = '<table class="w100p" style="position: absolute; top: ' + icon_width + 'px; left: ' + icon_length + 'px;">' +
            '<tr><td class="center" colspan="2"><img alt="" class="img-30" src="img/shirt.png" /></td></tr>' +
            '<tr><td class="center tactic-name white" id="tactic-name-' + position[0] + '"></td></tr>' +
            '<tr><td class="center tactic-role white" id="tactic-role-' + position[0] + '"></td></tr></table>';

        $(field_icon).append(icon_img);
        $(position_select_array).append('<option value="' + position[0] + '" class="position-option">' + position[1] + '</option>');
    }

    for (i=0; i<substitution_array.length; i++)
    {
        var position    = substitution_array[i][0];
        position        = parseInt(position);
        position        = position + 11;
        var coordinate  = coordinate_array[position];
        var icon_width  = coordinate[0];
        var icon_length = coordinate[1];
        icon_width      = parseInt(icon_width) * 61;
        icon_length     = parseInt(icon_length) * 18 + 3;
        position        = substitution_array[i];
        var icon_img    = '<table class="w100p" style="position: absolute; top: ' + icon_width + 'px; left: ' + icon_length + 'px;">' +
            '<tr><td class="center" colspan="2"><img alt="" class="img-30" src="img/shirt.png" /></td></tr>' +
            '<tr><td class="center tactic-name white" id="tactic-name-' + position[0] + '"></td></tr></table>';

        $(field_icon).append(icon_img);
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

    var input_hidden = $('.hidden');

    for (i=0; i<input_hidden.length; i++)
    {
        $(input_hidden[i]).val('');
    }
}

function penalty_select()
//Выбор пенальнистов команды
{
    $('option').show();

    for (var i=1; i<=7; i++) //Всего у нас семь возможных пенальтистов
    {
        var penalty_value = $('#select-penalty-' + i).val();

        if (0 != penalty_value)
        {
            $('option[value=' + penalty_value + ']').hide();
        }
    }
}

function captain_select()
//Выбор капитана команды
{
    $('option').show();

    for (var i=1; i<=5; i++) //Всего у нас пять возможных капитанов
    {
        var captain_value = $('#select-captain-' + i).val();

        if (0 != captain_value)
        {
            $('option[value=' + captain_value + ']').hide();
        }
    }
}

function corner_left_select()
//Выбор исполнителя левого углового команды
{
    $('.select-corner-left option').show();

    for (var i=1; i<=5; i++) //Всего у нас пять возможных исполнителей
    {
        var corner_left_value = $('#select-corner-left-' + i).val();

        if (0 != corner_left_value)
        {
            $('.select-corner-left option[value=' + corner_left_value + ']').hide();
        }
    }
}

function corner_right_select()
//Выбор исполнителя левого углового команды
{
    $('.select-corner-right option').show();

    for (var i=1; i<=5; i++) //Всего у нас пять возможных исполнителей
    {
        var corner_right_value = $('#select-corner-right-' + i).val();

        if (0 != corner_right_value)
        {
            $('.select-corner-right option[value=' + corner_right_value + ']').hide();
        }
    }
}

function freekick_left_select()
//Выбор исполнителя левого углового команды
{
    $('.select-freekick-left option').show();

    for (var i=1; i<=5; i++) //Всего у нас пять возможных исполнителей
    {
        var freekick_left_value = $('#select-freekick-left-' + i).val();

        if (0 != freekick_left_value)
        {
            $('.select-freekick-left option[value=' + freekick_left_value + ']').hide();
        }
    }
}

function freekick_right_select()
//Выбор исполнителя левого углового команды
{
    $('.select-freekick-right option').show();

    for (var i=1; i<=5; i++) //Всего у нас пять возможных исполнителей
    {
        var freekick_right_value = $('#select-freekick-right-' + i).val();

        if (0 != freekick_right_value)
        {
            $('.select-freekick-right option[value=' + freekick_right_value + ']').hide();
        }
    }
}

function out_left_select()
//Выбор исполнителя левого углового команды
{
    $('.select-out-left option').show();

    for (var i=1; i<=5; i++) //Всего у нас пять возможных исполнителей
    {
        var out_left_value = $('#select-out-left-' + i).val();

        if (0 != out_left_value)
        {
            $('.select-out-left option[value=' + out_left_value + ']').hide();
        }
    }
}

function out_right_select()
//Выбор исполнителя левого углового команды
{
    $('.select-out-right option').show();

    for (var i=1; i<=5; i++) //Всего у нас пять возможных исполнителей
    {
        var out_right_value = $('#select-out-right-' + i).val();

        if (0 != out_right_value)
        {
            $('.select-out-right option[value=' + out_right_value + ']').hide();
        }
    }
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
    [5,1],
    [5,4],
    [5,5],
    [5,7],
    [5,9],
    [5,10],
    [5,13],
    [4,1],
    [4,4],
    [4,5],
    [4,7],
    [4,9],
    [4,10],
    [4,13],
    [3,1],
    [3,4],
    [3,5],
    [3,7],
    [3,9],
    [3,10],
    [3,13],
    [2,1],
    [2,4],
    [2,5],
    [2,7],
    [2,9],
    [2,10],
    [2,13],
    [1,1],
    [1,4],
    [1,5],
    [1,7],
    [1,9],
    [1,10],
    [1,13],
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