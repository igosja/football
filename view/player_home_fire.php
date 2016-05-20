<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Увольнение футболиста</p>
            <p class="center">Вы собираетесь уволить следующего игрока:</p>
            <h6 class="center"><?= $player_name; ?> <?= $player_surname; ?></h6>
            <p class="center">
                <a href="player_home_fire.php?num=<?= $num_get; ?>&ok=1" class="button-link"><button>Уволить</button></a>
                <a href="player_home_profile.php?num=<?= $num_get; ?>" class="button-link"><button>Не увольнять</button></a>
            </p>
        </td>
    </tr>
</table>