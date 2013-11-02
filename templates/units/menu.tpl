<tr>
 <td>
  <table border="0" width="100%" cellspacing="0" cellpadding="0" class="box_heading_table">
   <tr>
    <td style="width:100%;" class="box_heading_td">Категории</td>
   </tr>
  </table>
  <table border="0" width="100%" cellspacing="0" cellpadding="0" class="box_body_table" style="margin-bottom:12px;">
   <tr>
    <td>
        <table border="0" width="100%" cellspacing="0" cellpadding="0" class="box_body">
         <tr>
          <td style="padding:0px 10px 0px 10px;">
           <ul>
            <li class="bg_list"><a style="font-size: 12px;" href="/">Главная</a></li>
            {foreach from=$menu item=item name=foo}
                <li class="bg_list">
                    <a style="font-size: 12px;" title="{$item.name}" {if $item.subs eq null}href="{if $item.url eq "/"}/{else}/{$item.url}{/if}"{else}href="javascript:;"{/if} onclick="openMenu('{$item.url}')">
                      {$item.name}
                    </a>
                </li>
                
                {if $item.subs neq null}
                    {foreach from=$item.subs item=sub name=foo2}
                        <li class="bg_list" name="{$item.url}" {if !isset($item.selected)}style="display: none; "{/if}>
                            &nbsp;&nbsp;&nbsp;&nbsp;
			    <a style="font-size: 12px;background: none;" title="{$sub.name}" href="/{$item.url}/{$sub.url}">{$sub.name}</a>
                        </li>
                    {/foreach}
                {/if}
                
            {/foreach}
           </ul>
           <br/>
          </td>
         </tr>
         <tr>
          <td>
           <img src="/images/app/line.gif" border="0" alt="" width="190" height="16">
          </td>
         </tr>
        </table>
    </td>
   </tr>
  </table>
 </td>
</tr>

<script>
{literal}

function openMenu(name) {
    var a_li = $("li[name=" + name + "]");
    
    for (i = 0; i < a_li.length; i++) {
        if (a_li[i].style['display'] == "none") {
            a_li[i].style['display'] = '';
        } else {
            a_li[i].style['display'] = 'none';
        }
    }
}

{/literal}
</script>