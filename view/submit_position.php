<table class="block-table w100">
    <tr>
        <td class="block-page w33">
            <p class="header">Тренировка позиции</p>
            <p class="center">
                Вы собираетесь натренировать позицию
                "<?= $position_array[0]['position_description']; ?>"
                игроку
                <?= $header_title; ?>.
            </p>
            <p class="center">
                <a href="player_home_training.php?num=<?= $num; ?>&position=<?= $position; ?>&ok=1" class="button-link"><button>Подвердить</button></a>
                <a href="player_home_training.php?num=<?= $num; ?>" class="button-link"><button>Отказаться</button></a>
            </p>
        </td>
    </tr>
</table>
