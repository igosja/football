<table class="block-table w100">
    <tr>
        <td class="block-page w33">
            <p class="header">Улучшение характеристики</p>
            <p class="center">
                Вы собираетесь улучшить характеристику
                "<?php print $attribute_array[0]['attribute_name']; ?>"
                игроку
                <?php print $header_title; ?>.
            </p>
            <p class="center">
                <button>
                    <a href="player_home_training.php?num=<?php print $num; ?>&char=<?php print $char; ?>&ok=1">Подвердить</a>
                </button>
                <button>
                    <a href="player_home_training.php?num=<?php print $num; ?>">Отказаться</a>
                </button>
            </p>
        </td>
    </tr>
</table>
