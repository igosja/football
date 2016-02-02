<table class="block-table w100">
    <tr>
        <td class="block-page">
            <table class="w100">
                <tr>
                    <td>
                        <button>
                            <a href="forum_posting.php?group={$head_array.0.forumthemegroup_id}">
                                Создать тему
                            </a>
                        </button>
                    </td>
                    <td class="right">
                        Страницы:
                        {section name=i loop=$count_forum}
                            {if ($smarty.section.i.iteration == 1 ||
                                 $smarty.section.i.iteration == $count_forum ||
                                ($smarty.section.i.iteration >= $page - 2 &&
                                 $smarty.section.i.iteration <= $page + 2))}
                            <button
                                {if ($smarty.section.i.iteration == $page)}
                                    class="button-active"
                                {/if}
                            >
                                <a href="forum_group.php?num={$num}&page={$smarty.section.i.iteration}">
                                    {$smarty.section.i.iteration}
                                </a>
                            </button>
                            {/if}
                        {/section}
                    </td>
                </tr>
            </table>
            <table class="forum-group w100">
                <tr>
                    <th colspan="2">Темы</th>
                    <th class="w8">Ответы</th>
                    <th class="w20">Последнее</th>
                </tr>
                {section name=i loop=$forum_array}
                    <tr>
                        <td class="w1" rowspan="2">
                            Picture
                        </td>
                        <td>
                            <a href="forum_theme.php?num={$forum_array[i].forumtheme_id}">
                                {$forum_array[i].forumtheme_name}
                            </a>
                        </td>
                        <td></td>
                        <td>
                            {$forum_array[i].post_login}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="center vcenter">{$forum_array[i].count_post}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            {$forum_array[i].user_login},
                            {$forum_array[i].forumtheme_date|date_format:"%H:%M %d.%m.%Y"}
                        </td>
                        <td></td>
                        <td>
                            {$forum_array[i].forumpost_date|date_format:"%H:%M %d.%m.%Y"}
                        </td>
                    </tr>
                {/section}
            </table>
            <table class="w100">
                <tr>
                    <td>
                        <button>
                            <a href="forum_posting.php?group={$head_array.0.forumthemegroup_id}">
                                Создать тему
                            </a>
                        </button>
                    </td>
                    <td class="right">
                        Страницы:
                        {section name=i loop=$count_forum}
                            {if ($smarty.section.i.iteration == 1 ||
                                 $smarty.section.i.iteration == $count_forum ||
                                ($smarty.section.i.iteration >= $page - 2 &&
                                 $smarty.section.i.iteration <= $page + 2))}
                            <button
                                {if ($smarty.section.i.iteration == $page)}
                                    class="button-active"
                                {/if}
                            >
                                <a href="forum_group.php?num={$num}&page={$smarty.section.i.iteration}">
                                    {$smarty.section.i.iteration}
                                </a>
                            </button>
                            {/if}
                        {/section}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>