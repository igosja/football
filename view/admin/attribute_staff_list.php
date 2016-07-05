<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Характеристики</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="attributechapter_staff_list.php" class="btn btn-default">
                    <i class="fa fa-list"></i>
                </a>
            </li>
            <li>
                <a href="attribute_staff_create.php" class="btn btn-default">
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