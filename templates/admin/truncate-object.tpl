<script>
     {if isset($post)}
      window.close();
     {/if}
</script>

Удалить все объекты?
<table><tr><td>
<form action="" method="post">
 <input type="submit" value="Да" />
 <input type="hidden" name="table" value="{$table}" />
</form>
</td><td>
<form action="">
 <input type="submit" value="Нет" onclick="window.close();" />
</form>
</td></tr>
</table>