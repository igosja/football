<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование первой строки меню</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="horizontalmenu_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Раздел</td>
                        <td>
                            <select name="horizontalmenuchapter_id">
                                {section name=i loop=$horizontalmenuchapter_array}
                                    <option 
                                        value="{$horizontalmenuchapter_array[i].horizontalmenuchapter_id}"
                                        {if (isset($horizontalmenuchapter_id) && 
                                             $horizontalmenuchapter_id == $horizontalmenuchapter_array[i].horizontalmenuchapter_id)}
                                            selected
                                        {/if}
                                    >
                                        {$horizontalmenuchapter_array[i].horizontalmenuchapter_name}
                                    </option>
                                {/section}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Название</td>
                        <td>
                            <input name="menu_name" type="text" value="{if (isset($menu_name))}{$menu_name}{/if}"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Сохранить"/>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>