<div id="gk-nav" class="clearfix">
    <div id="gk-mainnav">
		<div class="gk-menu clearfix">
			<ul id="gk-menu" class="level0">
				{foreach from=$top_menu item=menu name=top_menu}
					<li class="mega{if isset($menu.selected)} active{/if}{if $smarty.foreach.top_menu.first} first{/if}{if $smarty.foreach.top_menu.last} last{/if}{if $menu.subs neq null} haschild{/if}">
						<a href="{if $menu.subs neq null}javascript:;{else}{if $menu.url neq '/'}/{/if}{$menu.url}{/if}" class="mega{if isset($menu.selected)} active{/if}" id="menu1" title="{$menu.title}"><span class="menu-title"><span>{$menu.menu}</span></span></a>
						
						{if $menu.subs neq null}
							<div class="childcontent cols1 ">
								<div class="childcontent-inner-wrap">
									<div class="childcontent-inner clearfix" style="width: 200px;">
										<div class="megacol column1 first last" style="width: 200px;">
											<ul  class="level1">
												{foreach from=$menu.subs item=submenu name=top_submenu}
													<li class="mega{if $smarty.foreach.top_submenu.first} first{/if}{if $smarty.foreach.top_submenu.last} last{/if}">
														<a href="/{$submenu.url}" class="mega first" id="menu" title="{$submenu.title}"><span class="menu-title"><span>{$submenu.menu}</span></span></a>
													</li>
												{/foreach}
											</ul>
										</div>
									</div>
								</div>
							</div>
						{/if}
					</li>
				{/foreach}
				
			</ul>
		</div>
		<script type="text/javascript">
		{literal}
					var megamenu = new gkMegaMenuMoo ('gk-mainnav', {
						'bgopacity': 0, 
						'delayHide': 1000, 
						'slide': 1, 
						'fading': 0,
						'direction':'down',
						'action':'mouseover',
						'tips': false,
						'duration': 3,
						'hidestyle': 'fastwhenshow'
					});
		{/literal}
		</script>
	</div>
</div>