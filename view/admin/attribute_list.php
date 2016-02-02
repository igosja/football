<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Характеристики</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="attributechapter_list.php" class="link-img link-list"></a>
                <a href="attribute_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Характеристика</th>
                    <th>Группа</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$attribute_array}
                    <tr>
                        <td class="left">
                            <a href="attribute_list.php?chapter_id={$attribute_array[i].attribute_id}">
                                {$attribute_array[i].attribute_name}
                            </a>
                        </td>
                        <td class="left">
                            <a href="attribute.php?num={$attribute_array[i].attributechapter_id}">
                                {$attribute_array[i].attributechapter_name}
                            </a>
                        </td>
                        <td>
                            <a href="attribute_edit.php?num={$attribute_array[i].attribute_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>