<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Редактирование турнира</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="tournament_list.php" class="btn btn-default">
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
                    <td>Название</td>
                    <td>
                        <input
                            class="form-control"
                            name="tournament_name"
                            type="text"
                            value="<?php if (isset($tournament_array[0]['tournament_name'])) { print $tournament_array[0]['tournament_name']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Тип</td>
                    <td>
                        <select class="form-control" name="tournamenttype_id">
                            <?php foreach ($tournamenttype_array as $item) { ?>
                                <option value="<?= $item['tournamenttype_id']; ?>"
                                    <?php if (isset($tournament_array[0]['tournament_tournamenttype_id']) && $tournament_array[0]['tournament_tournamenttype_id'] == $item['tournamenttype_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['tournamenttype_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Уровень</td>
                    <td>
                        <input
                            class="form-control"
                            name="tournament_level"
                            type="text"
                            value="<?php if (isset($tournament_array[0]['tournament_level'])) { print $tournament_array[0]['tournament_level']; } ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Страна</td>
                    <td>
                        <select class="form-control" name="country_id">
                            <?php foreach ($country_array as $item) { ?>
                                <option value="<?= $item['country_id']; ?>"
                                    <?php if (isset($tournament_array[0]['tournament_country_id']) && $tournament_array[0]['tournament_country_id'] == $item['country_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['country_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Эмблема (90x90, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="tournament_logo_90"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Эмблема (50x50, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="tournament_logo_50"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td>Эмблема (12x12, png)</td>
                    <td>
                        <input
                            class="form-control"
                            name="tournament_logo_12"
                            type="file"
                        />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <input class="btn btn-default" type="submit" value="Сохранить" />
                    </td>
                </tr>
                <?php if (isset($tournament_array[0]['tournament_id'])) { ?>
                    <tr>
                        <td colspan="2" class="text-center">
                            <img src="/img/tournament/90/<?= $tournament_array[0]['tournament_id']; ?>.png" />
                            <img src="/img/tournament/50/<?= $tournament_array[0]['tournament_id']; ?>.png" />
                            <img src="/img/tournament/12/<?= $tournament_array[0]['tournament_id']; ?>.png" />
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
</form>