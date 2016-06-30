<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Должности персонала</h1>
        <button type="button" class="btn btn-default">
            <a href="post_create.php">
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
                        <th>Должность</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($post_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="post.php?num=<?= $item['staffpost_id']; ?>">
                                    <?= $item['staffpost_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="post_edit.php?num=<?= $item['staffpost_id']; ?>">
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