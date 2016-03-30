<table class="block-table w100">
    <tr>
        <td class="block-page-forum">
            <?php for ($i=0; $i<$count_forum; $i++) { ?>
                <?php if (!isset($forum_array[$i-1]['forumchapter_id']) ||
                          $forum_array[$i-1]['forumchapter_id'] != $forum_array[$i]['forumchapter_id']) { ?>
                    <table class="forum-group w100">
                        <tr>
                            <th><?php print $forum_array[$i]['forumchapter_name']; ?></th>
                            <th class="w8">Темы</th>
                            <th class="w8">Сообщений</th>
                            <th class="w20">Последнее</th>
                        </tr>
                <?php } ?>
                <tr>
                    <td>
                        <a href="forum_group.php?num=<?php print $forum_array[$i]['forumthemegroup_id']; ?>">
                            <?php print $forum_array[$i]['forumthemegroup_name']; ?>
                        </a>
                        <br />
                        <?php print $forum_array[$i]['forumthemegroup_description']; ?>
                    </td>
                    <td class="center vcenter"><?php print $forum_array[$i]['count_theme']; ?></td>
                    <td class="center vcenter"><?php print $forum_array[$i]['count_post']; ?></td>
                    <td>
                        <a href="forum_theme.php?num=<?php print $forum_array[$i]['forumtheme_id']; ?>">
                            <?php print $forum_array[$i]['forumtheme_name']; ?>
                        </a>
                        <br />
                        <?php print $forum_array[$i]['user_login']; ?> (<?php print f_igosja_ufu_date_time($forum_array[$i]['forumpost_date']); ?>)
                    </td>
                </tr>
                <?php if (!isset($forum_array[$i+1]['forumchapter_id']) ||
                          $forum_array[$i+1]['forumchapter_id'] != $forum_array[$i]['forumchapter_id']) { ?>
                    </table>
                <?php } ?>
            <?php } ?>
        </td>
    </tr>
</table>