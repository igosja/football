<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование команды</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="team_list.php" class="btn btn-default">
                    <i class="fa fa-list"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<form method="POST" enctype="multipart/form-data">
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered">
                <tr>
                    <td>Команда</td>
                    <td>
                        <input
                            class="form-control"
                            name="team_name"
                            type="text"
                            value="<?php if (isset($team_array[0]['team_name'])) { print $team_array[0]['team_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Город</td>
                    <td>
                        <select class="form-control" name="city_id">
                            <?php foreach ($city_array as $item) { ?>
                                <option value="<?= $item['city_id']; ?>"
                                    <?php if (isset($team_array[0]['team_city_id']) && $team_array[0]['team_city_id'] == $item['city_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['city_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Стадион</td>
                    <td>
                        <input
                            class="form-control"
                            name="stadium_name"
                            type="text"
                            value="<?php if (isset($team_array[0]['stadium_name'])) { print $team_array[0]['stadium_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Эмблема (120x120, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="team_logo_120"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Эмблема (90x90, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="team_logo_90"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Эмблема (50x50, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="team_logo_50"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Эмблема (12x12, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="team_logo_12"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <input class="btn btn-default" type="submit" value="Сохранить" />
                    </td>
                </tr>
                <?php if (isset($team_array[0]['team_id'])) { ?>
                    <tr>
                        <td colspan="2" class="text-center">
                            <img src="/img/team/120/<?= $team_array[0]['team_id']; ?>.png" />
                            <img src="/img/team/90/<?= $team_array[0]['team_id']; ?>.png" />
                            <img src="/img/team/50/<?= $team_array[0]['team_id']; ?>.png" />
                            <img src="/img/team/12/<?= $team_array[0]['team_id']; ?>.png" />
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</form>