<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Вторая строка меню</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="horizontalmenu_list.php" class="link-img link-list"></a>
                <a href="horizontalsubmenu_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Меню</th>
                    <th>Ссылка</th>
                    <th>Родитель</th>
                    <th>Раздел</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$menu_array}
                    <tr>
                        <td class="left">{$menu_array[i].horizontalsubmenu_name}</td>
                        <td class="left">{$menu_array[i].horizontalsubmenu_href}</td>
                        <td class="left">{$menu_array[i].horizontalmenu_name}</td>
                        <td class="left">{$menu_array[i].horizontalmenuchapter_name}</td>
                        <td>
                            <a href="horizontalsubmenu_edit.php?num={$menu_array[i].horizontalsubmenu_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>