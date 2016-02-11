<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Страницы сайта</h1>
        <button type="button" class="btn btn-default">
            <a href="horizontalmenupage_create.php">
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
                        <th>Страница</th>
                        <th>Раздел меню</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($horizontalmenupage_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="horizontalmenupage.php?num=<?php print $item['horizontalmenupage_id']; ?>">
                                    <?php print $item['horizontalmenupage_name']; ?>
                                </a>
                            </td>
                            <td><?php print $item['horizontalmenuchapter_name']; ?></td>
                            <td>
                                <a href="horizontalmenupage_edit.php?num=<?php print $item['horizontalmenupage_id']; ?>">
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