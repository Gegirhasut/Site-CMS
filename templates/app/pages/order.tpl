<div id="component_wrap" class="clearfix gk-mass clear">
	{if isset($order)}
		<div>
			<h1 class="componentheading">
				<span>Заказ {$order.o_id} {if $order.payed eq 1}оплачен{else}принят{/if}</span>
			</h1>
			<div style="padding:0px 10px 0px 0px;">
				<table>
					<tr>
						<td><b>Имя:</b> {$order.fio}</td>
					</tr>
					{if $order.organisation neq ''}
						<tr>
							<td><b>Организация:</b> {$order.organisation}</td>
						</tr>
					{/if}
					<tr>
						<td><b>Телефон:</b> {$order.phone}</td>
					</tr>
					<tr>
						<td><b>Email:</b> {$order.email}</td>
					</tr>
					<tr>
						<td><b>Город:</b> {$order.city}</td>
					</tr>
				</table>
				
				<br/>
				
				{if $order.payment_type eq 1}
					<b>Способ оплаты:</b> Оплатить наличными при получении<br/>
				{/if}
				{if $order.payment_type eq 2}
					<b>Способ оплаты:</b> Оплатить сейчас (электронный платеж){if $order.payed eq 1}, <b>заказ оплачен</b>{/if}<br/>
				{/if}
				
				{if $order.delivery_type eq 1}
					<b>Способ получения товара:</b> Доставка до двери (1-2 рабочих дня)<br/>
				{/if}
				{if $order.delivery_type eq 2}
					<b>Способ получения товара:</b> Самовывоз со склада (г. Новосибирск, ул. Автогенная, 122)<br/>
				{/if}
				{if isset($discount)}
					<b>Скидочная карта:</b> {$discount}, скидка {$discount_percent} %<br/>
				{/if}
				
				<br/>
				
	            <table width="100%" cellspacing="2" cellpadding="4" border="0" class="cart_table">
	                <tbody>
	                    <tr align="left" class="sectiontableheader">
	                        <th>Картинка</th>
	                        <th style="text-align: left;">Название</th>
	                        <th>Артикул</th>
	                        <th>Цена</th>
	                        <th>Количество</th>
	                        <th>Итого</th>
	                    </tr>
	                    
	                    {foreach from=$products item=product}
	                    
	                        <tr valign="top" class="sectiontableentry1" id="tr_{$product.r_id}">
	                            
	                            <td>
                                   {if $product.img neq null}
                                       <a href="/images/upload/{$product.img}" title="{$product.name}" class="thickbox">
                                           <img src="/images/small/{$product.img}" alt="Увеличить картинку" height="80px;">
                                       </a>
                                   {else}
                                       -
                                   {/if}
	                            </td>
	                            
	                            <td style="text-align: left;">
	                                <!-- <a href="/images/upload/{$product.img}" title="{$product.name}" class="thickbox"> -->
	                                	<strong>{$product.name}</strong>
	                                <!-- </a> -->
	                            </td>
	                              
	                            <td style="width: 50px">&nbsp;{$product.code}&nbsp;</td>
	                            <td style="width: 150px">
	                                &nbsp;{$product.price} руб.&nbsp;
	                            </td>
	                            <td align="center" style="width:180px">
	                                {$product.count}
	                          </td>
	                          <td style="width: 100px" align="right">&nbsp;<span id="p_{$product.r_id}">{$product.totalPrice}</span> руб.&nbsp;</td>
	                      </tr>
	                      
	                  {/foreach}
	                  
	                  <tr class="sectiontableentry1">
	                      <td style="text-align: left;">Итого: </td>
	                      <td colspan="3">&nbsp;</td>
	                      <td align="right"><strong>{$totalCount}</strong></td>
	                      <td align="right"><strong><span id="total_price">{$totalPrice}</span> руб.</strong></td>
	                  </tr>
	                  {if isset($totalDiscountPrice)}
		                  <tr class="sectiontableentry1">
		                      <td style="text-align: left;" colspan="5">Итого со скидкой ({$discount_percent} %): </td>
		                      <td align="right"><strong><span id="total_price">{$totalDiscountPrice}</span> руб.</strong></td>
		                  </tr>
	                  {/if}
	                  <tr>
	                      <td colspan="7">&nbsp;</td>
	                  </tr>
	              </tbody>
	          </table>
	    	</div>
	
		</div>

		Ваш заказ принят и находится в обработке.<br/>
		Наш менеджер свяжется с вами для подтверждения заказа в ближайшие рабочие часы.
		<br/><br/>
		
		{if $order.payed neq 1 && $order.payment_type eq 2}
			<form method="post" action="https://www.moneta.ru/assistant.htm">
				<input type="hidden" name="MNT_ID" value="65237202">
				<input type="hidden" name="MNT_TRANSACTION_ID" value="{$order.o_id}">
				<input type="hidden" name="MNT_CURRENCY_CODE" value="RUB">
				<input type="hidden" name="MNT_AMOUNT" value="{if isset($totalDiscountPrice)}{$totalDiscountPrice}{else}{$totalPrice}{/if}">
				<input type="hidden" name="paymentSystem.unitId" value="499669">
				<input type="submit" value="Оплатить заказ">
			</form>
		{/if}
	{/if}
</div>

{if isset($clean_cart)}
<script>
	{literal}
	jQuery.getJSON(
	        "/cart/?operation=clean",
	        function (data) {
	        }
	);
	{/literal}
</script>
{/if}

{include file="units/jquery_notice.tpl"}