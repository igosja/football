<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Стадии</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="stage_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Стадия</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$stage_array}
                    <tr>
                        <td>
                            <a href="stage.php?num={$stage_array[i].stage_id}">
                                {$stage_array[i].stage_name}
                            </a>
                        </td>
                        <td>
                            <a href="stage_edit.php?num={$stage_array[i].stage_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>