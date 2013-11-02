<html>
<head>
    <script>
     {if isset($post)}
      window.close();
     {/if}
    </script>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>    
</head>
<body>
        <form action="" method="post">
            <table>
                {foreach from=$fields.fields item=field key=name}
                    {if $name neq $fields.identity}
                        <tr>
                            <td>{$field.title}:</td>
                            <td>
                                {if $field.type eq "select"}
                                    <select name="{$name}">
                                        {if isset($field.empty)}
                                            <option value=""></option>
                                        {/if}
                                        {foreach from=$field.values item=option}
                                            <option value="{$option[$field.select_identity]}" {if $object[$name] eq $option[$field.select_identity]}selected{/if}>{$option.name}</option>
                                        {/foreach}
                                </select>
                                {else}
                                    <input type="{$field.type}" name="{$name}" {if $field.type neq 'checkbox'}value="{$object[$name]}"{else} {if $object[$name] eq 1}checked{/if} {/if} />
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
                        <input type="submit" value="Изменить" />
                        
                        <input type="button" value="Отмена" onclick="window.close();" />
                    </td>
                </tr>
            </table>
        </form>
        <br/><br/>
    
</body>
</html>