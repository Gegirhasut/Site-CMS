<div id="component_wrap" class="clearfix gk-mass clear">
	<div>
		<h1 class="componentheading">
			<span>Прайс лист</span>
		</h1>
		<div style="padding:0px 10px 0px 0px;">
            {if isset($text)}
            	{$text}
            	<br/>
            {/if}
            
            {if isset($lastFile)}
            	<div>
	            	<img height="40" border="0" src="/images/app/excel.png"/>
					<span style="top:-15px;position:relative;">
						<a href="/excel/{$lastFile}">Скачать прайс-лист</a> с мини изображениями товаров {$lastFileSize}
					</span>
				</div>
            {/if}
			<br/>
			{if isset($lastFileZipSize)}
				<div>
					<img height="40" border="0" src="/images/app/rar.png"/>
					<span style="top:-15px;position:relative;">
	            		<a href="/excel/{$lastFileZip}">Скачать прайс-лист</a> с мини изображениями товаров {$lastFileZipSize}
					</span>
				</div>
            {/if}
			<br/>
			<hr/>
			<br/>
			{if isset($lastFile2)}
            	<div>
	            	<img height="40" border="0" src="/images/app/excel.png"/>
					<span style="top:-15px;position:relative;">
						<a href="/excel/{$lastFile2}">Скачать прайс-лист</a> без изображений {$lastFileSize2}
					</span>
				</div>
            {/if}
			<br/>
			{if isset($lastFileZipSize2)}
				<div>
					<img height="40" border="0" src="/images/app/rar.png"/>
					<span style="top:-15px;position:relative;">
	            		<a href="/excel/{$lastFileZip2}">Скачать прайс-лист</a> без изображений {$lastFileZipSize2}
					</span>
				</div>
            {/if}
		</div>
	</div>
</div>

{include file="units/jquery_notice.tpl"}