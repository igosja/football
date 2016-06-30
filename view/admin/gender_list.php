<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Пол</h1>
        <button type="button" class="btn btn-default">
            <a href="gender_create.php">
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
                        <th>Пол</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gender_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="gender.php?num=<?= $item['gender_id']; ?>">
                                    <?= $item['gender_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="gender_edit.php?num=<?= $item['gender_id']; ?>">
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