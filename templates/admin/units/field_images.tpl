<style>
    #images_{$name} a {ldelim}
        padding: 3px;
    {rdelim}
</style>
<div id="images_{$name}">
    {if $object[$name]|@count eq 0}
        0
    {/if}
</div>
<div id="remove_images"></div>
<input type="hidden" name="{$name}" id="{$name}" value="{$object[$name]|@count}" />

{foreach from=$object[$name] item=image name=foo}
    <span style="display:none;" id="descr_image_{$smarty.foreach.foo.index+1}">{$image.descr}</span>
{/foreach}

<script>
    var content = '';
    {if $object[$name]|@count neq 0}
        {foreach from=$object[$name] item=image name=foo}
            content = getContentForUploadedImage ({$smarty.foreach.foo.index+1}, '{$images.small_path}/{$image.path}', '{$images.upload}/{$image.path}', '{$image.path}', '{$images.field}', {if isset($image.title)}'{$image.title}'{else}false{/if}, {if isset($image.descr)}{$smarty.foreach.foo.index+1}{else}false{/if});
            {if $smarty.foreach.foo.index+1 eq 1}
                $('#images_{$images.field}').html(content);
            {else}
                $('#images_{$images.field}').append(content);
            {/if}
        {/foreach}
    {/if}
</script>