<table>
 <tr>
  {foreach from=$pages item=page key=name}
   <td><a href="{$page.url}" {if isset($page.blank)}target="_blank"{/if})>{$name}</a>&nbsp;|&nbsp;</td>
  {/foreach}
 </tr>
</table>
<br/>
<hr/>