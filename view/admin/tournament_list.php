<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Турниры</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="tournamenttype_list.php" class="btn btn-default">
                    <i class="fa fa-list"></i>
                </a>
            </li>
            <li>
                <a href="tournament_create.php" class="btn btn-default">
                    <i class="fa fa-plus"></i>
                </a>
            </li>
        </ul>
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