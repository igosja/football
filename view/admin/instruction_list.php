<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Инструкции</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="instructionchapter_list.php" class="link-img link-list"></a>
                <a href="instruction_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Инструкция</th>
                    <th>Группа</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$instruction_array}
                    <tr>
                        <td>
                            <a href="instruction_list.php?chapter_id={$instruction_array[i].instruction_id}">
                                {$instruction_array[i].instruction_name}
                            </a>
                        </td>
                        <td>
                            <a href="instruction.php?num={$instruction_array[i].instructionchapter_id}">
                                {$instruction_array[i].instructionchapter_name}
                            </a>
                        </td>
                        <td>
                            <a href="instruction_edit.php?num={$instruction_array[i].instruction_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>