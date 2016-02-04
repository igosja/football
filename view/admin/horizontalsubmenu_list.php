<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Вторая строка меню</h1>
        <button type="button" class="btn btn-default">
            <a href="horizontalmenu_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
        <button type="button" class="btn btn-default">
            <a href="horizontalsubmenu_create.php">
                <i class="fa fa-plus"></i>
            </a>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover" id="bootstrap-table">
                <thead>
                    <tr>
                        <th>Меню</th>
                        <th>Ссылка</th>
                        <th>Родитель</th>
                        <th>Раздел</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menu_array as $item) { ?>
                        <tr>
                            <td><?php print $item['horizontalsubmenu_name']; ?></td>
                            <td><?php print $item['horizontalsubmenu_href']; ?></td>
                            <td><?php print $item['horizontalmenu_name']; ?></td>
                            <td><?php print $item['horizontalmenuchapter_name']; ?></td>
                            <td>
                                <a href="horizontalsubmenu_edit.php?num=<?php print $item['horizontalsubmenu_id']; ?>"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>