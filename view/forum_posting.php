<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">
                <?php if (isset($forum_array[0]['forumthemegroup_name'])) { ?>
                    <?= $forum_array[0]['forumthemegroup_name']; ?>
                <?php } else { ?>
                    <?= $forum_array[0]['forumtheme_name']; ?>
                <?php } ?>
            </p>
            <form method="POST" class="center">
                <input type="text" class="w98" placeholder="Заголовок" name="name"
                    <?php if (isset($forum_array[0]['forumtheme_name'])) { ?>
                        value="RE: <?= $forum_array[0]['forumtheme_name']; ?>"
                    <?php } ?>
                />
                <textarea class="w98" rows="10" placeholder="Сообщение" name="text"><?php
                    if (isset($answer_array[0]['forumpost_text'])) { ?>[quote]<?= $answer_array[0]['forumpost_text']; ?>[/quote]<?php }
                    elseif (isset($edit_array[0]['forumpost_text'])) { ?><?= $edit_array[0]['forumpost_text']; ?><?php }
                ?></textarea>
                <input type="submit" value="Добавить сообщение" />
            </form>
        </td>
    </tr>
</table>