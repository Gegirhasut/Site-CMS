<script>
    var availableObjects{$name} = [];
    var availableObjectsData{$name} = [];
    var count{$name} = 0;

    function del{$name} (id) {ldelim}
        $('#sostav_{$name}_' + id).remove();
    {rdelim}

    function add{$name} () {ldelim}
        var html = "<div id='sostav_{$name}_" + count{$name} + "'>";
        html += $('#filter_{$name}').val();
        {if isset($field.many.fields)}
            html += ' : ';
        {/if}
        html += "<input type='hidden' name='many_sostav_{$field.many.identity}_{$name}_" + count{$name} + "' value='" + $('#{$name}').val() + "' />";
        $('#filter_{$name}').val('');
        {if isset($field.many.fields)}
            html += "[ ";
            {foreach from=$field.many.fields item=many_field key=many_field_name}
            html += $('#many_field_{$many_field_name}').html() + " {$many_field.title_add} ";
            html += "<input type='hidden' name='many_field_{$many_field_name}_" + count{$name} + "' value='" + $('#many_field_{$many_field_name}').html() + "' />";
            $('#many_field_{$many_field_name}').html('');
            {/foreach}
            html += "] ";
        {/if}
        {foreach from=$field.join.fields item=join_field key=join_field_name}
        html += $('#filter_{$join_field_name}').val() + " {$join_field.title_add}";
        html += "<input type='hidden' name='many_join_{$join_field_name}_" + count{$name} + "' value='" + $('#filter_{$join_field_name}').val() + "' />";
        $('#filter_{$join_field_name}').val('');
        {/foreach}
        html += "<div style='float: right;' class='delButton' onclick='del{$name}(" + count{$name} + ")'></div>";
        html += "</div>";
        $('#sostav_{$name}').append(html);
        count{$name}++;
        {rdelim}

    function fill{$name}() {ldelim}
        var search = $( "#filter_{$name}").val();
        if (search != '') {ldelim}
            $.get('/admin/api/{$field.many.source}/?{$field.many.show_field}=' + search,
                    function(data) {ldelim}
                        availableObjects{$name} = [];
                        data = eval("(" + data + ")");
                        availableObjectsData{$name} = data;

                        for (var i = 0; i < data.objects.length; i++) {ldelim}
                            availableObjects{$name}[availableObjects{$name}.length] = data.objects[i]['{$field.many.show_field}'];
                            {rdelim}

                        $( "#filter_{$name}" ).autocomplete({ldelim}
                            source: availableObjects{$name},
                            select: function( event, ui )
                            {ldelim}
                                for (var i=0; i < availableObjectsData{$name}.objects.length; i++)
                                {ldelim}
                                    if (ui.item.value == availableObjectsData{$name}.objects[i]['{$field.many.show_field}']) {ldelim}
                                        $('#{$name}').val(availableObjectsData{$name}.objects[i]['{$field.many.identity}']);
                                        {foreach from=$field.many.fields item=many_field key=many_field_name}
                                        $('#many_field_{$many_field_name}').html(availableObjectsData{$name}.objects[i]['{$many_field_name}']);
                                        {/foreach}
                                        break;
                                        {rdelim}
                                    {rdelim}
                                {rdelim}
                            {rdelim});

                        $( "#filter_{$name}" ).autocomplete( "search",  $( "#filter_{$name}").val());
                        {rdelim});
            {rdelim} else {ldelim}
            $( "#{$name}").val('');
            {rdelim}
        {rdelim}
</script>

<table>
    <tr>
        <td>
            <table>
                <tr>
                    <td>
                        {$field.many.title}
                    </td>
                    <td>
                        <input type="text" name="filter_{$name}" id="filter_{$name}" onkeyup="fill{$name}()" autocomplete="off"/>
                    </td>
                </tr>
{foreach from=$field.many.fields item=many_field key=many_field_name}
                <tr>
                    <td>
                        {$many_field.title}
                    </td>
                    <td>
                        <span id="many_field_{$many_field_name}"></span>
                    </td>
                </tr>
{/foreach}
{foreach from=$field.join.fields item=join_field key=join_field_name}
                <tr>
                    <td>
                        {$join_field.title}
                    </td>
                    <td>
                        <input type="text" name="filter_{$join_field_name}" id="filter_{$join_field_name}" value="" autocomplete="off"/>
                    </td>
                </tr>
{/foreach}
                <tr>
            </table>
        </td>
        <td>
            <span class="addButton" onclick="add{$name}()"></span>
        </td>
    </tr>
</table>

<div id="sostav_{$name}">

</div>

<input type="hidden" name="{$name}" id="{$name}" value="{$object[$name]}" />

<script>
{if $field.values neq null}
    {foreach from=$field.values item=field_values}
        {foreach from=$field_values item=field_value key=field_value_name}
            {if $field_value_name eq $field.many.identity}
                $('#{$name}').val('{$field_value}');
            {elseif $field_value_name eq $field.many.show_field}
                $('#filter_{$name}').val('{$field_value}');
            {else}
                $('#filter_{$field_value_name}').val('{$field_value}');
                $('#many_field_{$field_value_name}').html('{$field_value}');
            {/if}
        {/foreach}
        add{$name}();
    {/foreach}
{/if}
</script>