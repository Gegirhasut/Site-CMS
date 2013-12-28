<table>
 <tr>
  {foreach from=$pages item=page key=name}
    {if empty($page)}
        </tr><tr>
    {else}
        <td><a href="{$page.url}" {if isset($page.blank)}target="_blank"{/if})>{$name}</a>&nbsp;&nbsp;</td>
    {/if}
  {/foreach}
 </tr>
</table>
<br/>
<hr/>