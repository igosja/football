<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">Расписание</p>
            <table class="striped w100">
                <tr>
                    <th class="w20">Дата</th>
                    <th>Стадия</th>
                </tr>
                <?php foreach ($shedule_array as $item) { ?>
                    <tr>
                        <td class="center"><?= date('d.m.Y', strtotime($item['shedule_date'])); ?></td>
                        <td>
                            <a href="cup_game_result.php?num=<?= $num; ?>&shedule=<?= $item['shedule_id']; ?>">
                                <?= $item['stage_name']; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>