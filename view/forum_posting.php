<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">
                <?php if (isset($forum_array[0]['forumthemegroup_name'])) { ?>
                    <?php print $forum_array[0]['forumthemegroup_name']; ?>
                <?php } else { ?>
                    <?php print $forum_array[0]['forumtheme_name']; ?>
                <?php } ?>
            </p>
            <form method="POST" class="center">
                <input type="text" class="w100" placeholder="Заголовок" name="name" 
                    <?php if (isset($forum_array[0]['forumtheme_name'])) { ?>
                        value="RE: <?php print $forum_array[0]['forumtheme_name']; ?>"
                    <?php } ?>
                />
                <textarea class="w100" rows="10" placeholder="Сообщение" name="text" ></textarea>
                <input type="submit" />
            </form>
        </td>
    </tr>
</table>