<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Темы новостных сообщений</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="inboxtheme_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Тама</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$inboxtheme_array}
                    <tr>
                        <td class="left">{$inboxtheme_array[i].inboxtheme_name}</td>
                        <td>
                            <a href="inboxtheme_edit.php?num={$inboxtheme_array[i].inboxtheme_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>