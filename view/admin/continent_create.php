<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование континента</h1>
        <button type="button" class="btn btn-default">
            <a href="continent_list.php">
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
                    <td>Континент</td>
                    <td>
                        <input
                            class="form-control"
                            name="continent_name"
                            type="text"
                            value="<?php if (isset($continent_array[0]['continent_name'])) { print $continent_array[0]['continent_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Эмблема (160x110, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="continent_logo"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <input class="btn btn-default" type="submit" value="Сохранить" />
                    </td>
                </tr>
                <?php if (isset($continent_array[0]['continent_id'])) { ?>
                    <tr>
                        <td colspan="2" class="text-center">
                            <img src="/img/continent/<?= $continent_array[0]['continent_id']; ?>.png" />
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</form>