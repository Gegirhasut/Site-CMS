<div class="search">
        <input type="hidden" name="search" value="submit" />
        <div class="search">
            <div class="search__short search__short-main">
                <div class="fieldset">
                    <span class="f_title">Year</span>
                    <input class="au-input-text plugin-list-helper ui-autocomplete-input" id="year_min" maxlength="4" value="{$filters.year_min}" />
                    —
                    <input class="au-input-text plugin-list-helper ui-autocomplete-input" id="year_max" maxlength="4" value="{$filters.year_max}" />
                </div>
                <div class="fieldset">
                    <span class="f_title">Price</span>
                    <input class="au-input-text plugin-list-helper ui-autocomplete-input" id="price_min" maxlength="8" value="{$filters.price_min}" />
                    —
                    <input class="au-input-text plugin-list-helper ui-autocomplete-input" id="price_max" maxlength="8" value="{$filters.price_max}" />
                </div>
                <div class="fieldset">
                    <span class="f_title">Mileage till</span>
                    <input class="au-input-text plugin-list-helper ui-autocomplete-input" id="mileage_max" maxlength="8" value="{$filters.mileage_max}" style="width:100px;" />
                </div>
                <div class="fieldset">
                    <span class="f_title">Engine Capacity till</span>
                    <input class="au-input-text plugin-list-helper ui-autocomplete-input" id="ec" maxlength="5" value="{$filters.ec_max}" />
                </div>
                <div class="fieldset">
                    <span class="f_title">Model</span>
                    <input class="au-input-text plugin-list-helper ui-autocomplete-input" style="width: 180px;" id="model" name="model" maxlength="5" onkeyup="fillModel()" autocomplete="off" value="{$filters.model}" />
                    <input type="hidden" id="car_model_id" value="{$filters.car_model_id}" />
                </div>
                <div class="fieldset" style="float: right;">
                    <input class="au-button au-button-search search__button" type="submit" value="Search" onclick="sendSearch()"/>
                </div>
                <div style="clear: both"></div>
            </div>
        </div>
        <div style="padding: 10px 0px;">
            Choose your city &nbsp;&nbsp;
            {foreach from=$cities item=city}
                <a {if $filters.city_id eq $city.city_id}style="font-weight:bold;"{/if} href="/city/{$city.city_name}/{$city.city_id}/" class="text2" title="Buy cars in {$city.city_name}">{$city.city_name}</a>
                &nbsp;&nbsp;
            {/foreach}
            <a href="/" {if !isset($filters.city_id)}style="font-weight:bold;"{/if} class="text2" title="Buy cars in Cyprus">All cities</a>
            {if isset($filters.city_id)}
                <input type="hidden" id="city_id" value="{$filters.city_id}" />
                <input type="hidden" id="city" value="{$filters.city}" />
            {/if}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Type: &nbsp;&nbsp;
            <a {if $filters.type eq 1}style="font-weight:bold;"{/if} href="javascript:;" class="text2" title="Buy cars in Cyprus" onclick="selectType(1)">Cars only</a>
            &nbsp;&nbsp;
            <a {if $filters.type eq 2}style="font-weight:bold;"{/if} href="javascript:;" class="text2" title="Buy motorcycle in Cyprus" onclick="selectType(2)">Motorcycles only</a>
            &nbsp;&nbsp;
            <a href="javascript:;" {if !isset($filters.type) || $filters.type eq 0}style="font-weight:bold;"{/if} class="text2" title="Buy cars and motorcycles in Cyprus" onclick="selectType(0)">All types</a>
            <input type="hidden" id="type" value="{$filters.type}" />
        </div>
</div>