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
    <option
            value="{$option[$field.identity]|escape}"
            {if $object neq null and $option[$field.identity] eq $object[$field.identity]}
                selected="selected"
            {elseif $select eq $option[$field.identity]}
                selected="selected"
            {/if}

    >
        {$option[$field.show_field]}
    </option>
{/foreach}
</select>

{if isset($field.info_fields)}
    {foreach from=$field.info_fields item=info_field}
        <input type="hidden" id="{$info_field}" value=""></span>&nbsp;
    {/foreach}

    <script type="text/javascript">
        var info_fields = [];
        {foreach from=$field.values item=option}
        info_fields[{$option[$field.identity]}] = {ldelim} {foreach from=$field.info_fields item=info_field name=info} {$info_field} : '{$option[$info_field]}'{if not $smarty.foreach.info.last},{/if}{/foreach} {rdelim};
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