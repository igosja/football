<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Командные рекорды</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="recordteamtype_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Название</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$recordteamtype_array}
                    <tr>
                        <td>
                            <a href="recordteamtype.php?num={$recordteamtype_array[i].recordteamtype_id}">
                                {$recordteamtype_array[i].recordteamtype_name}
                            </a>
                        </td>
                        <td>
                            <a href="recordteamtype_edit.php?num={$recordteamtype_array[i].recordteamtype_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>