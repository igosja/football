<table class="block-table w100">
    <tr>
        <td class="block-page w33">
            <p class="header">Тренировка позиции</p>
            <p class="center">
                Вы собираетесь натренировать позицию
                "<?php print $position_array[0]['position_description']; ?>"
                игроку
                <?php print $header_title; ?>.
            </p>
            <p class="center">
                <button>
                    <a href="player_home_training.php?num=<?php print $num; ?>&position=<?php print $position; ?>&ok=1">Подвердить</a>
                </button>
                <button>
                    <a href="player_home_training.php?num=<?php print $num; ?>">Отказаться</a>
                </button>
            </p>
        </td>
    </tr>
</table>