<br>
Страницы:
{if ($currentPage) gt 1}
    <a href="?page={$currentPage-1}"><<</a>
{/if}
{section name=pages start=1 loop=$pagesCount+1 step=1}
    {if $smarty.section.pages.index eq $currentPage}
        {$smarty.section.pages.index}
    {else}
        <a href="?page={$smarty.section.pages.index}">{$smarty.section.pages.index}</a>
    {/if}
{/section}
{if ($currentPage) lt $pagesCount}
    <a href="?page={$currentPage+1}">>></a>
{/if}
