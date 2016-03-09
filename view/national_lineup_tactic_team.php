<table class="block-table w100">
    <tr>
        <td class="block-page w50" id="tactic-block">
            <p class="header">Общие</p>
            <table class="w100">
                <tr>
                    <td class="w50">Стиль игры</td>
                    <td>
                        <select id="gamestyle-select-national">
                            {section name=i loop=$gamestyle_array}
                                <option value="{$gamestyle_array[i].gamestyle_id}"
                                    {if ($gamestyle_array[i].gamestyle_id == $lineup_array.0.lineupcurrent_gamestyle_id)}
                                        selected
                                    {/if}
                                >{$gamestyle_array[i].gamestyle_name}</option>
                            {/section}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Настрой на игру</td>
                    <td>
                        <select id="gamemood-select-national">
                            {section name=i loop=$gamemood_array}
                                <option value="{$gamemood_array[i].gamemood_id}"
                                    {if ($gamemood_array[i].gamemood_id == $lineup_array.0.lineupcurrent_gamemood_id)}
                                        selected
                                    {/if}
                                >{$gamemood_array[i].gamemood_name}</option>
                            {/section}
                        </select>
                    </td>
                </tr>
            </table>
            <table class="w100">
                <tr>
                    <td id="gamestyle"><h6>{$lineup_array.0.gamestyle_name}</h6>{$lineup_array.0.gamestyle_description}</td>
                </tr>
            </table>
            <br />
            <table class="w100">
                <tr>
                    <td id="gamemood"><h6>{$lineup_array.0.gamemood_name}</h6>{$lineup_array.0.gamemood_description}</td>
                </tr>
            </table>
        </td>
        <td class="block-page" id="instruction-block">
            <p class="header">Инструкции</p>
            <table class="w100">
                <tr>
                    <td>
                        {section name=i loop=$instruction_array}
                            {if (!isset($instruction_array[i.index_prev].instructionchapter_id) ||
                                 $instruction_array[i.index_prev].instructionchapter_id != $instruction_array[i].instructionchapter_id)}
                                {if (2 == $instruction_array[i].instructionchapter_id ||
                                     4 == $instruction_array[i].instructionchapter_id)}
                                </td><td class="w33">
                                {/if}
                                <table class="striped w100">
                                    <tr>
                                        <th colspan="2">{$instruction_array[i].instructionchapter_name}</th>
                                    </tr>
                            {/if}
                            <tr>
                                <td class="nopadding w1">
                                    <input
                                        class="instruction-checkbox-national"
                                        type="checkbox"
                                        value="{$instruction_array[i].instruction_id}"
                                        {section name=j loop=$teaminstruction_array}
                                            {if ($teaminstruction_array[j].teaminstruction_instruction_id == $instruction_array[i].instruction_id)}
                                                checked
                                            {/if}
                                        {/section}
                                    />
                                </td>
                                <td>
                                    {$instruction_array[i].instruction_name}
                                </td>
                            </tr>
                            {if (!isset($instruction_array[i.index_next].instructionchapter_id) ||
                                $instruction_array[i.index_next].instructionchapter_id != $instruction_array[i].instructionchapter_id)}
                                </table>
                            {/if}
                        {/section}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>