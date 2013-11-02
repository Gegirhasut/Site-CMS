<div id="component_wrap" class="clearfix gk-mass clear">
	<div>
		<h1 class="componentheading">
			<span>Акции</span>
		</h1>
		<div class="blog clearfix">
			
{foreach from=$akcii item=akcia}
			<div class="leading clearfix">
				<div class="contentpaneopen">
					<div class="article-wrap">
						<div class="article-content clearfix">
						<span class="short_date" style="float: left;">[{$akcia.date}]&nbsp;</span>
							<h3 style="text-align: left;">{$akcia.title}</h3>
						</div>
						<a href="/akcia/{$akcia.url}" title="{$akcia.title}" class="readon">
							<span>{$akcia.short_new}</span>
						</a>
					</div>
				</div>
			</div>
{/foreach}

			{include file="units/pager.tpl"}
			
		</div>
	</div>
</div>