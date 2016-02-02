<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Страны ({$count_country})</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="continent_list.php" class="link-img link-list"></a>
                <a href="country_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th colspan="2">Страна</th>
                    <th>Городов</th>
                    <th>Команд</th>
                    <th>Континент</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$country_array}
                    <tr>
                        <td>
                            <img alt="" src="/img/flag/12/{$country_array[i].country_id}.png" class="img-12"/>
                        </td>
                        <td class="left">
                            <a href="country.php?num={$country_array[i].country_id}">
                                {$country_array[i].country_name}
                            </a>
                        </td>
                        <td>
                            <a href="city_list.php?country_id={$country_array[i].country_id}">
                                {$country_array[i].count_city}
                            </a>
                        </td>
                        <td>
                            <a href="team_list.php?country_id={$country_array[i].country_id}">
                                {$country_array[i].count_team}
                            </a>
                        </td>
                        <td class="left">
                            <a href="continent.php?num={$country_array[i].continent_id}">
                                {$country_array[i].continent_name}
                            </a>
                        </td>
                        <td>
                            <a href="country_edit.php?num={$country_array[i].country_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>