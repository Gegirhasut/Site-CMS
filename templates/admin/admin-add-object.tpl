<html>
<head>
    <script>
     {if isset($post)}
      window.close();
     {/if}
    </script>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="/js/calendar.js"></script>
    <script type="text/javascript" src="/js/calendar-ru.js"></script>
    <script type="text/javascript" src="/js/calendar-setup.js"></script>
    
    <link rel="stylesheet" type="text/css" href="/css/calendar.css" />
</head>
<body>
	<table>
	 <tr>
	  <td valign="top">
	    <form action="" method="post">
	        <table>
	            {foreach from=$fields.fields item=field key=name}
	                {if $name neq $fields.identity}
	                    <tr>
	                        {if $field.type neq 'link'}
	                            {if $fields.geo.latitude neq $name && $fields.geo.longitude neq $name}
	                               <td>{$field.title}</td>
	                            {/if}
	                            <td>
	                            	{if $field.type eq "list"}
	                            		<textarea cols="60" rows="40" name="{$name}" id="{$name}"></textarea>
	                                {elseif $field.type eq "select"}
	                                    <select name="{$name}" id="{$name}"
	                                       {if isset($field.events)}
                                               {foreach from=$field.events item=func key=event}
                                                   {$event} = '{$func}()'
                                               {/foreach}
                                           {/if}
	                                    >
	                                        {if isset($field.empty)}
	                                            <option value=""></option>
	                                        {/if}
	                                        
	                                        {foreach from=$field.values item=option}
	                                            <option value="{$option[$field.select_identity]|escape}" {if $select eq $option[$field.select_identity]}selected{/if}>{$option[$field.show_field]}</option>
	                                        {/foreach}
	                                    </select>
	                                    
{if isset($field.info_fields)}
{foreach from=$field.info_fields item=info_field}
    <input type="hidden" id="{$info_field}" value=""></span>&nbsp;
{/foreach}

<script type="text/javascript">
    var info_fields = [];
    {foreach from=$field.values item=option}
        info_fields[{$option[$field.select_identity]}] = {ldelim} {foreach from=$field.info_fields item=info_field name=info} {$info_field} : '{$option[$info_field]}'{if not $smarty.foreach.info.last},{/if}{/foreach} {rdelim};
    {/foreach}
    
    function setInfoFields() {ldelim}
        var id = jQuery('#{$name}').val();
        var info = '';
        {foreach from=$field.info_fields item=info_field}
            jQuery('#{$info_field}').val(info_fields[id].{$info_field});
        {/foreach}
        changeAddress();
    {rdelim}
    
</script>

{/if}
	                                {elseif $field.type eq "textarea"}
	                                    <textarea id="{$name}" name="{$name}" rows="5" cols="25"></textarea>
	                                {elseif $field.type eq "img"}
									 	<div id="{$fields.img.field}">не загружена</div>
									{elseif $field.type eq "calendar"}
                                        <input name="{$name}" value="{$smarty.now|date_format:'%Y.%m.%d'}" id="{$name}" style="width: 100px;" type="text"> <button value="Выбрать" type="button" id="trigger_{$name}"><span>&nbsp;Календарь&nbsp;</span></button>
                                        
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
	                                    <textarea id="{$name}" name="{$name}"></textarea>
	                                    <script type="text/javascript">
	                                        var editor{$name} = CKEDITOR.replace( '{$name}' );
	                                    </script>
	                                {elseif $fields.geo.latitude eq $name || $fields.geo.longitude eq $name}
                                        <input type="hidden" id="{$name}" name="{$name}" />
	                                {else}
	                                    <input id="{$name}" type="{$field.type}" name="{$name}" {if isset($field.default)}value="{$field.default}"{/if} size="30"
	                                       {if isset($field.events)}
	                                           {foreach from=$field.events item=func key=event}
	                                               {$event} = '{$func}()'
	                                           {/foreach}
	                                       {/if}
	                                     />
	                                {/if}
	                            </td>
	                        {/if}
	                    </tr>
	                {/if}
	            {/foreach}
	            <tr>
	                <td colspan="2">
	                    <input type="hidden" name="operation" value="add" />
	                    <input id="submit" type="submit" value=" Добавить " />
	                    
	                    <input type="button" value=" Отмена " onclick="window.close();" />
	                </td>
	            </tr>
	        </table>
	    </form>
	   </td>
	   {if isset ($fields.img)}
    	   <td valign="top">
    	     {include file="units/uploadfile.tpl"}
    	   </td>
	   {/if}
	  </tr>
	 </table>
	 
{if isset($fields.geo)}
    <div id="ymaps-map-id_13401264085565651343" style="width: 350px; height: 300px;"></div>

    <script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=loadMap"></script>
    <script type="text/javascript">
        function getAddress() {ldelim}
            var address = '';
            var part = '';
            {foreach from=$fields.geo.address item=g}
                {if $fields.fields[$g].type neq 'select'}
                    part = jQuery('#{$g}').val() + ' ';
                {else}
                    part = jQuery('#{$g} :selected').text() + ' ';
                {/if}
                address += part;
            {/foreach}
            return jQuery.trim(address);
        {rdelim}
        
        function changeAddress() {ldelim}
            var address = getAddress();
            
            if (address != '') {ldelim}
                ymaps.geocode(address, {ldelim}results: 1, json: true{rdelim}).then(function (res) {ldelim}
                    var object = res.GeoObjectCollection.featureMember[0].GeoObject;
                    var points = object.Point.pos.split(' ');
                    var lat = points[0];
                    var long = points[1];
                    
                    jQuery('#{$fields.geo.latitude}').val(lat);
                    jQuery('#{$fields.geo.longitude}').val(long);
                    
                    schoolsCollection.removeAll();
                    placemark = new ymaps.Placemark([lat, long]);
                    schoolsCollection.add(placemark);
                    map.geoObjects.add(schoolsCollection);
                    
                    map.setCenter([lat, long]);
                {rdelim});
            {rdelim}
        {rdelim}
        
        var schoolsCollection = null;
        var map = null;
        
        function loadMap(ymaps) {ldelim}
            changeAddress();
            
            schoolsCollection = new ymaps.GeoObjectCollection ();
            
            {literal}
                var latitude = 82.92159699999996;
                var longitude = 55.029909999994665;
            
                if (ymaps.geolocation) {
                    latitude = ymaps.geolocation.latitude;
                    longitude = ymaps.geolocation.longitude;
                }    
            
                map = new ymaps.Map("ymaps-map-id_13401264085565651343", {
                    center: [longitude, latitude],
                    zoom: 12,
                    type: "yandex#map"
                });
                
                map.controls.add("zoomControl").add("mapTools").add(new ymaps.control.TypeSelector(["yandex#map", "yandex#satellite", "yandex#hybrid", "yandex#publicMap"]));
                
                placemark = new ymaps.Placemark([longitude, latitude]);
                schoolsCollection.add(placemark);
                map.geoObjects.add(schoolsCollection);
                
            {/literal}        
        {rdelim}
        
        
        {if isset($field.info_fields)}        
            setInfoFields();
        {/if}
        
    </script>
{/if}
</body>
</html>