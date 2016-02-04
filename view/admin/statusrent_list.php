<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Арендный статус</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="statusrent_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Название</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$statusrent_array}
                    <tr>
                        <td>
                            <a href="statusrent.php?num={$statusrent_array[i].statusrent_id}">
                                {$statusrent_array[i].statusrent_name}
                            </a>
                        </td>
                        <td>
                            <a href="statusrent_edit.php?num={$statusrent_array[i].statusrent_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>