<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Позиции игроков</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="position_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Позиция</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$position_array}
                    <tr>
                        <td>
                            <a href="position.php?num={$position_array[i].position_id}">
                                {$position_array[i].position_name} - {$position_array[i].position_description}
                            </a>
                        </td>
                        <td>
                            <a href="position_edit.php?num={$position_array[i].position_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>