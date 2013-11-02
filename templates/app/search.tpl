<div class="moduletable" style="height: 94px;">
	<h3><span>Поиск</span></h3>
	<div class="moduletable_content" style="padding: 15px 10px 10px 10px;">
		<script type="text/javascript">
		{literal}
		window.addEvent('load', function(){
			var input = $('mod_search_searchword');
			input.addEvents({
				'blur' : function(){ if(input.value == '') input.value='поиск...'; },
				'focus' : function(){ if(input.value == 'поиск...') input.value='';	}
			});
			if (input.value == '') 
				input.value = 'поиск...';
			
			if($('mod_search_button')){
				$('mod_search_button').addEvent('click', function(){ 
					input.focus(); 
				});
			}
		});
		{/literal}
		</script>
		
		<form action="/search" method="get">
			<input type="hidden" name="searchid" value="2039710" />
			<div class="mod_search" style="float: left;">
		 		<input style="width: 490px;" name="text" id="mod_search_searchword" maxlength="20" alt="Поиск" class="inputbox" type="text" size="20" {if isset($search_text)}value="{$search_text}"{/if} />
		 		<input type="submit" value="Найти" />
			</div>
			<input type="hidden" name="web" value="0" />
			<span style="padding-left: 5px;top: 5px;position: relative;">
				Поиск по коду товара
				<input style="position: relative;top: 3px;" type="checkbox" name="code" {if isset($code_on)}checked{/if} />
			</span>
		</form>
	
	</div>
</div>