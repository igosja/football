<table class="block-table w100">
    <tr>
        <td class="block-page w33">
            <p class="header">Оплата членских взносов в VIP-клубе</p>
            <p class="center">
                Вы собираетесь оплатить членский взнос в VIP на <?= $get_vip; ?> дней за <?= $vip_array[$get_vip]; ?> единиц.
            </p>
            <p class="center">
                <a href="shop.php?vip=<?= $get_vip; ?>&ok=1" class="button-link"><button>Подвердить</button></a>
                <a href="shop.php" class="button-link"><button>Отказаться</button></a>
            </p>
        </td>
    </tr>
</table>
