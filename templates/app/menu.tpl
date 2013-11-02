<div class="moduletable">
	<h3><span>Каталог</span></h3>
	<div class="moduletable_content">
		{foreach from=$menu item=item}
			<a title="{$item.menu}" style="display:block;" class="mainlevel" {if $item.subs eq null}href="{if $item.url eq "/"}/{else}/{$item.url}{/if}"{else}href="javascript:;"{/if} onclick="openMenu('{$item.url}')">{$item.name}</a>
			{if $item.subs neq null}
				<div id="{$item.url}" {if !isset($item.selected)}style="display: none; "{/if}>
	            	{foreach from=$item.subs item=sub name=foo2}
	            		<a title="{$sub.name}" style="display:block;font-style:italic;" class="sublevel" href="/{$item.url}/{$sub.url}" id="active_menu">&nbsp;&nbsp;&nbsp;{$sub.name}</a>
	                {/foreach}
               	</div>
            {/if}
		{/foreach}
	</div>
</div>

<script>
{literal}

function openMenu(name) {
    jQuery("div#" + name).toggle()
}

{/literal}
</script>