<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование страны</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="country_list.php" class="link-img link-list"></a>
            </p>
            <form action="" enctype="multipart/form-data" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Континент</td>
                        <td>
                            <select name="continent_id">
                                {section name=i loop=$continent_array}
                                    <option value="{$continent_array[i].continent_id}"
                                        {if (isset($continent_id) && $continent_id == $continent_array[i].continent_id)}
                                            selected
                                        {/if}
                                    >
                                        {$continent_array[i].continent_name}
                                    </option>
                                {/section}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Страна</td>
                        <td>
                            <input name="country_name" type="text" value="{if (isset($country_name))}{$country_name}{/if}"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Флаг (135x90, png)</td>
                        <td>
                            <input name="country_flag_90" type="file"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Флаг (75x50, png)</td>
                        <td>
                            <input name="country_flag_50" type="file"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Флаг (18x12, png)</td>
                        <td>
                            <input name="country_flag_12" type="file"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Сохранить"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <img src="/img/flag/90/{if (isset($smarty.get.num))}{$smarty.get.num}{/if}.png" />
                            <img src="/img/flag/50/{if (isset($smarty.get.num))}{$smarty.get.num}{/if}.png" />
                            <img src="/img/flag/12/{if (isset($smarty.get.num))}{$smarty.get.num}{/if}.png" />
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>