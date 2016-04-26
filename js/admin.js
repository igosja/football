$(document).ready(function ($) {
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

    $('#highcharts-bar-chart').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Pie chart'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Brands',
            colorByPoint: true,
            data: [{
                name: 'Brand 1',
                y: 10
            }, {
                name: 'Brand 2',
                y: 12
            }, {
                name: 'Brand 3',
                y: 38
            }, {
                name: 'Brand 4',
                y: 25
            }, {
                name: 'Brand 5',
                y: 13
            }]
        }]
    });

    $('#highcharts-line-chart').highcharts({
        title: {
            text: 'График',
            x: -20 //center
        },
        xAxis: {
            title: {
                text: 'Время'
            },
            categories: ['Начало', 'Середина', 'Конец']
        },
        yAxis: {
            title: {
                text: 'Количество'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Первая линия',
            data: [1, 5, 2]
        }, {
            name: 'Вторая линия',
            data: [4, 3, 6]
        }]
    });

    setInterval(get_count_support_message, 60000);
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