<html>
<head>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <style type="text/css">
        .fields {ldelim} font-size: 13px; {rdelim}
    </style>
</head>
<body>

    {$menu}
    
    <form action="" method="post">
        <table class="fields">
            {if isset($global)}
            <tr>
                 <td colspan="{$fields|@count}">
                 {$global.title}:
                     <select name="{$global.name}">
                        {foreach from=$global.values item=option}
                            <option value="{$option[$global.select_identity]}" {if $option[$global.select_identity] eq $globalValue}selected{/if}>{$option.name}</option>
                        {/foreach}
                     </select>
                 </td>
            </tr>
            {/if}
             
            <tr>        
            {foreach from=$fields item=field}
                {if not isset($field.identity) && not isset($field.global)}
                        <td>{$field.title}</td>
                {/if}
            {/foreach}
            <td>Операция</td>
            </tr>
            
            <tr>
                {foreach from=$fields item=field}
                    {if not isset($field.identity) && not isset($field.global)}
                        <td>
                            {if $field.type eq "select"}
                                <select name="{$field.name}">
                                    {foreach from=$field.values item=option}
                                        <option value="{$option[$field.select_identity]}">{$option.name}</option>
                                    {/foreach}
                                </select>
                            {else}
                                <input type="{$field.type}" name="{$field.name}" size="10" />
                            {/if}
                        </td>
                    {/if}
                {/foreach}
                <td>
                    <input type="hidden" name="operation" value="add" />
                    <input type="submit" value="добавить" />
                </td>           
            </tr>
            
        </table>
    </form>
    <hr/>

    {foreach from=$objects item=object}
        <form action="" method="post">
            <table>
                <tr>
                    {foreach from=$fields item=field}
                        {if not isset($field.identity)}
                            <td>{$field.title}:</td>
                        {else}
                            <td>Id:</td>
                        {/if}
                    {/foreach}
                    <td>Операция</td>
                </tr>
                
                <tr>
                    {foreach from=$fields item=field}
                        {if not isset($field.identity)}
                            <td>
                                {if $field.type eq "select"}
                                    <select name="{$field.name}">
                                        {foreach from=$field.values item=option}
                                            <option value="{$option[$field.select_identity]}" {if $object[$field.name] eq $option[$field.select_identity]}selected{/if}>{$option.name}</option>
                                        {/foreach}
                                </select>
                                {else}
                                    <input size="10" type="{$field.type}" name="{$field.name}" {if $field.type neq 'checkbox'}value="{$object[$field.name]}"{else} {if $object[$field.name] eq 1}checked{/if} {/if} />
                                {/if}
                            </td>
                        {else}
                            <td>{$object[$field.name]}</td>
                            <input type="hidden" name="{$field.name}" value="{$object[$field.name]}" />
                        {/if}
                    {/foreach}
                    <td>
                        <input type="hidden" name="operation" value="update" />
                        <input type="submit" value="изменить" />
                    </td>
                </tr>
                
            </table>
        </form>
        <br/><br/>
    {/foreach}
    
</body>
</html>