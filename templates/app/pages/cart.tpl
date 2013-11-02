<div id="component_wrap" class="clearfix gk-mass clear">
	<div>
		<h1 class="componentheading">
			<span>Ваша корзина</span>
		</h1>
		<div style="padding:0px 10px 0px 0px;">
            <!-- Cart Begins here -->
            <table width="100%" cellspacing="2" cellpadding="4" border="0" class="cart_table">
                <tbody>
                    <tr align="left" class="sectiontableheader">
                        <!-- <th>Картинка</th> -->
                        <th style="text-align: left;">Название</th>
                        <th>Артикул</th>
                        <th>Цена</th>
                        <th>Количество / Обновить</th>
                        <th>Итого</th>
                    </tr>
                    
                    {foreach from=$products item=product}
                    
                        <tr valign="top" class="sectiontableentry1" id="tr_{$product.r_id}">
                            <!--
                            <td>
                               <a href="/{$big_path}/{$product.img}" title="{$product.name}" class="thickbox">
                                   <img src="/{$small_path}/{$product.img}" alt="Увеличить картинку" height="80px;">
                               </a>
                            </td>
                            -->
                            <td style="text-align: left;">
                                <!-- <a href="/images/upload/{$product.img}" title="{$product.name}" class="thickbox"> -->
                                	<strong>{$product.name}</strong>
                                <!-- </a> -->
                            </td>
                              
                            <td style="width: 50px">&nbsp;{$product.code}&nbsp;</td>
                            <td style="width: 150px">
                                {if isset($opt_user)}
                            		&nbsp;{$product.opt_price} руб.&nbsp;
                            	{else}
                                	&nbsp;{$product.price} руб.&nbsp;
                                {/if}
                            </td>
                            <td align="center" style="width:180px">
                                <input style="width: 28px;" id="c_{$product.r_id}" type="text" title="Обновить количество в корзине" class="inputbox" size="4" maxlength="4" name="quantity" value="{$product.count}">
                                <input class="action" onclick="updateProduct({$product.r_id})" type="image" name="update" title="Обновить количество в корзине" src="/images/app/update_quantity_cart.png" alt="Обновить количество в корзине" align="middle">
                                <input class="action" onclick="updateProduct({$product.r_id}, 0)" type="image" name="delete" title="Удалить из корзины" src="/images/app/remove_from_cart.png" alt="Удалить из корзины" align="middle">
                          </td>
                          <td style="width: 100px" align="right">&nbsp;<span id="p_{$product.r_id}">{$product.totalPrice}</span> руб.&nbsp;</td>
                      </tr>
                      
                  {/foreach}
                  
                  <tr class="sectiontableentry1">
                      <td colspan="4"  style="text-align: left;">Итого к оплате: </td>
                      <td colspan="2" align="right"><strong><span id="total_price">{$totalPrice}</span> руб.</strong></td>
                  </tr>
                  <tr>
                      <td colspan="7">&nbsp;</td>
                  </tr>
              </tbody>
          </table>
    	</div>

	    <div style="padding:2px 20px 0px 30px;">
	        
	        <div style="text-align:center; display: none;" id="issue_order">
	            <input style="margin-left: 280px;" type="button" class="addtocart_button btn2" value="Оформить заказ" title="Оформить заказ" onclick="location.href='/checkout/'" >
	        </div>
	    </div>

	</div>
</div>

{include file="units/jquery_notice.tpl"}