<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Темы новостных сообщений</h1>
        <button type="button" class="btn btn-default">
            <a href="inboxtheme_create.php">
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
                        <th>Тема</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inboxtheme_array as $item) { ?>
                        <tr>
                            <td><?php print $item['inboxtheme_name']; ?></td>
                            <td>
                                <a href="inboxtheme_edit.php?num=<?php print $item['inboxtheme_id']; ?>"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>