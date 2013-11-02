<div id="component_wrap" class="clearfix gk-mass clear">
	<div>
		<h1 class="componentheading">
			<span>Регистрация</span>
		</h1>
		
	<div class="module-new">
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
	       <label for="name">Логин</label>
	       <strong>* </strong>
	      </div>
	      <div class="formField" id="login_input">
	       <input type="text" id="login" name="login" size="30" value="" class="inputbox" maxlength="100" />
	       <br/>
	      </div>
	      <br style="clear:both;" />
	      
	      <div id="name_div" class="formLabel ">
	       <label for="name">Пароль</label>
	       <strong>* </strong>
	      </div>
	      <div class="formField" id="password_input">
	       <input type="password" id="password" name="password" size="30" value="" class="inputbox" maxlength="100" />
	       <br/>
	      </div>
	      <br style="clear:both;" />
	      
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
	       <strong>* </strong>
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
	      
	      <div id="conditions_div" class="formLabel ">
	      	<span style="top: -2px;position: relative;">
	      		Подписаться на рассылку оптового прайс-листа
	      	</span>
	      	<input type="checkbox" id="opt" name="opt" class="inputbox" />
	      </div>
	      <br style="clear:both;" />
	      
	      <div class="formField" id="name_input">
	       <input type="submit" size="30" value="Зарегистрироваться" class="inputbox" maxlength="100" />
	       <br/>
	      </div>
	      <br style="clear:both;" />
	      
	    </fieldset>
	   </div>
	   
	    
	   </form>
	    
	  </div>
	 </div> 
	</div>
	
 </div> 
</div>