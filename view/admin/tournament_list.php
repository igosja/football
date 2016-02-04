<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Турниры</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="tournamenttype_list.php" class="link-img link-list"></a>
                <a href="tournament_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Турнир</th>
                    <th>Тип</th>
                    <th>Уровень</th>
                    <th>Страна</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$tournament_array}
                    <tr>
                        <td>
                            <img alt="" src="../img/tournament/12/{$tournament_array[i].tournament_id}.png" class="img-12"/>
                            {$tournament_array[i].tournament_name}
                        </td>
                        <td>
                            {$tournament_array[i].tournamenttype_name}
                        </td>
                        <td>
                            {$tournament_array[i].tournament_level}
                        </td>
                        <td>
                            {$tournament_array[i].country_name}
                        </td>
                        <td>
                            <a href="tournament_edit.php?num={$tournament_array[i].tournament_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>