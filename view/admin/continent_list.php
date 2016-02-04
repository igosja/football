<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Континенты</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="continent_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th colspan="2">Континент</th>
                    <th>Стран</th>
                    <th>Городов</th>
                    <th>Команд</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$continent_array}
                    <tr>
                        <td>
                            <img alt="" src="../img/continent/{$continent_array[i].continent_id}.png" class="img-12"/>
                        </td>
                        <td>
                            <a href="continent.php?num={$continent_array[i].continent_id}">
                                {$continent_array[i].continent_name}
                            </a>
                        </td>
                        <td>
                            <a href="country_list.php?continent_id={$continent_array[i].continent_id}">
                                {$continent_array[i].count_country}
                            </a>
                        </td>
                        <td>
                            <a href="city_list.php?continent_id={$continent_array[i].continent_id}">
                                {$continent_array[i].count_city}
                            </a>
                        </td>
                        <td>
                            <a href="team_list.php?continent_id={$continent_array[i].continent_id}">
                                {$continent_array[i].count_team}
                            </a>
                        </td>
                        <td>
                            <a href="continent_edit.php?num={$continent_array[i].continent_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>