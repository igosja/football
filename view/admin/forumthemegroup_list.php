<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header center">Группы тем</p>
            <p class="center">
                <a href="index.php" class="link-img link-home"></a>
                <a href="forumchapter_list.php" class="link-img link-list"></a>
                <a href="forumthemegroup_create.php" class="link-img link-plus"></a>
            </p>
            <table class="center striped">
                <tr>
                    <th>Группа</th>
                    <th>Раздел</th>
                    <th>Тем</th>
                    <th>Действия</th>
                </tr>
                {section name=i loop=$chapter_array}
                    <tr>
                        <td>
                            <a href="forumthemegroup.php?num={$chapter_array[i].forumthemegroup_id}">
                                {$chapter_array[i].forumthemegroup_name}
                            </a>
                        </td>
                        <td>
                            <a href="forumchapter.php?num={$chapter_array[i].forumchapter_id}">
                                {$chapter_array[i].forumchapter_name}
                            </a>
                        </td>
                        <td>
                            <a href="forumtheme_list.php?chapter_id={$chapter_array[i].forumthemegroup_id}">
                                {$chapter_array[i].count_theme}
                            </a>
                        </td>
                        <td>
                            <a href="forumthemegroup_edit.php?num={$chapter_array[i].forumthemegroup_id}" class="link-img link-pencil"></a>
                        </td>
                    </tr>
                {/section}
            </table>
        </td>
    </tr>
</table>