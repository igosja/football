<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование погоды</h1>
        <button type="button" class="btn btn-default">
            <a href="weather_list.php">
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
                    <td>Название</td>
                    <td>
                        <input
                            class="form-control"
                            name="weather_name"
                            type="text"
                            value="<?php if (isset($weather_array[0]['weather_name'])) { print $weather_array[0]['weather_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Картинка (25x25, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="weather_logo"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Картинка (12x12, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="weather_logo_12"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <input class="btn btn-default" type="submit" value="Сохранить" />
                    </td>
                </tr>
                <?php if (isset($weather_array[0]['weather_id'])) { ?>
                    <tr>
                        <td colspan="2" class="text-center">
                            <img src="/img/weather/<?= $weather_array[0]['weather_id']; ?>.png" />
                            <img src="/img/weather/12/<?= $weather_array[0]['weather_id']; ?>.png" />
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</form>