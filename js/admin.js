$(document).ready(function ($) {
    var div_on_page_array  = $('div');

    $('#select-ajax-give-1').change(function ()
    //Зависимые селекты
    {
        var ajax_give_2 = $("#select-ajax-give-2");
        var option_selected = $(this).find("option:selected");
        var value_select = $(this).val();
        var give = $(this).attr("data-give");
        var need = $(this).attr("data-need");

        $.ajax
        (
            {
                url: '/json.php?select_value=' + value_select + '&select_give=' + give + '&select_need=' + need,
                dataType: "json",
                success: function (data)
                {
                    var select = '';

                    for (var i = 0; i < data.select_array.length; i++)
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

    if ($(div_on_page_array).is('#index-registration-chart'))
    {
        $('#index-registration-chart').highcharts({
            title: {
                text: 'Регистрации за 2 недели',
                x: -20 //center
            },
            xAxis: {
                categories: registration_date
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Регистрации'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ' чел.'
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Зарегистрировано',
                data: registration_user
            }],
            credits: {
                enabled: false
            }
        });
    }

    if ($(div_on_page_array).is('#index-payment-chart'))
    {
        $('#index-payment-chart').highcharts({
            title: {
                text: 'Платежи на год',
                x: -20 //center
            },
            xAxis: {
                categories: payment_date
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Платежи'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ' руб.'
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Оплаты',
                data: payment_sum
            }],
            credits: {
                enabled: false
            }
        });
    }

    setInterval(get_count_support_message, 60000);
    setInterval(get_count_vote, 60000);
});

function get_count_support_message()
{
    $.ajax
    (
        {
            url: '/admin/json.php?count_support=0',
            dataType: "json",
            success: function (data)
            {
                var count_support = data.count_support;

                if (0 == count_support)
                {
                    count_support = '';
                }

                $('#admin-support-badge').text(count_support);
            }
        }
    );
}

function get_count_vote()
{
    $.ajax
    (
        {
            url: '/admin/json.php?count_vote=0',
            dataType: "json",
            success: function (data)
            {
                var count_vote = data.count_vote;

                if (0 == count_vote)
                {
                    count_vote = '';
                }

                $('#admin-vote-badge').text(count_vote);
            }
        }
    );
}