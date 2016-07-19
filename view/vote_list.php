<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Опросы</p>
            <?php if (isset($authorization_user_id)) { ?>
                <table class="bordered center w100">
                    <tr>
                        <td>
                            <a href="vote_add.php" class="button-link">
                                <button>
                                    Добавить новый опрос
                                </button>
                            </a>
                        </td>
                    </tr>
                </table>
            <?php } ?>
            <table class="bordered w100">
                <?php for ($i=0; $i<$count_vote; $i++) { ?>
                    <?php if (!isset($vote_array[$i-1]['vote_id']) || $vote_array[$i-1]['vote_id'] != $vote_array[$i]['vote_id']) { ?>
                        <tr class="current-vote">
                            <td><strong><?= $vote_array[$i]['vote_question']; ?></strong></td>
                            <td class="w10"></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td><?= $vote_array[$i]['voteanswer_answer']; ?></td>
                        <td class="center"><?= $vote_array[$i]['voteanswer_value']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>