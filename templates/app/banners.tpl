<div id="banner1" class="clear clearfix">
	<div class="moduletable clear">
		<div class="moduletable_content">
		
			<div id="gk_is-newsimage1" class="gk_is_wrapper gk_is_wrapper-template slide-links">
				
				<div class="slider-wrapper theme-default">
		            <div id="slider" class="nivoSlider">
		            	{foreach from=$banners item=banner}
		                	<a href="{$banner.url}"><img width="1100" src="/images/small/{$banner.img}" data-thumb="/images/small/{$banner.img}" alt="" title="{$banner.text}" /></a>
		                {/foreach}
		            </div>
		        </div>
				
			</div>
			
			
			
    		<script type="text/javascript" src="/js/jquery-1.7.1.min.js"></script>
			<script type="text/javascript" src="/js/jquery.nivo.slider.pack.js"></script>
		    <script type="text/javascript">
		    	jQuery.noConflict();
		    	{literal}
			    jQuery(window).load(function() {
			        jQuery('#slider').nivoSlider({
			        	directionNav:false,
			        	pauseOnHover:true
			        });
			    });
			    {/literal}
		    </script>
		    		
		    
			<script type="text/javascript">
			{literal}
				try {$Gavick;}catch(e){$Gavick = {};};
				$Gavick["gk_is-newsimage1"] = {
					"anim_speed": 500,
					"anim_interval": 5000,
					"autoanim": true,
					"slide_links": true	};
			{/literal}
			</script>
			
		</div>
	</div>
</div>