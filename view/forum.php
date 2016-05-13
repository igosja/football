<table class="block-table w100">
    <tr>
        <td class="block-page block-page-forum">
            <?php for ($i=0; $i<$count_forum; $i++) { ?>
                <?php if (!isset($forum_array[$i-1]['forumchapter_id']) ||
                          $forum_array[$i-1]['forumchapter_id'] != $forum_array[$i]['forumchapter_id']) { ?>
                    <table class="forum-group w100">
                        <tr>
                            <th><?= $forum_array[$i]['forumchapter_name']; ?></th>
                            <th class="w8">Темы</th>
                            <th class="w8">Сообщений</th>
                            <th class="w20">Последнее</th>
                        </tr>
                <?php } ?>
                <tr>
                    <td>
                        <a href="forum_group.php?num=<?= $forum_array[$i]['forumthemegroup_id']; ?>">
                            <strong><?= $forum_array[$i]['forumthemegroup_name']; ?></strong>
                        </a>
                        <br />
                        <?= $forum_array[$i]['forumthemegroup_description']; ?>
                    </td>
                    <td class="center vcenter"><?= $forum_array[$i]['count_theme']; ?></td>
                    <td class="center vcenter"><?= $forum_array[$i]['count_post']; ?></td>
                    <td>
                        <a href="forum_theme.php?num=<?= $forum_array[$i]['forumtheme_id']; ?>">
                            <?= $forum_array[$i]['forumtheme_name']; ?>
                        </a>
                        <br />
                        <a href="manager_home_profile.php?num=<?= $forum_array[$i]['user_id']; ?>">
                            <?= $forum_array[$i]['user_login']; ?>
                        </a>
                        (<?= f_igosja_ufu_date_time($forum_array[$i]['forumpost_date']); ?>)
                    </td>
                </tr>
                <?php if (!isset($forum_array[$i+1]['forumchapter_id']) || $forum_array[$i+1]['forumchapter_id'] != $forum_array[$i]['forumchapter_id']) { ?>
                    </table>
                <?php } ?>
            <?php } ?>
        </td>
    </tr>
</table>