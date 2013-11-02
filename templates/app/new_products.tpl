<div class="moduletable nsp">
	<h3><span>Новинки</span></h3>
	<div class="moduletable_content">
		<div class="nsp_main nsp_fs100" id="nsp-nsp_68" style="width:100%;">
			<div class="nsp_arts bottom" style="width:100%;">
				
{foreach from=$new_records item=product name=foo}				
	<div class="nsp_art" style="float: left;padding: 5px;min-height: 80px;width: 187px;">
		
		<div style="padding:2px 0px; height: 155px;">
			<h4 class="nsp_header tleft fnone" title="{$product.name}" style="height:34px;text-align:center;overflow: hidden;"><a href="/products/{$product.url}">{$product.name}</a></h4>
			{if $product.img neq null}
				<div style="text-align: center;">
					<a href="/products/{$product.url}" title="{$product.name|escape:'quotes2'}">
						<img class="nsp_image tleft fnone" src="/images/small/{$product.img}" alt="{$product.name|escape:'quotes2'}" title="{$product.name|escape:'quotes2'}" style="border: none;max-height:100px;" />
					</a>
				</div>
			{/if}
		</div>

		<div style="color: red;">
			{if isset($opt_user)}
				{$product.opt_price} руб.
			{else}
				{$product.price} руб.
			{/if}
			<input style="width: 28px;margin: 0px 5px 0px 6px" id="c_{$product.r_id}" type="text" title="Количество" class="inputbox" size="4" maxlength="4" name="quantity" value="1" /> шт.
		</div>
		<div style="margin-top:5px;margin-left: 21px;">
			{if $product.visible eq 1}
	        	<input type="button" class="addtocart_button btn2" value="Купить " title="Купить" onclick="addProduct({$product.r_id})" />
	        {else}
	        	<span style="padding-left: 20px;color: #0060AF">Нет в наличии</span>
	        {/if}
        </div>
	</div>
	
	{if $smarty.foreach.foo.index eq 3 or $smarty.foreach.foo.index eq 7 or $smarty.foreach.foo.index eq 11 or $smarty.foreach.foo.index eq 15 or $smarty.foreach.foo.index eq 19  }
		<div style="clear: both;"></div>
		<div style="background: #dbdbdb; height: 1px; width: 100%;margin-bottom: 15px;" ></div>
	{/if}
{/foreach}
			</div>
		</div>
	</div>
</div>

{include file="units/certificates.tpl"}