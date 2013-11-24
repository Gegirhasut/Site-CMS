<table id="cars_table" cellpadding="0" cellspacing="0" width="1120px">
    <tr>
        <th>
            <a href="javascript:;" onclick="orderByDate()" title="Order by date">Date<span class="au-icon-{if $filters.orderByDate eq 1}up{elseif $filters.orderByDate eq 2}down{elseif !isset($filters.orderByDate)}down{/if}"></span></a>
            <input type="hidden" value="{if isset($filters.orderByDate)}{$filters.orderByDate}{else}0{/if}" id="orderByDate" />
        </th>
        <th>Photo</th>
        <th width="270">Model</th>
        <th>Year</th>
        <th>Mileage</th>
        <th>Power</th>
        <th>Engine</th>
        <th>Gear</th>
        <th>
            <a href="javascript:;" onclick="orderByPrice()" title="Order by price">Price<span class="au-icon-{if $filters.orderByPrice eq 1}up{elseif $filters.orderByPrice eq 2}down{/if}"></span></a>
            <input type="hidden" value="{if isset($filters.orderByPrice)}{$filters.orderByPrice}{else}0{/if}" id="orderByPrice" />
        </th>
    </tr>
    {foreach from=$cars item=car}
    <tr class="car_tr" onclick="showCar(this, '{$car.car_id}', {$car.photos})" id="tr_{$car.car_id}">
        <td>{$car.insert_date}</td>
        <td class="photo">
            <div style="height: 103px;overflow: hidden">
                <img alt="{$car.car_model} {$car.full_car_name}" src="/{$small_path}/{$car.preview_photo}" />
            </div>
        </td>
        <td class="model">
            <input type="hidden" id="car_model_{$car.car_id}" value="{$car.car_model} {$car.full_car_name}" />
            <a class="text" onclick="showCar(this, '{$car.car_id}', {$car.photos})" target="_blank" href="/car/{$car.car_model}/{$car.car_id}" title="{$car.car_name}">{$car.car_name}</a>
            <a class="blank" onclick="showCar(this, '{$car.car_id}', {$car.photos})" target="_blank" href="/car/{$car.car_model}/{$car.car_id}" title="Open in new window"></a>
            <div class="city">
                {$car.saloon} {$car.engineShort} {$car.carburation}
            </div>
        </td>
        <td>{$car.year}</td>
        <td>{$car.probeg} km</td>
        <td>{$car.power} {$car.powerType}</td>
        <td>{$car.engineShort}</td>
        <td>{$car.kpp}</td>
        <td>
            {$car.price}
            <div class="city">
                <a onclick="showCar(this, '{$car.car_id}', {$car.photos})" href="/city/{$car.city_name}/{$car.city}/" class="text2" title="Buy cars in {$car.city_name}">{$car.city_name}</a>
            </div>
        </td>
    </tr>
    <tr class="car_descr" id="car_descr_{$car.car_id}">
        <td>&nbsp;</td>
        <td colspan="8" class="td8">
            <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="300px" valign="top">
                        <div>
                            <img alt="{$car.car_model} {$car.full_car_name}" src="/{$big_path}/{$car.preview_photo}" width="301px" />
                        </div>
                        <div class="more_pictures">
                            {if $car.photos gt 0}
                                <div class="car_photo">
                                    <a title="{$car.car_model} {$car.full_car_name}" href="/{$big_path}/{$car.preview_photo}" class="thickbox" rel="car_{$car.car_id}">
                                        <img class="active" alt="{$car.car_model} {$car.full_car_name}" src="/{$small_path}/{$car.preview_photo}" />
                                    </a>
                                </div>
                            {/if}
                            {if $car.photos eq 1}
                                <script>
                                    tb_init("a[rel=car_{$car.car_id}],a#prev_{$car.car_id}");
                                </script>
                            {/if}
                        </div>
                        <div style="clear: both;"></div>
                        <div style="padding-top: 10px;">
                            Source: <b>{$car.source}</b>
                        </div>
                    </td>
                    <td width="10px"></td>
                    <td valign="top">
                        <div class="information">
                            <div class="box">
                                <dl>
                                    <dt>City:</dt>
                                    <dd>{$car.city_name}&nbsp;</dd>
                                </dl>
                                <dl>
                                    <dt>Year:</dt>
                                    <dd>{$car.year}&nbsp;</dd>
                                </dl>
                                <dl>
                                    <dt>Price:</dt>
                                    <dd><b>{$car.price} Euro</b></dd>
                                </dl>
                                <br>
                                <dl>
                                    <dt>Mileage:</dt>
                                    <dd>{$car.probeg} km</dd>
                                </dl>
                                <dl>
                                    <dt>Power:</dt>
                                    <dd>{$car.power} hf</dd>
                                </dl>
                                <dl>
                                    <dt>Engine:</dt>
                                    <dd>{$car.engine}&nbsp;</dd>
                                </dl>
                                <dl>
                                    <dt>Gear:</dt>
                                    <dd>{$car.kpp}&nbsp;</dd>
                                </dl>
                                <dl>
                                    <dt>Color:</dt>
                                    <dd>{$car.color}&nbsp;</dd>
                                </dl>
                                <dl>
                                    <dt>Saloon:</dt>
                                    <dd>{$car.saloon}&nbsp;</dd>
                                </dl>
                                <div class="additional">
                                    {$car.info|trim}
                                </div>
                            </div>
                        </div>

                        <div class="information contacts">
                            <div class="box">
                                <dl>
                                    <dt>Name:</dt>
                                    <dd>{$car.name}</dd>
                                </dl>
                                <dl class="phone">
                                    <dt><div></div></dt>
                                    <dd><strong>{$car.phone}</strong></dd>
                                </dl>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {/foreach}
</table>

<table cellpadding="0" cellspacing="0" width="1120px">
    <tr>
        <td>
            {include file="units/pager.tpl"}
        </td>
    </tr>
</table>