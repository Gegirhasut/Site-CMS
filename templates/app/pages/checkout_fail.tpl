<div id="component_wrap" class="clearfix gk-mass clear">
	<div>
		<h1 class="componentheading">
			<span>Ошибка при оплате заказа</span>
		</h1>
		
	<div class="module-new">
	 <h3><span>Произошла ошибка при оплате заказа {if isset($order_id)}{$order_id}{/if}</span></h3>
	</div>
	
	<br/>
	{if isset($order_id)}<a href="http://arktida-opt.ru/order/{$order_id}">Попробовать еще раз</a>{/if}
	
 </div> 
</div>