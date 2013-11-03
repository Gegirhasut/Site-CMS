<script>
    var callFunctions = [];
    {literal}
    function callCallFunctions() {
        for(var i = 0; i< callFunctions.length; i++) {
            callFunctions[i]();
        }
        return true;
    }
    {/literal}
</script>

<form action="" method="post">
    <table>
        {foreach from=$fields item=field key=name}
            {if $name neq $identity}
                <tr>
                    {if $field.type neq 'link'}
                        {if $fields.geo.latitude neq $name && $fields.geo.longitude neq $name}
                            <td>{$field.title}</td>
                        {/if}
                        <td>
                            {if $field.type eq "list"}
                                <textarea cols="60" rows="40" name="{$name}" id="{$name}"></textarea>
                            {elseif $field.type eq "select"}
                                {if isset($field.autocomplete)}
                                    {include file="admin/units/field_select_autocomplete.tpl"}
                                {else}
                                    {include file="admin/units/field_select.tpl"}
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
                            {elseif $field.type eq 'number'}
                                <input id="{$name}" type="text" name="{$name}"
                                    {if $object neq null}
                                        value="{$object[$name]}"
                                    {elseif isset($field.default)}
                                        value="{$field.default}"
                                    {/if}
                                    size="30"
                                    {if isset($field.events)}
                                        {foreach from=$field.events item=func key=event}
                                            {$event} = '{$func}()'
                                        {/foreach}
                                    {/if}
                                />
                            {else}
                                <input id="{$name}" type="{$field.type}" name="{$name}"
                                    {if $object neq null}
                                        value="{$object[$name]}"
                                    {elseif isset($field.default)}
                                        value="{$field.default}"
                                    {/if}
                                    size="30"
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
                {if $object neq null}
                    <input type="hidden" name="{$identity}" value="{$object[$identity]}" />
                    <input type="hidden" name="operation" value="update" />
                    <input id="submit" type="submit" value=" Изменить " />
                {else}
                    <input type="hidden" name="operation" value="add" />
                    <input id="submit" type="submit" value=" Добавить " />
                {/if}

                <input type="button" value=" Отмена " onclick="window.close();" />
            </td>
        </tr>
    </table>
</form>