<table class="block-table w100">
    <tr>
        <td class="block-page w33">
            <p class="header">Улучшение характеристики</p>
            <p class="center">
                Вы собираетесь улучшить характеристику
                "<?= $attribute_array[0]['attribute_name']; ?>"
                игроку
                <?= $header_title; ?>.
            </p>
            <p class="center">
                <a href="player_home_training.php?num=<?= $num; ?>&char=<?= $char; ?>&ok=1" class="button-link">
                    <button>
                        Подвердить
                    </button>
                </a>
                <a href="player_home_training.php?num=<?= $num; ?>" class="button-link">
                    <button>
                        Отказаться
                    </button>
                </a>
            </p>
        </td>
    </tr>
</table>
