<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Команды</h1>
        <button type="button" class="btn btn-default">
            <a href="city_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
        <button type="button" class="btn btn-default">
            <a href="team_create.php">
                <i class="fa fa-plus"></i>
            </a>
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Команда</th>
                        <th>Стадион</th>
                        <th>Город</th>
                        <th>Страна</th>
                        <th>Континент</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($team_array as $item) { ?>
                        <tr>
                            <td>
                                <img src="/img/team/12/<?= $item['team_id']; ?>.png" />
                                <a href="team.php?num=<?= $item['team_id']; ?>">
                                    <?= $item['team_name']; ?>
                                </a>
                            </td>
                            <td>
                                <?= $item['stadium_name']; ?>
                            </td>
                            <td>
                                <a href="city.php?num=<?= $item['city_id']; ?>">
                                    <?= $item['city_name']; ?>
                                </a>
                            </td>
                            <td>
                                <img src="/img/flag/12/<?= $item['country_id']; ?>.png" />
                                <a href="country.php?num=<?= $item['country_id']; ?>">
                                    <?= $item['country_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="continent.php?num=<?= $item['continent_id']; ?>">
                                    <?= $item['continent_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="team_edit.php?num=<?= $item['team_id']; ?>">
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