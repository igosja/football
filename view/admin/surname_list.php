<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Фамилии игроков</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="surname_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Имя</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$surname_array}
                    <tr>
                        <td>
                            <a href="surname.php?num={$surname_array[i].surname_id}">
                                {$surname_array[i].surname_name}
                            </a>
                        </td>
                        <td>
                            <a href="surname_edit.php?num={$surname_array[i].surname_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>