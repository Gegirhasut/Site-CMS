<div id="component_wrap" class="clearfix gk-mass clear">
	<div>
		<h1 class="componentheading">
			<span>Результаты поиска</span>
		</h1>
		<div style="padding:0px 10px 0px 0px;">
		
			<div>Найдено: {$results|@count} товаров</div>
			<div style="padding-top: 10px;">
				<table width="100%" cellpadding="0" cellspacing="0" class="search_results">
					<tr>
						<th width="50">Номер</th>
						<th width="100">Код товара</th>
						<th style="text-align:left">Наименование</th>
					</tr>
					{foreach from=$results item=product name=p}
						<tr>
							<td>{$smarty.foreach.p.index+1}</td>
							<td>{$product.code}</td>
							<td style="text-align:left"><a href="/products/{$product.url}">{$product.name}</a></td>
						</tr>
					{/foreach}
				</table>
			</div>
		
		</div>
	</div>
</div>

{include file="units/jquery_notice.tpl"}