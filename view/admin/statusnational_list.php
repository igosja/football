<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Доступность для сборной</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="statusnational_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Название</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$statusnational_array}
                    <tr>
                        <td>
                            <a href="statusnational.php?num={$statusnational_array[i].statusnational_id}">
                                {$statusnational_array[i].statusnational_name}
                            </a>
                        </td>
                        <td>
                            <a href="statusnational_edit.php?num={$statusnational_array[i].statusnational_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>