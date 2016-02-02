<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование фамилии</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="surname_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Страна</td>
                        <td class="left">
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
                        <td>Фамилии (через "," без пробелов)</td>
                        <td class="left">
                            <textarea
                                class="w100"
                                name="surname_name"
                                rows="5">{if (isset($surname_name))}{$surname_name}{/if}</textarea>
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