<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Турниры</h1>
        <button type="button" class="btn btn-default">
            <a href="tournamenttype_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
        <button type="button" class="btn btn-default">
            <a href="tournament_create.php">
                <i class="fa fa-plus"></i>
            </a>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Турнир</th>
                        <th>Тип</th>
                        <th>Уровень</th>
                        <th>Страна</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tournament_array as $item) { ?>
                        <tr>
                            <td>
                                <img src="/img/tournament/12/<?= $item['tournament_id']; ?>.png" />
                                <?= $item['tournament_name']; ?>
                            </td>
                            <td><?= $item['tournamenttype_name']; ?></td>
                            <td><?= $item['tournament_level']; ?></td>
                            <td>
                                <img src="/img/flag/12/<?= $item['country_id']; ?>.png" />
                                <?= $item['country_name']; ?>
                            </td>
                            <td>
                                <a href="tournament_edit.php?num=<?= $item['tournament_id']; ?>">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>