<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Командный статус</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="statusteam_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Название</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$statusteam_array}
                    <tr>
                        <td>
                            <a href="statusteam.php?num={$statusteam_array[i].statusteam_id}">
                                {$statusteam_array[i].statusteam_name}
                            </a>
                        </td>
                        <td>
                            <a href="statusteam_edit.php?num={$statusteam_array[i].statusteam_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>