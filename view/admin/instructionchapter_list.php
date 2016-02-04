<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Группы инструкций</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="instructionchapter_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Группа</th>
                    <th>Инструкций</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$chapter_array}
                    <tr>
                        <td>
                            <a href="instructionchapter.php?num={$chapter_array[i].instructionchapter_id}">
                                {$chapter_array[i].instructionchapter_name}
                            </a>
                        </td>
                        <td>
                            <a href="attribute_list.php?chapter_id={$chapter_array[i].instructionchapter_id}">
                                {$chapter_array[i].count_instruction}
                            </a>
                        </td>
                        <td>
                            <a href="instructionchapter_edit.php?num={$chapter_array[i].instructionchapter_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>