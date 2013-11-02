<html>
<head>
<script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
<link rel="stylesheet" href="/css/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/js/thickbox.js"></script>

<script>
    {literal}
    function open_window(link,w,h)
    {
        var win = "width="+w+",height="+h+",menubar=no,location=no,resizable=yes,scrollbars=yes";
        newWin = window.open(link,'newWin',win);
        setTimeout("checkWin()", 1000);
    }
    
    function checkWin() {
        if (newWin.closed == false) {
            setTimeout("checkWin()", 500);
        } else {
            window.location.reload();
        }
    }
    {/literal}
</script>
</head>
<body>

{$menu}

<table width="100%">
 <tr>
     <td>Категории</td><td rowspan="3" style="background: black; width: 1px;" width="2"></td>
     <td>Записи{if isset($current_category)} в категории {$current_category.name}{/if}</td>
 </tr>
 <tr><td style="background: black" colspan="3"></td></tr>
 <tr>
 
  <td width="250px" valign="top">
   <table width="100%">
    <tr>
     <td colspan="2" align="middle">
      <a href="javascript:open_window('/admin/add-update/Category/',550,600);">Добавить категорию</a>
      <br/><br/>
     </td>
    </tr>
   
    {foreach from=$categories item=category key=name}
     <tr>
      <td>
       {if $category.parent_id neq ''}
        &nbsp;&nbsp;
       {/if}
       <a href="?cat_id={$category.cat_id}">{$category.name}</a><br/>
      </td>
      <td width="40">
       <a title="Редактировать" href="javascript:open_window('/admin/add-update/Category/{$category.cat_id}',550,600);"><img src="/images/icons/edit.png" width="16" /></a>
       <a title="Удалить" href="javascript:open_window('/admin/delete/Category/{$category.cat_id}',200,200);"><img src="/images/icons/deletered.png" width="16" /></a>
      </td>
     </tr>
    {/foreach}
   </table>
  </td>
  
  <td valign="top" align="middle">
   <a href="javascript:open_window('/admin/add-update/Product/?select={$current_category.cat_id}',1000,800);">Добавить запись!</a>
   <br/><br/>
   
   <table border="1" cellspacing="0" cellpadding="3" bordercolor="#C3BD7C" bordercolordark="#FFFFE2" width="100%">
    <tr>
     {foreach from=$fields.fields item=field key=f_name}
      {if $f_name neq $fields.identity}
       <td align="middle">{$field.title}</td>
      {/if}
     {/foreach}
     <td width="80px" align="middle">Операции</td>
    </tr>
  
    {foreach from=$products item=product key=p_name}
     <tr>
      {foreach from=$fields.fields item=field key=f_name}
       {if $f_name neq $fields.identity}
        <td align="middle">
         {if $field.type eq 'link'}
          <a href="javascript:open_window('/admin/add-update/Product/{$product.r_id}',1000,800);">{$product[$f_name]}</a>
         {elseif $field.type eq 'checkbox'}
          {if $product[$f_name] eq '1'}
           Да
          {else}
           Нет
          {/if}
         {elseif $field.type eq 'img'}
           {if $product[$f_name] neq ''}
               <a href="/{$fields.img.upload}/{$product[$f_name]}" title="Большая картинка" class="thickbox">
                 <img src="/{$fields.img.small_path}/{$product[$f_name]}" alt="Увеличить картинку" height="100">
               </a>
           {else}
               не загружена
           {/if}
         {elseif $field.type eq 'textarea'}
           {$product[$field.textarea]|substr:0:100} ...
         {else}
          {$product[$f_name]}
         {/if}
        </td>
       {/if}
      {/foreach}
      <td align="middle">
       <a title="Редактировать" href="javascript:open_window('/admin/add-update/Product/{$product.r_id}',1000,800);"><img src="/images/icons/edit.png" width="16" /></a>
       <a title="Удалить" href="javascript:open_window('/admin/delete/Product/{$product.r_id}',200,200);"><img src="/images/icons/deletered.png" width="16" /></a>
      </td>
     </tr>
    {/foreach}
   </table>
  </td>
  
 </tr>
</table>

<hr/>
<br/>
{include file="admin/admin-logout.tpl"}

</body>
</html>