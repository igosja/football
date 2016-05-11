<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование события</h1>
        <button type="button" class="btn btn-default">
            <a href="eventtype_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
    </div>
</div>
<form method="POST" enctype="multipart/form-data">
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>Событие</td>
                    <td>
                        <input
                            class="form-control"
                            name="eventtype_name"
                            type="text"
                            value="<?php if (isset($eventtype_array[0]['eventtype_name'])) { print $eventtype_array[0]['eventtype_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Картинка (15x15, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="eventtype_logo"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <input class="btn btn-default" type="submit" value="Сохранить" />
                    </td>
                </tr>
                <?php if (isset($eventtype_array[0]['eventtype_id'])) { ?>
                    <tr>
                        <td colspan="2" class="text-center">
                            <img src="/img/eventtype/<?= $eventtype_array[0]['eventtype_id']; ?>.png" />
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</form>