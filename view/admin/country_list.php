<div class="row">
    <div class="col-lg-12 text-center">
        <h1 class="page-header">Страны (<?= $count_country; ?>)</h1>
        <ul class="list-inline preview-links text-center">
            <li>
                <a href="continent_list.php" class="btn btn-default">
                    <i class="fa fa-list"></i>
                </a>
            </li>
            <li>
                <a href="country_create.php" class="btn btn-default">
                    <i class="fa fa-plus"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="dataTable_wrapper">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Страна</th>
                        <th>Городов</th>
                        <th>Команд</th>
                        <th>Континент</th>
                        <th class="col-lg-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($country_array as $item) { ?>
                        <tr>
                            <td>
                                <img src="/img/flag/12/<?= $item['country_id']; ?>.png" />
                                <a href="country.php?num=<?= $item['country_id']; ?>">
                                    <?= $item['country_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="city_list.php?country_id=<?= $item['country_id']; ?>">
                                    <?= $item['count_city']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="team_list.php?country_id=<?= $item['country_id']; ?>">
                                    <?= $item['count_team']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="continent.php?num=<?= $item['continent_id']; ?>">
                                    <?= $item['continent_name']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="country_edit.php?num=<?= $item['country_id']; ?>">
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