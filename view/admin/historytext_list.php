<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Варианты действий</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="historytext_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Вариант</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$historytext_array}
                    <tr>
                        <td>{$historytext_array[i].historytext_name}</td>
                        <td>
                            <a href="historytext_edit.php?num={$historytext_array[i].historytext_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>