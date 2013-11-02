<div id="component_wrap" class="clearfix gk-mass clear">
	<div>
		<h1 class="componentheading">
			<span>Оформление заказа</span>
		</h1>
		
	<div class="module-new">
	 <h3><span>После оформления заказа с Вами свяжется наш менеджер.</span></h3>
	 <div class="boxIndent"> 
	  
	  
	  <div class="stretcher" id="register_stretcher" style="padding-top: 0px; border-top-style: none; border-top-width: initial; border-top-color: initial; padding-bottom: 0px; border-bottom-style: none; border-bottom-width: initial; border-bottom-color: initial; overflow-x: hidden; overflow-y: hidden; visibility: visible; zoom: 1; opacity: 1; ">
	  
	   <div style="width:90%;">
	    <div style="padding:5px;text-align:center;">
	     <strong>(* = Обязательное поле)</strong>
	     {if isset ($error)}
	     	 <br/>
		     <span style="color: red;">
		     	{$error}
		     </span>
	     {/if}
	    </div>
	    
	    <form method="post" id="zakaz">
	    
	    <fieldset>
	      
	      <div id="name_div" class="formLabel ">
	       <label for="name">Контактное лицо</label>
	      </div>
	      <div class="formField" id="name_input">
	       <input type="text" id="fio" name="fio" size="30" value="" class="inputbox" maxlength="100" />
	       <br/>
	      </div>
	      <br style="clear:both;" />
	      
	      <div id="name_div" class="formLabel ">
	       <label for="name">Организация</label>
	      </div>
	      <div class="formField" id="organisation_input">
	       <input type="text" id="organisation" name="organisation" size="30" value="" class="inputbox" maxlength="100" />
	       <br/>
	      </div>
	      <br style="clear:both;" />
	      
	      <div id="phone_div" class="formLabel ">
	       <label for="phone">Телефон</label>
	      </div>
	      <div class="formField" id="phone_input">
	       <input type="text" id="phone" name="phone" size="30" value="" class="inputbox" maxlength="100" />
	       <br/>
	      </div>
	      <br style="clear:both;" />
	      
	      <div id="email_div" class="formLabel ">
	       <label for="email_field">Email</label>
	       <strong>* </strong>
	      </div>
	      <div class="formField" id="email_input">
	       <input type="text" id="email" name="email" size="30" value="" class="inputbox" maxlength="100" />
	       <br/>
	      </div>
	      <br style="clear:both;" />
	      
	      
	      <div id="city_div" class="formLabel ">
	       <label for="city">Город</label>
	      </div>
	      <div class="formField" id="city_input">
	       <input type="text" id="city" name="city" size="30" value="" class="inputbox" maxlength="50" />
	       <br/>
	      </div>
	      <br style="clear:both;" />
	      
	      <div id="discount_div" class="formLabel ">
	       <label for="discount">Скидочная карта</label>
	      </div>
	      <div class="formField" id="city_input">
	       <input type="text" id="discount" name="discount" size="30" value="" class="inputbox" maxlength="50" />
	       <!-- <input type="button" value=" Проверить " onclick="checkDiscount()" /> -->
	       <span style="color: red;" id="discount_info"></span>
	      </div>
	      <br style="clear:both;" />
	      
	      <div class="formLabel ">
	       <label for="payment_type">Способ оплаты</label>
	      </div>
	      <div class="formField" id="payment_type_input">
	       <select id="payment_type" name="payment_type" class="inputbox">
	       	<option value="1">Оплатить наличными при получении</option>
	       	<option value="2">Оплатить сейчас (электронный платеж)</option>
	       </select>
	       <br/>
	      </div>
	      <br style="clear:both;" />
	      
	      <div class="formLabel ">
	       <label for="delivery_type">Способ получения товара</label>
	      </div>
	      <div class="formField" id="delivery_type_input">
	       <select id="delivery_type" name="delivery_type" class="inputbox">
	       	<option value="1">Доставка до двери (1-2 рабочих дня)</option>
	       	<option value="2">Самовывоз со склада (г. Новосибирск, ул. Автогенная, 122)</option>
	       </select>
	       <br/>
	      </div>
	      <br style="clear:both;" />
	      
	      <br style="clear:both;" />
	      <div id="conditions_div" class="formLabel ">
	      	<span style="top: -2px;position: relative;">
	      		Я полностью прочитал <a href="/conditions/" target="_blank" title="Пользовательское соглашение">пользовательское соглашение</a> и согласен с ним <strong>* </strong>
	      	</span>
	      	<input type="checkbox" id="conditions" name="conditions" class="inputbox" />
	      </div>
	      <br style="clear:both;" />
	      
	      <div id="cart_info" style="display:none;">
	   	  </div>
	      
	    </fieldset>
	   </div>
	   
	    
	   <div align="center">
	   	<input type="button" class="addtocart_button btn2" value="Оформить" title="Оформить" onclick="PlaceOrder()" >
	   </div>
	    
	   </form>
	    
	  </div>
	 </div> 
	</div>
	
	<script>
		{literal}
		
		function PlaceOrder() {
			if (jQuery('#conditions').is(':checked')) {
				jQuery('#zakaz').submit();
			} else {
				jQuery('#conditions_div span').css('color', 'red');
				jQuery.noticeAdd({
				    text: 'Вы не приняли условия пользовательского соглашения',
				    stay: false,
				    stayTime: 4000
				});
								
			}
		}
		
		function checkDiscount() {
			var discount = jQuery('#discount').val();
			jQuery.getJSON("/ajax/discount?check=" + discount,
				function (data) {
					if (data != 0) {
						jQuery('#discount_info').html('Скидка по карте ' + data + ' %');
					}
				}
			);
		}
		
		jQuery.getJSON(
		        "/cart/?operation=all",
		        function (data) {
		        	jQuery('#cart_info').html();
		            for (var i=0; i < data.length; i++) {
		            	jQuery('#cart_info').append("<input type='hidden' name='p_" + data[i].id + "' value='" + data[i].count + "' />");
		            }
		        }
		);
		{/literal}
	</script>

 </div> 
</div>