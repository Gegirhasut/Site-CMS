<html>
<head>
<script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
<link rel="stylesheet" href="/css/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/js/thickbox.js"></script>

<script type="text/javascript" src="/js/calendar.js"></script>
<script type="text/javascript" src="/js/calendar-ru.js"></script>
<script type="text/javascript" src="/js/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" href="/css/calendar.css" />

<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
{literal}
function showHide(id) {
	jQuery('#tr_' + id).hide();
	
	var val = jQuery('#subscribers').val();
	
	if (jQuery('#tr_' + id) != null && val != 1 && val != 4) {
		jQuery('#tr_' + id).show();
	}
}

var users = [];	

function showEmails(emails, subscribers) {
	users = [];
	var html = '';
	for (i=0; i < emails.length; i++) {
		var object = {};
		object.email = emails[i].email;
		if (subscribers == "false") {
			object.fio = emails[i].fio;
			html += object.email + ' : ' + object.fio + '<br/>';
		} else {
			html += object.email + '; ';
		}
		users[users.length] = object;
	}
	
	if (typeof emails.length == "undefined") {
		html = '<b>Некому отправлять!</b>';
	}
	
	jQuery('#who').html(html);
}

function load() {
	var subscribers = jQuery('#subscribers').val();
	var test = jQuery('#test').is(':checked');
	
	$("#submit_send").removeAttr("disabled");
	
	if (test) {
		var emails = [];
		emails[0] = {email: '89139008447@ngs.ru', fio: '<b>Это будет тест!</b>'};
		showEmails(emails, "false");
	} else {
		var url = "/admin/ajax/load/?subscribers=" + subscribers;
		
		jQuery.getJSON(
			url,
			function (data) {
				var result = eval(data);
				showEmails(result.emails, result.subscribers);
			}
		);
	}
}


function send()
{
	var theme = jQuery('#theme').val();
	var body = editorbody.getData();
	jQuery('#toComplete').html('');
	jQuery('#result').html('');
	
	$.post(
		"/admin/ajax/send/",
		{theme: theme, body: body},
		function (result) {
			if (result == 1) {
				curI = 0;
				sendCurrentUser();
			}
		}
	);
}

var curTitle = null;
var curOfferStr = null;
var curFire = null;
var curI = 0;

function sendCurrentUser() {
	var res = sendEmail(curI);
	curI++;
	
	if (!parseResult(res, curI) || curI >= users.length)
		return;
		
	setTimeout("sendCurrentUser()", 5000);
}

function parseResult(res, i) {
	jQuery('#toComplete').html(users.length - i);
	if (res == "") {
		return false;
	}
	if (jQuery('#result').html() == "") {
		jQuery('#result').html(res);
	} else {
		jQuery('#result').html(jQuery('#result').html() + ", " + res);
	}
	return true;
}

function sendEmail(i) {
	var url = "/admin/ajax/send/?email=" + users[i].email;
	if (typeof users[i].fio != 'undefined') {
		url += '&fio=' + users[i].fio;
	}
			
	var res = loadXMLDoc(url);
	
	if (res != "failed")
		return users[i].email;
	jQuery('#toComplete').html("0");
	return "";
}

function loadXMLDoc(url)
{
	if (window.XMLHttpRequest)
	{
		xmlhttp=new XMLHttpRequest();
	} else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return ajaxAction(url);
	
	if((jQuery.browser.msie)&&(jQuery.browser.version="6.0"))
	{
//		ajaxAction(url);
//		ajaxAction(url);
	}
}

function ajaxAction(url)
{	
	xmlhttp.open("GET",url,false);
	xmlhttp.send(null);
	return xmlhttp.responseText;
}
{/literal}
</script>    
</head>
<body>
    {$menu}
    
    <table>
       <tr>
       	<td>
       	 <form method="post" enctype="multipart/form-data">
		 	<input type="file" name="file1"><br>
		 	<input type="hidden" name="uploadfiles" value="1"><br>
			<input type="submit" name="submit" value="Залить файл для рассылки">
		 </form>
       	</td>
       </tr>
       <tr>
       	<td>
	       {if count($files) gt 0}
	        <b>Материалы для рассылки:</b>
	        <br/>
	        
	       	{foreach from=$files item=file}
		       	<a href="?unlink={$file}" title="Удалить файл">X</a> {$file}</br>
			{/foreach}
	       {else}
	       	<b>Залейте файлы для рассылки, если это необходимо</b>
	       {/if}
	       <br/>
       	</td>
       </tr>
    
     <tr>
      <td valign="top">
        <form action="" method="post">
            <table>
                {foreach from=$fields.fields item=field key=name}
                    {if $name neq $fields.identity}
                        <tr {if isset($field.invisible)}style="display: none;" id="tr_{$name}"{/if}>
                            <td>{$field.title}:</td>
                            <td>
                                {if $field.type eq "select"}
                                    <select name="{$name}" id="{$name}"
                                    	{if isset($field.events)}
	                                        {foreach from=$field.events item=func key=event}
	                                            {$event} = '{$func}'
	                                        {/foreach}
	                                    {/if}
                                    >
                                        {if isset($field.empty)}
                                            <option value=""></option>
                                        {/if}
                                        {foreach from=$field.values item=option}
                                            <option value="{$option[$field.select_identity]|escape}" {if $object[$name] eq $option[$field.select_identity]}selected{/if}>{$option[$field.show_field]}</option>
                                        {/foreach}
                                    </select>
                                {elseif $field.type eq "textarea"}
                                    <textarea id="{$name}" name="{$name}" rows="6" cols="35">{$object[$name]|escape}</textarea>
                                {elseif $field.type eq "img"}
                                    <div id="{$fields.img.field}">
                                     {if $object[$name] neq null}
                                        <a href="/{$fields.img.upload}/{$object[$name]|escape}" title="Большая картинка" class="thickbox">
                                          <img src="/{$fields.img.small_path}/{$object[$name]|escape}" alt="Увеличить картинку">
                                        </a>
                                     {else}
                                        не загружена
                                     {/if}
                                    </div>
                                {elseif $field.type eq "calendar"}
                                    <input name="{$name}" value="{$object[$name]|escape}" id="{$name}" style="width: 100px;" type="text"> <button value="Выбрать" type="button" id="trigger_{$name}"><span>&nbsp;Календарь&nbsp;</span></button>
                                    
                                    <script type="text/javascript">
                                      Calendar.setup (
                                       {ldelim}
                                        inputField  : "{$name}",    // ID of the input field
                                        ifFormat    : "y.mm.dd",    // the date format
                                        button      : "trigger_{$name}",    // ID of the button
                                        mondayFirst : true,
                                        range:  [2012, 2013]
                                       {rdelim}
                                      );
                                    </script>
                                {elseif $field.type eq "word"}
                                    <textarea id="{$name}" name="{$name}">{$object[$name]|escape}</textarea>
                                    <script type="text/javascript">
                                        var editor{$name} = CKEDITOR.replace( '{$name}' );
                                    </script>
                                {else}
                                    <input size="{if isset($field.size)}{$field.size}{else}40{/if}" id="{$name}" type="{$field.type}" name="{$name}" {if $field.type neq 'checkbox'}value="{$object[$name]|escape}"{else} {if isset($field.checked)}checked{/if} {/if}
	                                    {if isset($field.events)}
	                                        {foreach from=$field.events item=func key=event}
	                                            {$event} = '{$func}'
	                                        {/foreach}
	                                    {/if}
                                     />
                                    {if isset($field.help)}
                                    	{$field.help}
                                    {/if}
                                {/if}
                            </td>
                        </tr>
                    {else}
                        <tr>
                            <td>Идентификатор:</td>
                            <td>{$object[$name]}</td>
                        </tr>
                        <input type="hidden" name="{$name}" value="{$object[$name]}" />
                    {/if}
                {/foreach}
                
                <tr>
                    <td colspan="2">
                        <input id="submit_load" type="button" value=" Загрузить подписчиков " onclick="load()" />
                        <input id="submit_send" type="button" value=" Разослать " onclick="send()" disabled />
                    </td>
                </tr>
            </table>
        </form>
       </td>
       </tr>
       <tr>
       <td valign="top">
       <br/>
       Осталось штук: <span id="toComplete"></span>
       <br/>
       Уже отправлено на следующие емайлы: <span id="result"></span>
       <br/><br/>
       Кому будет отправлено:<br/>
       <div id="who">
       </div>
       </td>
      </tr>
     </table>
</body>
</html>