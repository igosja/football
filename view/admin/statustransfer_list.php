<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Трансферный статус</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="statustransfer_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Название</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$statustransfer_array}
                    <tr>
                        <td>
                            <a href="statustransfer.php?num={$statustransfer_array[i].statustransfer_id}">
                                {$statustransfer_array[i].statustransfer_name}
                            </a>
                        </td>
                        <td>
                            <a href="statustransfer_edit.php?num={$statustransfer_array[i].statustransfer_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>