<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Форум сайта</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <?php for ($i=0; $i<$count_forum; $i++) { ?>
                <?php if (!isset($forum_array[$i-1]['forumchapter_id']) ||
                          $forum_array[$i-1]['forumchapter_id'] != $forum_array[$i]['forumchapter_id']) { ?>
                    <table class="table table-striped table-bordered table-hover table-condensed">
                        <tr>
                            <th class="text-center"><?= $forum_array[$i]['forumchapter_name']; ?></th>
                            <th class="text-center col-lg-1">Темы</th>
                            <th class="text-center col-lg-1">Сообщений</th>
                            <th class="text-center col-lg-3">Последнее</th>
                        </tr>
                <?php } ?>
                <tr>
                    <td>
                        <a href="forum_group.php?num=<?= $forum_array[$i]['forumthemegroup_id']; ?>">
                            <?= $forum_array[$i]['forumthemegroup_name']; ?>
                        </a>
                        <br />
                        <?= $forum_array[$i]['forumthemegroup_description']; ?>
                    </td>
                    <td class="text-center"><?= $forum_array[$i]['count_theme']; ?></td>
                    <td class="text-center"><?= $forum_array[$i]['count_post']; ?></td>
                    <td>
                        <a href="forum_theme.php?num=<?= $forum_array[$i]['forumtheme_id']; ?>">
                            <?= $forum_array[$i]['forumtheme_name']; ?>
                        </a>
                        <br />
                        <a href="user.php?num=<?= $forum_array[$i]['user_id']; ?>"
                            <?php if (1 == $forum_array[$i]['user_id']) { ?>class="red"<?php } ?>
                        >
                            <?= $forum_array[$i]['user_login']; ?>
                        </a>
                        (<?= f_igosja_ufu_date_time($forum_array[$i]['forumpost_date']); ?>)
                    </td>
                </tr>
                <?php if (!isset($forum_array[$i+1]['forumchapter_id']) || $forum_array[$i+1]['forumchapter_id'] != $forum_array[$i]['forumchapter_id']) { ?>
                    </table>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>