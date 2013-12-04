<div class="car_description">
    <div>
        <h1>{$car.car_model} {$car.full_car_name} in {$car.city_name}</h1>
        <div class="price">{$car.price} Euro</div>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr style="line-height: 30px;text-align: left;">
                <td colspan="3" class="pub_date">Date of publication: <b>{$car.insert_date}</b>. Source: <b>{$car.source}.</b></td>
            </tr>
            <tr class="car_descr">
                <td width="300px" valign="top">
                    <div>
                        <a title="{$car.car_model} {$car.full_car_name}" href="/{$big_path}/{$car.preview_photo}" class="thickbox" id="prev_{$car.car_id}">
                            <img alt="{$car.car_model} {$car.full_car_name}" src="/{$small_path}/{$car.preview_photo}" width="301px" />
                        </a>
                    </div>
                    <div class="more_pictures">
                        {foreach from=$car.carsPhotos item=photo}
                            <div class="car_photo">
                                <a title="{$car.car_model} {$car.full_car_name}" href="/{$big_path}/{$photo.path}" class="thickbox" rel="car_{$car.car_id}">
                                    <img class="active" alt="{$car.car_model} {$car.full_car_name}" src="/{$small_path}/{$photo.path}" />
                                </a>
                            </div>
                        {/foreach}
                    </div>
                </td>
                <td width="10px"></td>
                <td valign="top">
                    <div class="information">
                        <div class="box">
                            <dl>
                                <dt>City:</dt>
                                <dd>{$car.city_name}</dd>
                            </dl>
                            <dl>
                                <dt>Year:</dt>
                                <dd>{$car.year}</dd>
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
                                <dd>{$car.engineShort}</dd>
                            </dl>
                            <dl>
                                <dt>Gear:</dt>
                                <dd>{$car.kpp}</dd>
                            </dl>
                            <dl>
                                <dt>Color:</dt>
                                <dd>{$car.color}</dd>
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
    </div>
</div>
<br>
<script>
    tb_init('a[rel=car_' + {$car.car_id} + '],a#prev_' + {$car.car_id});//apply thickbox
</script>