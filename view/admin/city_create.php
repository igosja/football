<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование города</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="city_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Страна</td>
                        <td>
                            <select name="country_id">
                                {section name=i loop=$country_array}
                                    <option value="{$country_array[i].country_id}"
                                        {if (isset($country_id) && $country_id == $country_array[i].country_id)}
                                            selected
                                        {/if}
                                    >
                                        {$country_array[i].country_name}
                                    </option>
                                {/section}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Город</td>
                        <td>
                            <input name="city_name" type="text" value="{if (isset($city_name))}{$city_name}{/if}"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Сохранить"/>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>