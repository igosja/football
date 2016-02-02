<table class="block-table w100">
    <tr>
        <td class="block-page w10">
            <p class="header">Схема</p>
            <div id="field-icon" class="relative"></div>
            <img src="img/field/tactic-player.png" />
            <input type="hidden" value="{$lineup_array.0.lineupcurrent_formation_id}" id="tactic-player-formation-national">
        </td>
        <td class="block-page w45" rowspan="2" id="position-block">
            <p class="header">Позиция <span id="position-name"></span></p>
            <table>
                <tr>
                    <td id="role-name"></td>
                </tr>
            </table>
            <p id="role-description"></p>
        </td>
        <td class="block-page">
            <p class="header"><span id="player-name"></span></p>
            <table class="none striped w100" id="player-table">
                <tr>
                    <td>Игрок</td>
                    <td id="table-player-name"></td>
                </tr>
                <tr>
                    <td class="w50">Позиция</td>
                    <td id="table-player-position-name"></td>
                </tr>
                <tr>
                    <td>Количество игр на позиции</td>
                    <td id="table-player-position-game"></td>
                </tr>
                <tr>
                    <td>Средняя оценка</td>
                    <td id="table-player-mark"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>