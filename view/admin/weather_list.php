<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Погода</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="weather_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Погода</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$weather_array}
                    <tr>
                        <td class="left">{$weather_array[i].weather_name}</td>
                        <td>
                            <a href="weather_edit.php?num={$weather_array[i].weather_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>