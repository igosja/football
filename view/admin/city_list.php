<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Города</h1>
        <button type="button" class="btn btn-default">
            <a href="country_list.php">
                <i class="fa fa-list"></i>
            </a>
        </button>
        <button type="button" class="btn btn-default">
            <a href="city_create.php">
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
                        <th>Город</th>
                        <th>Команд</th>
                        <th>Страна</th>
                        <th>Континент</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($city_array as $item) { ?>
                        <tr>
                            <td>
                                <a href="city.php?num=<?= $item['city_id']; ?>">
                                    <?= $item['city_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="team_list.php?city_id=<?= $item['city_id']; ?>">
                                    <?= $item['count_team']; ?>
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
                                <a href="city_edit.php?num=<?= $item['city_id']; ?>">
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