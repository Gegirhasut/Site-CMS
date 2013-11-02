<div id="component_wrap" class="clearfix gk-mass clear">
	<div>
		<div id="component" class="clear">
			<h2 class="contentheading clearfix">
				<span>Партнеры</span>
			</h2>
			<div class="article-content">
				{foreach from=$partners item=partner}
					<p>
						<a target="_blank" href="{$partner.url}" title="{$partner.description}"><img src="{$partner.img_path}" style="max-width: 400;" alt="{$partner.description}"></a>
					</p>
				{/foreach}
			</div>
		</div>
    </div>
</div>