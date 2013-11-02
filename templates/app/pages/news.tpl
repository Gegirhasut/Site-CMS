<div id="component_wrap" class="clearfix gk-mass clear">
	<div>
		<h1 class="componentheading">
			<span>Новости</span>
		</h1>
		<div class="blog clearfix">
{foreach from=$news item=new}
			<div class="leading clearfix">
				<div class="contentpaneopen">
					<div class="article-wrap">
						<div class="article-content clearfix">
							<span class="short_date" style="float: left;">[{$new.date}]&nbsp;</span>
							<h3 style="text-align: left;">{$new.title}</h3>
						</div>
						
						<a href="/new/{$new.url}" title="{$new.title}" class="readon">
							<span>{$new.short_new}</span>
						</a>
					</div>
				</div>
			</div>
{/foreach}

			{include file="units/pager.tpl"}
			
		</div>
	</div>
</div>