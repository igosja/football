<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Города</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="country_list.php" class="link-img link-list"></a>
                <a href="city_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Город</th>
                    <th>Команд</th>
                    <th colspan="2">Страна</th>
                    <th>Континент</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$city_array}
                    <tr>
                        <td>
                            <a href="city.php?num={$city_array[i].city_id}">
                                {$city_array[i].city_name}
                            </a>
                        </td>
                        <td>
                            <a href="team_list.php?num={$city_array[i].city_id}">
                                {$city_array[i].count_team}
                            </a>
                        </td>
                        <td>
                            <img alt="" src="/img/flag/12/{$city_array[i].country_id}.png" class="img-12"/>
                        </td>
                        <td>
                            <a href="continent.php?num={$city_array[i].country_id}">
                                {$city_array[i].country_name}
                            </a>
                        </td>
                        <td>
                            <a href="continent.php?num={$city_array[i].continent_id}">
                                {$city_array[i].continent_name}
                            </a>
                        </td>
                        <td>
                            <a href="city_edit.php?num={$city_array[i].city_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>