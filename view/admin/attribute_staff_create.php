<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование характеристики</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="attribute_staff_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Группа</td>
                        <td>
                            <select name="chapter_id">
                                {section name=i loop=$chapter_array}
                                    <option value="{$chapter_array[i].attributechapterstaff_id}"
                                        {if (isset($chapter_id) && $chapter_id == $chapter_array[i].attributechapterstaff_id)}
                                            selected
                                        {/if}
                                    >
                                        {$chapter_array[i].attributechapterstaff_name}
                                    </option>
                                {/section}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Харатеристика</td>
                        <td>
                            <input name="attribute_name" type="text" value="{if (isset($attribute_name))}{$attribute_name}{/if}"/>
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