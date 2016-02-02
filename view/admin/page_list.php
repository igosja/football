<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Страницы сайта</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="page_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Страница</th>
                    <th>Раздел меню</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$page_array}
                    <tr>
                        <td class="left">
                            <a href="page.php?num={$page_array[i].page_id}">
                                {$page_array[i].page_name}
                            </a>
                        </td>
                        <td class="left">
                            {$page_array[i].horizontalmenuchapter_name}
                        </td>
                        <td>
                            <a href="page_edit.php?num={$page_array[i].page_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>