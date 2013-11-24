{if $count_pages gt 1}
	<div class="au-toolbar-bottom">
        <div class="au-pagination">
            <div class="au-pagination__controls" style="float: left;">
                {if isset($prev_page)}
                    <a href="{if $prev_page eq 1}{$base_url}{else}?page={$prev_page}{/if}" class="au-pagination__controls__item _prev_page" data-navigate="true" title="previous page">
                        <span class="au-text">← previous page</span>
                    </a>
                {else}
                    <span class="au-pagination__controls__item">← previous page</span>
                {/if}
            </div>
            <div class="au-pagination__controls" style="float: right;">
                {if isset($next_page)}
                    <a href="?page={$next_page}" class="au-pagination__controls__item _next_page" data-navigate="true" title="next page">
                        <span class="au-text">next page</span> <span class="au-icon">→</span>
                    </a>
                {else}
                    <span class="au-pagination__controls__item">next page →</span>
                {/if}
            </div>
            <div style="clear:both;"></div>
            <ul class="au-pagination__list">
                {foreach from=$prev_pages item=page}
                    {if $page eq '...'}
                        <li><span>...</span></li>
                    {else}
                        <li><a href="{if $page eq 1}{$base_url}{else}?page={$page}{/if}" title="Page {$page}">{$page}</a></li>
                    {/if}
                {/foreach}
                <li><span class="current">{$current_page}</span></li>
                {foreach from=$next_pages item=page}
                    {if $page eq '...'}
                        <li><span>...</span></li>
                    {else}
                        <li><a href="?page={$page}" title="Page {$page}">{$page}</a></li>
                    {/if}
                {/foreach}
            </ul>
        </div>
	</div>
{/if}