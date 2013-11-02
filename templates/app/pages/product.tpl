<div id="component_wrap" class="clearfix gk-mass clear">
	<div>
		<div id="component" class="clear">
			<div id="vmMainPage">
				<div class="buttons_heading">
				</div> 
				<span style="float: left;color: #0060AF;"><a href="/" style="color: #0060AF;">Главная</a>&nbsp;→&nbsp;</span>
				<span style="float: left;color: #0060AF;"><a href="/{if $product.p_cat_url neq null}{$product.p_cat_url}/{/if}{$product.cat_url}" style="color: #0060AF;">{$product.cat_name}</a>&nbsp;→&nbsp;</span>
				<h1>{$product.name}</h1>
				<hr/>
				
				<table border="0" style="width: 100%;">
  					<tbody>
  						<tr>
  							<td colspan="2">
  								<b>Код по прайсу:</b> {$product.code}
  							</td>
  						</tr>
  						<tr>
  							<td colspan="2">
  								<h2 style="color: black;font-size: 18px;">{$product.name}</h2>
  							</td>
  						</tr>
						<tr>
							{if $product.img neq null}
      						<td width="33%" valign="top" align="left">
									<br/><br/>
									<a href="/images/upload/{$product.img}" title="{$product.name|escape:'quotes2'}" class="thickbox" rel="images">
										<img class="nsp_image tleft fnone" src="/images/small/{$product.img}" alt="{$product.name|escape:'quotes2'}" title="{$product.name|escape:'quotes2'}" style="border: none;" />
									</a>
								{if $product.img1 neq null}
									<br>
									<a href="/images/upload/{$product.img1}" title="{$product.name|escape:'quotes2'}" class="thickbox" rel="images">
										<img class="nsp_image tleft fnone" src="/images/small/{$product.img1}" alt="{$product.name|escape:'quotes2'}" title="{$product.name|escape:'quotes2'}" style="border: none;width: 56px;" />
									</a>
									{if $product.img2 neq null}
										<a href="/images/upload/{$product.img2}" title="{$product.name|escape:'quotes2'}" class="thickbox" rel="images">
											<img class="nsp_image tleft fnone" src="/images/small/{$product.img2}" alt="{$product.name|escape:'quotes2'}" title="{$product.name|escape:'quotes2'}" style="border: none;width: 56px;" />
										</a>
									{/if}
									{if $product.img3 neq null}
										<a href="/images/upload/{$product.img3}" title="{$product.name|escape:'quotes2'}" class="thickbox" rel="images">
											<img class="nsp_image tleft fnone" src="/images/small/{$product.img3}" alt="{$product.name|escape:'quotes2'}" title="{$product.name|escape:'quotes2'}" style="border: none;width: 56px;" />
										</a>
									{/if}
								{/if}
							</td>
							{/if}
							<td>
								<br>
								<strong>Цена: </strong> 
								<span class="productPrice">
									{if isset($opt_user)}
										{$product.opt_price} руб
									{else}
										{$product.price} руб
									{/if}
								</span>
								<br><br>
								{if $product.visible eq 1}
									{if $product.date_way neq ''}
										В пути {$product.date_way}
									{else}
										<input style="width: 28px;float:left; margin-right: 5px;" id="c_{$product.r_id}" type="text" title="Количество" class="inputbox" size="4" maxlength="4" name="quantity" value="1" />
										<input type="button" class="addtocart_button btn2" value="Купить " title="Купить" onclick="addProduct({$product.r_id})">
									{/if}
								{else}
									Нет в наличии
								{/if}
								
								{if $product.description neq ''}
									<br>
									{$product.description}
								{/if}
							</td>
						</tr>
					
						<tr>
							<td colspan="2">
								<br><br>
      							Xарактеристики, комплект поставки и внешний вид данного товара могут отличаться от 
      							указанных или могут быть изменены производителем без отражения в каталоге.
							</td>
						</tr>
						
						<tr>
	  						<td colspan="3"><hr></td>
						</tr>
						<tr>
	  						<td colspan="3"><br></td>
						</tr>
  					</tbody>
				</table>
				
				
				
				<div id="statusBox" style="text-align:center;display:none;visibility:hidden;"></div>
			</div>
		</div>
	</div>
</div>

{include file="units/certificates.tpl"}

{include file="app/akcii.tpl"}