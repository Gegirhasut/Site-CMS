{if count($news) gt 0}
	<div class="moduletable">
		<h3><span><a style='color: #1F1F1F;' href='/news'>Последние новости</a></span></h3>
		<div class="moduletable_content">
	                	
	<script language="javascript">
	{literal}
	$jYtc(document).ready(function($){
		$("#so_slider_63").SoSlider({
			auto		: 	0,
			type		:   'theme2',
			speed		: 	1000,
	      	visible		: 	4,
	      	start		:	0,
	     	circular    :   false,
			scroll		:   1,
			btnPrev		: 	'#so_theme2_pre_63',
			btnNext		: 	'#so_theme2_next_63',
			btnPause	: 	'#so_theme2_pause_63',
			navigation	:   '#so_navigation_theme2_63'
		});	   
	});
	{/literal}
	</script>
	<!--Intro Text-->
	<!--End Intro Text-->
	
	<!--Start Module-->
	<div class="yt_article_slider yt_so_article_theme" style="width:784px; background:#FFFFFF;">
	     <div class="title_slider_theme" style="display:none;padding-bottom:5px;padding-top:8px;margin:0px 10px;">Latest News</div>
	     <div class="so_slider_content" id="so_slider_63" style="margin: 0 auto !important;top: 5px;width:768px;">
		     <hr style="border-bottom:1px #dbdbdb solid; border-top:none;border-left: none; border-right: none;margin: 0px 3px 10px 3px;"/>
	         <ul>
	{foreach from=$news item=new}
		<li style="width: 234px;padding:0px 3px 0px 3px;">
			<div class="so_item">
				<!-- <h4 class="so_title"><a href='/new/{$new.url}' target="_self" title="{$new.title}" style="color:#4f4f4f !important;">{$new.date}</a></h4> -->
		       	<div class="so_content" style="width:234px;display:display;">	       			
					<div class="so_description" style="width:234px; color:#040404 !important;">
						<a href='/new/{$new.url}' title="{$new.title}" style="color: black; font-weight: bold; text-decoration: underline;">{$new.title}</a>
						<br/>
						<span class="short_date">[{$new.date}]</span>
						<a href='/new/{$new.url}' title="{$new.title}" style="color:#040404 !important;line-height: 14px;">{$new.short_new}</a>
					</div>
				</div>
				<div class="so_readmore" style="display:none;">
					<a href="/new/{$new.url}" target="_self">Подробнее...</a>
				</div>       			
			</div>
		</li> 
	{/foreach}
		     </ul>
		 </div>
	     <div class="so_navigation_hor" id="so_navigation_theme2_63" style="padding-top:0px;display:block;">			
			<div style="position: relative;float:right;margin-right:7px;" class="so_next_hor" id="so_theme2_next_63" style="float: right;"><a href="javascript:void(0)"><span><!--Следующая--></span></a></div>
	        <div style="position: relative;float:right;" class="so_pre_hor" id="so_theme2_pre_63"><a href="javascript:void(0)"><span><!--PRE--></span></a></div>
		 </div>
	 </div>
	<!--End Module-->
	
	
		</div>
	</div>
{/if}