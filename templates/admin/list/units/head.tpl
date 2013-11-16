<tr>
    <script>
        var callFunctions = [];
        {literal}
            function callCallFunctions() {
                for(var i = 0; i< callFunctions.length; i++) {
                    eval(callFunctions[i] +"()");
                }
                return true;
            }
        {/literal}
    </script>
    <form method="post">
        {foreach from=$fields item=field key=f_name}
            {if !isset($field.nolist)}
                <th align="middle">
                    {$field.title}
                    {if isset($field.filter)}
                        <br/>
                        {if $field.type eq 'number'}
                            <select name="number_operator_{$f_name}">
                                <option value="=" {if $number_operators[$f_name] eq '='}selected="selected"{/if}> = </option>
                                <option value="<" {if $number_operators[$f_name] eq '<'}selected="selected"{/if}> < </option>
                                <option value="<=" {if $number_operators[$f_name] eq '<='}selected="selected"{/if}> <= </option>
                                <option value=">" {if $number_operators[$f_name] eq '>'}selected="selected"{/if}> > </option>
                                <option value=">=" {if $number_operators[$f_name] eq '>='}selected="selected"{/if}> >= </option>
                                <option value="!=" {if $number_operators[$f_name] eq '!='}selected="selected"{/if}> != </option>
                            </select>
                        {/if}
                        {if $field.type eq 'select' and !empty($field.values) and !isset($field.autocomplete)}
                            <select name="filter_{$f_name}">
                                <option value=""></option>
                                {foreach from=$field.values item=value key=option}
                                    <option value="{$option}" {if $option eq $filters[$f_name]}selected="selected"{/if}>{$value[$field.show_field]}</option>
                                {/foreach}
                            </select>
                        {elseif $field.type eq 'select' and isset($field.autocomplete)}
                            {include file="admin/list/units/autocomplete.tpl"}
                        {else}
                            <input type="text" name="filter_{$f_name}" value="{$filters[$f_name]}" size="{$field.size}" maxlength="{$field.size}" />
                        {/if}
                    {/if}
                </th>
            {/if}
        {/foreach}
        <th width="80px" align="middle"><input type="submit" value=" Фильтр " onclick="callCallFunctions();"/></th>
    </form>
</tr>
