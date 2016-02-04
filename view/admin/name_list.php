<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Имена игроков</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="name_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Имя</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$name_array}
                    <tr>
                        <td>
                            <a href="name.php?num={$name_array[i].name_id}">
                                {$name_array[i].name_name}
                            </a>
                        </td>
                        <td>
                            <a href="name_edit.php?num={$name_array[i].name_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>