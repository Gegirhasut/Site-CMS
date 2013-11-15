{foreach from=$objects item=product key=p_name}
    <tr>
        {foreach from=$fields item=field key=f_name}
            {if !isset($field.nolist)}
                <td align="middle">
                    {if $field.type eq 'link'}
                        <a href="javascript:open_window('/admin/add-update/{$class}/{$product[$fields.identity]}',1000,800);">{$product[$f_name]}</a>
                    {elseif $field.type eq 'checkbox'}
                        {if $product[$f_name] eq '1'}
                            Да
                        {else}
                            Нет
                        {/if}
                    {elseif $field.type eq 'password'}

                    {elseif $field.type eq 'img'}
                        {if $product[$f_name] neq ''}
                            <a href="/{$fields.img.upload}/{$product[$f_name]}" title="Большая картинка" class="thickbox">
                                <img src="/{$fields.img.small_path}/{$product[$f_name]}" alt="Увеличить картинку" height="100">
                            </a>
                        {else}
                            не загружена
                        {/if}
                    {elseif $field.type eq 'textarea'}
                        {$product[$f_name]}
                    {elseif $fields.sort eq $f_name}
                        <a href="?operation=up&id={$product[$fields.identity]}" title="Вверх"><img src="/images/icons/up.png" alt="Вверх" border="0" width="12px"></a>
                        <a href="?operation=down&id={$product[$fields.identity]}" title="Вниз"><img src="/images/icons/down.png" alt="Вниз" border="0" width="12px"></a>
                    {elseif $field.type eq 'word'}
                        {$product[$f_name]|strip_tags|substr:0:100} ...
                    {else}
                        {$product[$f_name]}
                    {/if}
                </td>
            {/if}
        {/foreach}
        <td align="middle">
            <a title="Редактировать" href="javascript:open_window('/admin/add-update/{$class}/{$product[$identity]}',1000,800);"><img src="/images/icons/edit.png" width="16" /></a>
            <a title="Удалить" href="javascript:open_window('/admin/delete/{$class}/{$product[$identity]}',200,200);"><img src="/images/icons/deletered.png" width="16" /></a>
        </td>
    </tr>
{/foreach}