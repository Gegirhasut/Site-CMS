<html>
<head>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
</head>
<body>
    <a target="_blank" href="/">Смотреть на сайте</a><br/><br/>
    
    <form action="" method="post">
        <table>
        	{foreach from=$fields item=field}
        		{if not isset($field.identity)}
	        		<tr>
	                	<td>{$field.title}</td>
	                	<td>
                	        {if $field.type eq "select"}
                                <select name="{$field.name}">
                                    {foreach from=$field.values item=option}
                                        <option value="{$option[$field.select_identity]}">{$option.name}</option>
                                    {/foreach}
                                </select>
                            {else}
	                	        <input type="{$field.type}" name="{$field.name}" />
	                	    {/if}
	                	</td>
	            	</tr>
        		{/if}
            {/foreach}
            <tr>
                <td colspan="2">
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
            	{foreach from=$fields item=field}
            		{if not isset($field.identity)}
		                <tr>
		                    <td>{$field.title}:</td>
		                    <td>
		                        {if $field.type eq "select"}
		                            <select name="{$field.name}">
                                        {foreach from=$field.values item=option}
                                            <option value="{$option[$field.select_identity]}" {if $object[$field.name] eq $option[$field.select_identity]}selected{/if}>{$option.name}</option>
                                        {/foreach}
                                </select>
		                        {else}
		                            <input type="{$field.type}" name="{$field.name}" {if $field.type neq 'checkbox'}value="{$object[$field.name]}"{else} {if $object[$field.name] eq 1}checked{/if} {/if} />
		                        {/if}
		                    </td>
		                </tr>
		            {else}
		            	<tr>
		                    <td>Идентификатор:</td>
		                    <td>{$object[$field.name]}</td>
		                </tr>
		            	<input type="hidden" name="{$field.name}" value="{$object[$field.name]}" />
		            {/if}
	            {/foreach}
                
                <tr>
                    <td colspan="2">
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