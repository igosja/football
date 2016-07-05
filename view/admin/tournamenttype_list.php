<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Типы турниров</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="tournamenttype_create.php" class="btn btn-default">
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
                        <th>Тип турнира</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tournamenttype_array as $item) { ?>
                        <tr>
                            <td><?= $item['tournamenttype_name']; ?></td>
                            <td>
                                <a href="tournamenttype_edit.php?num=<?= $item['tournamenttype_id']; ?>">
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