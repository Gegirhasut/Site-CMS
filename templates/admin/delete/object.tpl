<script>
     {if isset($post)}
      window.close();
     {/if}
</script>

Удалить объект?
<table><tr><td>
<form action="" method="post">
 <input type="submit" value="Да" />
 <input type="hidden" name="field" value="{$field}" />
 <input type="hidden" name="id" value="{$id}" />
 <input type="hidden" name="table" value="{$table}" />
 {if isset ($img)}
     {foreach from=$img item=value key=name}
        <input type="hidden" name="{$name}" value="{$value}" />
     {/foreach}
 {/if}
</form>
</td><td>
<form action="">
 <input type="submit" value="Нет" onclick="window.close();" />
</form>
</td></tr>
</table>