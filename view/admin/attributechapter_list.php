<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Группы характеристик</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="attributechapter_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Группа</th>
                    <th>Характеристик</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$chapter_array}
                    <tr>
                        <td>
                            <a href="attributechapter.php?num={$chapter_array[i].attributechapter_id}">
                                {$chapter_array[i].attributechapter_name}
                            </a>
                        </td>
                        <td>
                            <a href="attribute_list.php?chapter_id={$chapter_array[i].attributechapter_id}">
                                {$chapter_array[i].count_attribute}
                            </a>
                        </td>
                        <td>
                            <a href="attributechapter_edit.php?num={$chapter_array[i].attributechapter_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>