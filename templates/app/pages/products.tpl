<script>
{literal}
	function selectShow() {
		var newLoc = location.href.split('?')[0] + '?show=' + jQuery('#show_count').val();
		location.href = newLoc;
	}
	
	function sort(column, direction) {
		var newLoc = location.href.split('?')[0] + '?sort=' + column + '&direction=' + direction;
		location.href = newLoc;
	}
{/literal}
</script>
<div id="component_wrap" class="clearfix gk-mass clear">
	<div>
		<div id="component" class="clear">
    		<div id="vmMainPage">
				<div class="buttons_heading">
				</div>
				<span style="float: left;color: #0098ca;"><a href="/" style="color: #0098ca;">Главная</a>&nbsp;→&nbsp;</span>
				<h1>{$category_name}</h1>
				<hr/>
<br/>
<table class="products_table" width="100%">
	<tbody>
		<tr>
			<td class="nameal" style="text-align:center;"><h4>Сортировка</h4></td>
			<td class="nameal">
				<h4>
					По названию
					<a title="Сортировать по названию" href="javascript:;" onclick="sort('name', 1)"><img border="0" src="/images/upload/arrow_up_16_ns.png" /></a>
					<a title="Сортировать по названию" href="javascript:;" onclick="sort('name', 0)"><img border="0" src="/images/upload/arrow_down_16_ns.png" /></a>
				</h4>
			</td>
			<td style="text-align:center;" >
				<h4>
					По цене
					<a title="Сортировать по цене" href="javascript:;" onclick="sort('price', 1)"><img border="0" src="/images/upload/arrow_up_16_ns.png" /></a>
					<a title="Сортировать по цене" href="javascript:;" onclick="sort('price', 0)"><img border="0" src="/images/upload/arrow_down_16_ns.png" /></a>
				</h4>
			</td>
			<td style="text-align:center;" >
				<h4>
					По коду прайса
					<a title="Сортировать по коду" href="javascript:;" onclick="sort('code', 1)"><img border="0" src="/images/upload/arrow_up_16_ns.png" /></a>
					<a title="Сортировать по коду" href="javascript:;" onclick="sort('code', 0)"><img border="0" src="/images/upload/arrow_down_16_ns.png" /></a>
				</h4>
			</td>
			<td width="180"></td>
		</tr>
		<tr><td colspan="5"><hr/></td></tr>
		<tr><td colspan="5">
			
				{foreach from=$records item=product name=foo}
					<div class="nsp_art" style="float: left;padding: 5px;min-height: 80px;width: 180px;">
		
						<div style="padding:2px 0px; height: 135px;">
							<h4 class="nsp_header tleft fnone" title="{$product.name}" style="height:37px;text-align:center;overflow: hidden;"><a href="/products/{$product.url}">{$product.name}</a></h4>
							{if $product.img neq null}
								<div style="text-align: center;">
									<a href="/products/{$product.url}" title="{$product.name|escape:'quotes2'}">
										<img class="nsp_image tleft fnone" src="/images/small/{$product.img}" alt="{$product.name|escape:'quotes2'}" title="{$product.name|escape:'quotes2'}" style="border: none;max-height:90px;" />
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
							{if $product.visible eq 0 || $product.date_way neq ''}
								{if $product.date_way neq ''}
									<span style="padding-left: 10px;color: #0060AF">В пути {$product.date_way}</span>
								{else}
									<span style="padding-left: 20px;color: #0060AF">Нет в наличии</span>
								{/if}
					        {else}
					        	<input type="button" class="addtocart_button btn2" value="Купить" title="Купить" onclick="addProduct({$product.r_id})" />
					        {/if}
				        </div>
					</div>
					
					{if $smarty.foreach.foo.index eq 3 or $smarty.foreach.foo.index eq 7 or $smarty.foreach.foo.index eq 11 or $smarty.foreach.foo.index eq 15 or $smarty.foreach.foo.index eq 19  }
						<div style="clear: both;"></div>
						<div style="background: #dbdbdb; height: 1px; width: 100%;margin-bottom: 15px;" ></div>
					{/if}
				{/foreach}
			</td></tr>
			
	</tbody>
</table>

{include file="units/pager.tpl"}
<div style="float: right; margin-top: 10px;">
	Выводить по
	<select name="show_count" id="show_count" onchange="selectShow();">
  	  <option {if $show eq 20}selected{/if} value="20">20</option>
	  <option {if $show eq 40}selected{/if} value="40">40</option>
	  <option {if $show eq 60}selected{/if} value="60">60</option>
	  <option {if $show eq 80}selected{/if} value="80">80</option>
	  <option {if $show eq 100}selected{/if} value="100">100</option>
	  <option {if $show eq 3000}selected{/if} value="3000">все</option>
	</select> 
	штук
</div>
			</div>
		</div>
	</div>
</div>

{include file="units/certificates.tpl"}