<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Список трансферов</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th class="col-lg-3">Футболист</th>
                        <th class="col-lg-3">Покупатель</th>
                        <th class="col-lg-3">Продавец</th>
                        <th>Цена</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transfer_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="player.php?num=<?= $item['transfer_player_id']; ?>">
                                    <?= $item['name_name']; ?>
                                    <?= $item['surname_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="team.php?num=<?= $item['transfer_buyer_id']; ?>">
                                    <?= $item['buyer_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="team.php?num=<?= $item['transfer_seller_id']; ?>">
                                    <?= $item['seller_name']; ?>
                                </a>
                            </td>
                            <td><?= f_igosja_money($item['transfer_price']); ?></td>
                            <td>
                                <a href="transfer_delete.php?num=<?= $item['transfer_id']; ?>">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>