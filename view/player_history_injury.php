<table class="block-table w100">
    <tr>
        <td class="block-page">
            <p class="header">История травм</p>
            <table class="striped w100">
                <tr>
                    <th class="w10">Дата травмы</th>
                    <th>Тип травмы</th>
                    <th class="w10">Время отсутствия</th>
                </tr>
                <?php foreach ($injury_array as $item) { ?>
                    <tr>
                        <td class="center"><?php print f_igosja_ufu_date($item['injury_start_date']); ?></td>
                        <td><?php print $item['injurytype_name']; ?></td>
                        <td class="center"><?php print $item['injurytype_day']; ?> дн.</td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>