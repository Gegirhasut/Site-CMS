{foreach from=$objects item=product key=p_name}
    <tr {if isset($sort)}style="cursor:move;" title="Перетащить на другое место"{/if} class="drag">
        {foreach from=$fields item=field key=f_name}
            {if $f_name eq $identity}
                <input type="hidden" class="hidden_identity" value="{$product[$f_name]}"/>
            {/if}
            {if !isset($field.nolist)}
                <td align="middle" {if $field.type eq 'sort'}class="sort_field"{/if}>
                    {if $field.type eq 'link'}
                        <a href="javascript:open_window('/admin/add-update/{$class}/{$product[$identity]}',1000,800);">{$product[$f_name]}</a>
                    {elseif $field.type eq 'checkbox'}
                        {if $product[$f_name] eq '1'}
                            Да
                        {else}
                            Нет
                        {/if}
                    {elseif $field.type eq 'password'}

                    {elseif $field.type eq 'preview'}
                        {if $product[$f_name] neq ''}
                            <a href="/{$images.upload}/{$product[$f_name]}" title="Большая картинка" class="thickbox">
                                <img src="/{$images.small_path}/{$product[$f_name]}" alt="Увеличить картинку" height="100">
                            </a>
                        {else}
                            не загружена
                        {/if}
                    {elseif $field.type eq 'textarea'}
                        {$product[$f_name]}
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