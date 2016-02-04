<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование странцы</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="page_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Страница</td>
                        <td>
                            <input name="page_name" type="text" value="{if (isset($page_name))}{$page_name}{/if}"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Раздел</td>
                        <td>
                            <select name="chapter_id">
                                {section name=i loop=$chapter_array}
                                    <option value="{$chapter_array[i].horizontalmenuchapter_id}"
                                        {if (isset($chapter_id) && $chapter_id == $chapter_array[i].horizontalmenuchapter_id)}
                                            selected
                                        {/if}
                                    >
                                        {$chapter_array[i].horizontalmenuchapter_name}
                                    </option>
                                {/section}
                            </select>
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