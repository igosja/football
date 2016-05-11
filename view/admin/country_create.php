<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование страны</h1>
        <button type="button" class="btn btn-default">
            <a href="country_list.php">
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
                    <td>Страна</td>
                    <td>
                        <input
                            class="form-control"
                            name="country_name"
                            type="text"
                            value="<?php if (isset($country_array[0]['country_name'])) { print $country_array[0]['country_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Континент</td>
                    <td>
                        <select class="form-control" name="continent_id">
                            <?php foreach ($continent_array as $item) { ?>
                                <option value="<?= $item['continent_id']; ?>"
                                    <?php if (isset($country_array[0]['continent_id']) && $country_array[0]['continent_id'] == $item['continent_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['continent_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Флаг (135x90, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="country_flag_90"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Флаг (75x50, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="country_flag_50"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Флаг (18x12, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="country_flag_12"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <input class="btn btn-default" type="submit" value="Сохранить" />
                    </td>
                </tr>
                <?php if (isset($country_array[0]['country_id'])) { ?>
                    <tr>
                        <td colspan="2" class="text-center">
                            <img src="/img/flag/90/<?= $country_array[0]['country_id']; ?>.png" />
                            <img src="/img/flag/50/<?= $country_array[0]['country_id']; ?>.png" />
                            <img src="/img/flag/12/<?= $country_array[0]['country_id']; ?>.png" />
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</form>