<html>
<head>
<script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
<link rel="stylesheet" href="/css/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/js/thickbox.js"></script>

<script type="text/javascript" src="/js/calendar.js"></script>
<script type="text/javascript" src="/js/calendar-ru.js"></script>
<script type="text/javascript" src="/js/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" href="/css/calendar.css" />

    <script>
     {if isset($post)}
      window.close();
     {/if}
    </script>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    
    {if isset($fields.manyToMany) && $fields.manyToMany.Type.type eq 'autocomplete'}
        <script src="/js/jquery.ui.core.min.js"></script>
        <script src="/js/jquery.ui.widget.min.js"></script>
        <script src="/js/jquery.ui.position.min.js"></script>
        <script src="/js/jquery.ui.autocomplete.min.js"></script>
        <link href="/css/themes/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css">
        <link href="/css/app/main.css" rel="stylesheet" type="text/css">
    {/if}
        
</head>
<body>
    <table {if !isset($fields.img)}width="100%"{/if}>
     <tr>
      <td valign="top">
        <form action="" method="post">
            <table {if !isset($fields.img)}width="100%"{/if}>
                {foreach from=$fields.fields item=field key=name}
                    {if $name neq $fields.identity}
                        <tr>
                            {if $fields.geo.latitude neq $name && $fields.geo.longitude neq $name}
                                <td {if !isset($fields.img)}width="250px"{/if}>{$field.title}:</td>
                            {/if}
                            <td>
                                {if $field.type eq "select"}
                                    <select name="{$name}" id="{$name}">
                                        {if isset($field.empty)}
                                            <option value=""></option>
                                        {/if}
                                        {foreach from=$field.values item=option}
                                            <option value="{$option[$field.select_identity]|escape}" {if $object[$name] eq $option[$field.select_identity]}selected{/if}>{$option[$field.show_field]}</option>
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
                                    <textarea id="{$name}" name="{$name}" rows="5" cols="25" {if !isset($fields.img)}style="width:500px;"{/if}>{$object[$name]|escape}</textarea>
                                {elseif $field.type eq "img"}
                                    <div id="{$fields.img.field}">
                                     {if $object[$name] neq null}
                                        <a href="/{$fields.img.upload}/{$object[$name]|escape}" title="Большая картинка" class="thickbox">
                                          <img src="/{$fields.img.small_path}/{$object[$name]|escape}" alt="Увеличить картинку" width="150px;">
                                        </a>
                                        {if $name neq 'img'}
                                        	<input type="hidden" name="{$name}" id="{$name}" value="{$object[$name]|escape}" />
                                        	<a id="a_{$name}" href="javascript:;" title=" Удалить " onclick="$('#{$name}').remove();$('#img_{$name}').remove();$('#a_{$name}').remove();">X</a>
                                        {/if}
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
                                {elseif $fields.geo.latitude eq $name || $fields.geo.longitude eq $name}
                                    <input type="hidden" id="{$name}" name="{$name}" />
                                {else}
                                    <input size="30" id="{$name}" type="{$field.type}" name="{$name}" {if $field.type neq 'checkbox'}value="{$object[$name]|escape}"{else} {if $object[$name] eq 1}checked{/if} {/if}
                                        {if isset($field.events)}
                                           {foreach from=$field.events item=func key=event}
                                               {$event} = '{$func}()'
                                           {/foreach}
                                       {/if}
                                    />
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
                        <input type="hidden" name="operation" value="update" />
                        <input id="submit" type="submit" value=" Изменить " />
                        
                        <input type="button" value=" Отмена " onclick="window.close();" />
                    </td>
                </tr>
            </table>
        </form>
        <br/><br/>
       </td>
       {if isset ($fields.img)}
           <td valign="top">
             {include file="units/uploadfile.tpl"}
           </td>
       {/if}
      </tr>
      {if isset($fields.manyToMany) && $fields.manyToMany.Type.type eq 'autocomplete'}
          <tr>
               <td>
                   <div style="float: left;">
                        <label for="object">{$fields.manyToMany.Type.title}</label>
                        <input id="object" />
                   </div>
                   <span class="addButton" onclick="addObject('{$object[$fields.identity]}', '{$fields.manyToMany.Type.link_object}', '{$fields.manyToMany.Type.join_object}', '{$fields.manyToMany.Type.name}')"></span>
                   <div style="clear: both;" />
                   
                   <br/>
                   <div id="users_objects">
                   </div>
               </td>
          </tr>
          
          <script type="text/javascript" src="/js/app/subjects.js"></script>

          <script language="javascript">
          var availableObjects = [
                {foreach from=$fields.manyToMany.Type.all_value item=object name=objects}
                    "{$object[$fields.manyToMany.Type.join_field_name]}"{if !$smarty.foreach.objects.last},
                    {/if}
                {/foreach}
          ];
            
          {literal}   
            $(function() {
                $( "#object" ).autocomplete({
                    source: availableObjects
                });
            });
            
          {/literal}
            
          {foreach from=$fields.manyToMany.Type.value item=uo}
              addObjectElement({$uo[$join_identity]}, '{$uo[$fields.manyToMany.Type.join_field_name]}', '{$fields.manyToMany.Type.link_object}');
          {/foreach}
          </script>
      {/if}
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
                //if (part == ' ') return '';
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
            
            changeAddress();
        {rdelim}
        
        {if isset($field.info_fields)}        
            setInfoFields();
        {/if}
        
    </script>
{/if}     
</body>
</html>