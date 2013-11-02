{if $count_pages gt 1}
	<div style="padding-top: 15px;float: left;">
		Страницы
		&nbsp;&nbsp;&nbsp;
		{if isset($prev_page)}
			<a href="/{$pageName}/{$prev_page}" title=" Предыдущая страница ">←</a>
		{else}
			←
		{/if}
		{section name=page loop=$count_pages} 
			{if $smarty.section.page.iteration eq $current_page}
				{$smarty.section.page.iteration}
			{else}
				<a href="/{$pageName}/{$smarty.section.page.iteration}" title="Страница {$smarty.section.page.iteration}">{$smarty.section.page.iteration}</a>
			{/if}
		{/section}
		{if isset($next_page)}
			<a href="/{$pageName}/{$next_page}" title=" Следующая страница ">→</a>
		{else}
			→
		{/if}
	</div>
{/if}