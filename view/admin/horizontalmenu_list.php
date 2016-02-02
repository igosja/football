<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Первая строка меню</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="horizontalmenu_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Меню</th>
                    <th>Раздел</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$menu_array}
                    <tr>
                        <td class="left">{$menu_array[i].horizontalmenu_name}</td>
                        <td class="left">{$menu_array[i].horizontalmenuchapter_name}</td>
                        <td>
                            <a href="horizontalmenu_edit.php?num={$menu_array[i].horizontalmenu_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>