{if count($akcii) gt 0}
	<div class="moduletable">
		<h3><span><a style='color: #1F1F1F;' href='/akcii'>Акции</a></span></h3>
		<div class="moduletable_content">
	                	
	
	<script language="javascript">
	{literal}
	$jYtc(document).ready(function($){
		$("#so_slider_69").SoSlider({
			auto		: 	0,
			type		:   'theme2_',
			speed		: 	1000,
	      	visible		: 	4,
	      	start		:	0,
	     	     	circular    :   false,
	      			scroll		:   1,
			btnPrev		: 	'#so_theme2_pre_69',
			btnNext		: 	'#so_theme2_next_69',
			btnPause	: 	'#so_theme2_pause_69',
			navigation	:   '#so_navigation_theme2_69'
		});	   
	});
	{/literal}
	</script>
	<!--Intro Text-->
	<!--End Intro Text-->
	
	<!--Start Module-->
	<div class="yt_article_slider yt_so_article_theme" style="width:784px; background:#FFFFFF;">
	     <div class="title_slider_theme" style="display:none;padding-bottom:5px;padding-top:8px;margin:0px 10px;">Latest News</div>
	     <div class="so_slider_content" id="so_slider_69" style="margin: 0 auto !important;top: 5px;width:768px;">
		     <hr style="border-bottom:1px #dbdbdb solid; border-top:none;border-left: none; border-right: none;margin: 0px 3px 10px 3px;"/>
	         <ul>
	{foreach from=$akcii item=akcia}
		<li style="width: 186px;padding:0px 3px 0px 3px;">
			<div class="so_item">
				<!--<h4 class="so_title"><a href='/akcia/{$akcia.url}' target="_self" title="{$akcia.title}" style="color:#4f4f4f !important;">{$akcia.date}</a></h4>-->
				<div class="so_content" style="width:170px;display:display;">	       			
					<div class="so_description">
						<a href='/akcia/{$akcia.url}' title="{$akcia.title}" style="color: black; font-weight: bold; text-decoration: underline;">{$akcia.title}</a>
						<br/><br/>
						<span class="short_date">[{$akcia.date}]</span>
						<a href='/akcia/{$akcia.url}' title="{$akcia.title}" style="color:#040404 !important;">{$akcia.short_new}</a>
					</div>
		       	</div>
				<div class="so_readmore" style="display:none;">
					<a href="/akcia/{$akcia.url}" target="_self">Подробнее...</a>
				</div>       			
		    </div>
		</li>
	{/foreach}
		     </ul>
		 </div>
	     <div class="so_navigation_hor" id="so_navigation_theme2_69" style="padding-top:0px;display:block;">			
			<div style="position: relative;float:right;margin-right:7px;" class="so_next_hor" id="so_theme2_next_69" style="float: right;"><a href="javascript:void(0)"><span><!--Следующая--></span></a></div>
	        <div style="position: relative;float:right;" class="so_pre_hor" id="so_theme2_pre_69"><a href="javascript:void(0)"><span><!--PRE--></span></a></div>
		 </div>
	 </div>
	<!--End Module-->
	
	
	<!--Start Footer Text-->
	<!--End Footer Text-->
	
	
	
				</div>
			</div>
{/if}
