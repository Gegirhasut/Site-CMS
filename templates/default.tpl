{include file="units/html_head.tpl"}

<div id="gk-top" class="main">
	<a href="/" title="Арктида">
		<img src="/images/app/logos/1.png" width="300" style="padding-top:15px;" />
	</a>
	<div style="position: relative;top: -37px;left: 19px;text-align: center;line-height: 27px;">
		<a class="logo" href="/" title="Арктида" style="color: #0060AF; position: relative;top: -26px;font-size: 27px;">
			Интернет-магазин
			<br>
			развивающих игрушек
		</a>
	</div>
</div>

<ul class="no-display">
     <li><a href="/#gk-content" title="Skip to content">Skip to content</a></li>
</ul> 
	
<div id="bg-wrap-left" class="main">
	<div id="bg-wrap-right" class="main">
		<div id="gk-content-wrapper" class="main">
			<div class="phonealm" style="margin: -56px 111px 0 0px;">
				<h4>8 (383) 214-59-93</h4>
			</div>
			<div style="margin: -63px 0 0 0px;float: right;color: #0060AF;font-size: 14px;line-height: 90%;">
				<table>
					<tr>
						<td>
							<a href="javascript:;" class="callback" onclick="show_modal('buy_window');">
								<img src="/images/app/telephone_blue.png" width="30" />
							</a>
						</td>
						<td style="vertical-align: top;text-align:middle;padding-left: 5px;">
							<a href="javascript:;" class="callback" onclick="show_modal('buy_window');">
								Закажите<br>
								обратный<br>
								звонок
							</a>
						</td>
					</tr>
				</table>				
			</div>
	    
			{include file="app/menu-top.tpl"}
			
			{include file="app/banners.tpl"}
			
			<table width="100%" style="padding-bottom: 10px;">
				<tr>
					<td>
						{include file="app/search.tpl"}
					</td>
					<td width="10"></td>
					<td width="300">
						{include file="app/cart.tpl"}
					</td>
				</tr>
			</table>
			
			<div id="gk-container">
				<div class="static clearfix">
					<div id="gk-mainbody" style="width:100%">
						<div id="gk-main" style="width:74%">
							<div class="inner ctop cleft cright cbottom clearfix">
								<div id="gk-contentwrap">
									<div id="gk-content" style="width:100%">
										<div id="gk-current-content" style="width:100%">
											{include file="app/pages/$content_page.tpl"}
											
											{include file="app/address.tpl"}
											
											{include file="units/jquery_notice.tpl"}
											
											<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
<div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="button" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,gplus"></div> 
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="gk-left" class="column" style="width:26%">
						    <div class="inner cleft ctop cbottom">
								<div class="gk-mass gk-mass-top clearfix">
									
									
									{include file="app/menu.tpl"}
									{include file="app/news.tpl"}
									{include file="app/partners.tpl"}    	    	
						   		</div>
							</div>
						</div>
					</div>
				</div>
			</div>
				    
			<div id="gk-footer" class="clearfix main">
				<div id="gk-copyright">
			        Арктида - магазин развивающих игрушек.
			        &nbsp;&nbsp;&nbsp;&nbsp;
			        <a href="javascript:;" onclick="show_modal('galoba_window');">Пожаловаться</a>
				</div>
				<div style="float:left;">
					Телефон и адрес выставочного зала: <b>Телефон</b>: +7-913-396-5805, +7-913-396-3627, <b>Адрес</b>: г. Новосибирск, ул. Автогенная, 122.
				</div>
			</div>	     
		</div>
	</div>
</div>

{if isset($unsubscribe)}
<script>
jQuery.noticeAdd({ldelim}
    text: '{$unsubscribe}',
    stay: false,
    stayTime: 4000
{rdelim});
</script>
{/if}

<div id="overlay" style="display: none;"></div>

<div id="buy_window" class="modal_window" style="display: none;">
	<form action="" method="post">
		<input type="hidden" name="action" value="">
		При оформлении покупки для Вас доступна услуга заказа "обратного звонка".
		Услуга доступна ежедневно с 09.00 до 18.00 для жителей Новосибирска и Новосибирской области.
		<div class="error" style="color: red;"></div>
		<br>
		<br>
		<select name="ftype" id="ftype">
			<option value="Частное лицо">Частное лицо</option>
			<option value="Юридическое лицо">Юридическое лицо</option>
		</select>
		<br>
		<br>
		Имя :<br>
		<input type="text" name="fname" id="fname">
		<br>
		<br>
		Контактный телефон* :<br>
		<input type="text" name="fphone" id="fphone">
		<br>
		<br>
		Сообщение :<br>
		<textarea name="fmessage" rows="5" id="fmessage"></textarea>
		<br>
		<br>
		<div class="send_call" id="send_call"></div>
	</form>
	<div class="close" style="position: absolute;top: -19px;right: -19px;"></div>
</div>

<div id="galoba_window" class="modal_window" style="display: none;">
	<form action="" method="post">
		Использую следующую форму Вы можете отправить нам жалобу.
		<div class="error" style="color: red;"></div>
		<br>
		<br>
		Имя :<br>
		<input type="text" name="gname" id="gname">
		<br>
		<br>
		Контактные данные* :<br>
		<input type="text" name="ginfo" id="ginfo">
		<br>
		<br>
		Текст жалобы :<br>
		<textarea name="gmessage" rows="5" id="gmessage"></textarea>
		<br>
		<br>
		<div class="send_call" id="send_galoba"></div>
	</form>
	<div class="close" style="position: absolute;top: -19px;right: -19px;"></div>
</div>

<script>
{literal}
	var modal = null;
	
	function show_modal(modal_name) {
		modal = modal_name;
		jQuery('#overlay').show();
		jQuery('#' + modal).show();
	}
	
	function hide_modal() {
		jQuery('#overlay').hide();
		jQuery('#' + modal).hide();
	}
	
	jQuery('.close').bind('click', function() {
		jQuery('.error').html('');
		hide_modal();
	});
	
	jQuery('#send_call').bind('click', function () {
		jQuery.post(
	        "/ajax/send/",
	        {name: jQuery( "#fname" ).val(), phone: jQuery( "#fphone" ).val(), type: jQuery( "#ftype" ).val(), message: jQuery( "#fmessage" ).val()},
	        function (result) {
	            if (result == 'success') {
	              	jQuery('.error').html('<br>Спасибо! Ваш запрос отправлен.');
	              	jQuery( "#fname" ).val('')
	              	jQuery( "#fphone" ).val('')
	              	jQuery( "#fmessage" ).val('')
	            } else {
	            	jQuery('.error').html('<br>' + result);
	            }
	        }
	    );
	});
	
	jQuery('#send_galoba').bind('click', function () {
		jQuery.post(
	        "/ajax/galoba/",
	        {name: jQuery( "#gname" ).val(), info: jQuery( "#ginfo" ).val(), message: jQuery( "#gmessage" ).val()},
	        function (result) {
	            if (result == 'success') {
	              	jQuery('.error').html('<br>Спасибо! Ваш запрос отправлен.');
	              	jQuery( "#gname" ).val('')
	              	jQuery( "#ginfo" ).val('')
	              	jQuery( "#gmessage" ).val('')
	            } else {
	            	jQuery('.error').html('<br>' + result);
	            }
	        }
	    );
	});
{/literal}
</script>

{include file="units/html_bottom.tpl"}