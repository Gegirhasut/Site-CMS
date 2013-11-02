<div id="component_wrap" class="clearfix gk-mass clear">
	<div>
		<h1 class="componentheading">
			<span>Оплата заказа</span>
		</h1>
		
	<div class="module-new">
	 <h3><span>Спасибо! Ваш заказ оплачен. Наш менеджер свяжется с Вами в ближайшее время.</span></h3>
	</div>
	
	<br/>
	
	{if isset($order_id)}<a href="http://arktida-opt.ru/order/{$order_id}">Детали заказа</a>{/if}
	
	<script>
		{literal}
		jQuery.getJSON(
		        "/cart/?operation=clean",
		        function (data) {
		        }
		);
		{/literal}
	</script>

 </div> 
</div>