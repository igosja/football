<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Типы травм</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="injurytype_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Тип</th>
                    <th>Длительность</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$injurytype_array}
                    <tr>
                        <td>{$injurytype_array[i].injurytype_name}</td>
                        <td class="center">{$injurytype_array[i].injurytype_day}</td>
                        <td>
                            <a href="injurytype_edit.php?num={$injurytype_array[i].injurytype_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>