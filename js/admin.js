$(document).ready(function($)
{
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
});