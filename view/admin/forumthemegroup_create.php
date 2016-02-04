<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Редактирование группы тем</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="forumthemegroup_list.php" class="link-img link-list"></a>
            </p>
            <form action="" method="POST">
                <table class="center striped">
                    <tr>
                        <td>Группа</td>
                        <td>
                            <input name="chapter_name" type="text" value="{if (isset($chapter_name))}{$chapter_name}{/if}"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Описание</td>
                        <td>
                            <input name="chapter_description" type="text" value="{if (isset($chapter_description))}{$chapter_description}{/if}"/>
                        </td>
                    </tr>
                    <tr>
                        <td>Раздел</td>
                        <td>
                            <select name="chapter_id">
                                {section name=i loop=$forumchapter_array}
                                    <option value="{$forumchapter_array[i].forumchapter_id}"
                                        {if (isset($chapter_id) && $forumchapter_array[i].forumchapter_id == $chapter_id)}
                                            selected
                                        {/if}
                                    >
                                        {$forumchapter_array[i].forumchapter_name}
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