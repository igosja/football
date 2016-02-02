<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Пол</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="gender_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Пол</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$gender_array}
                    <tr>
                        <td>
                            <a href="gender.php?num={$gender_array[i].gender_id}">
                                {$gender_array[i].gender_name}
                            </a>
                        </td>
                        <td>
                            <a href="gender_edit.php?num={$gender_array[i].gender_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>