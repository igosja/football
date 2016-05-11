<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Характеристики</h1>
        <button type="button" class="btn btn-default">
            <a href="attributechapter_staff_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
        <button type="button" class="btn btn-default">
            <a href="attribute_staff_create.php">
                <i class="fa fa-plus"></i>
            </a>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed" id="bootstrap-table">
                <thead>
                    <tr>
                        <th>Характеристика</th>
                        <th>Группа</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attribute_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="attribute_staff_list.php?num=<?= $item['attributestaff_id']; ?>">
                                    <?= $item['attributestaff_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="attribute_staff.php?num=<?= $item['attributechapterstaff_id']; ?>">
                                    <?= $item['attributechapterstaff_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="attribute_staff_edit.php?num=<?= $item['attributestaff_id']; ?>">
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