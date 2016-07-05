<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Настроение игроков</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="mood_create.php" class="btn btn-default">
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
                        <th>Настроение</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mood_array as $item) { ?>
                        <tr>
                            <td>
                                <img src="/img/mood/<?= $item['mood_id']; ?>.png" />
                                <a href="mood.php?num=<?= $item['mood_id']; ?>">
                                    <?= $item['mood_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="mood_edit.php?num=<?= $item['mood_id']; ?>">
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