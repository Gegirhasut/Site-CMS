<div class="h">
    <h1>
        {if isset($section)}
            {$section.title}
        {else}
            {$category}
        {/if}
    </h1>
</div>

<tr>
 <td>
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
   <tr>
    <td class="col_left">
     <table border="0" cellspacing="0" cellpadding="0" class="box_width_left">
      <tr>
       <td width="100%" style="text-align:center">
        <img src="/images/app/spacer.gif" border="0" alt="" width="1" height="160">
        <br/>
        <a href="/">
        <img src="/images/app/logo.png" border="0" alt="Веселое торжество" width="190" height="73"></a>
        <br/>
        <img src="/images/app/spacer.gif" border="0" alt="" width="1" height="19">
        <br/>
        
        <table border="0" cellspacing="0" cellpadding="0" align="center" style="width:190px">
         {include file="units/menu.tpl"}
        </table>        
       </td>
       <td><img src="/images/app/spacer.gif" border="0" alt="" width="5" height="1"></td>
      </tr>
     </table>
    </td>
    <td width="100%" class="col_center">
    
     <form name="cart_quantity" action="/" method="post">
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
       <tr>
        <td>
        
         <table cellpadding="0" cellspacing="0" border="0" class="cont_heading_table">
          <tr>
           <td><img src="/images/app/cont_corn_tl.gif" border="0" alt="" width="12" height="12"></td>
           <td class="cont_body_tall_t"><img src="/images/app/spacer.gif" border="0" alt="" width="1" height="1"></td>
           <td><img src="/images/app/cont_corn_tr.gif" border="0" alt="" width="12" height="12"></td>
          </tr>
          <tr>
           <td><img src="/images/app/cont_heading_l_3.gif" border="0" alt="" width="12" height="26"></td>
           <td width="100%" class="cont_heading_td">
            <img src="/images/app/1_z1.gif" border="0" alt="" width="16" height="11"> &nbsp;
            {if isset($section)}
                <b>{$section.title}</b>
            {else}
                <b>{$category}</b>
            {/if}
           </td>
           <td><img src="/images/app/cont_heading_r_3.gif" border="0" alt="" width="12" height="24"></td>
          </tr>
          <tr>
           <td><img src="/images/app/cont_corn_bl.gif" border="0" alt="" width="12" height="12"></td>
           <td class="cont_body_tall_b"><img src="/images/app/spacer.gif" border="0" alt="" width="1" height="1"></td>
           <td><img src="/images/app/cont_corn_br.gif" border="0" alt="" width="12" height="12"></td>
          </tr>                   
         </table>
                                             
         <img src="/images/app/spacer.gif" border="0" alt="" width="1" height="9">
         <br/> 
           
         <table cellpadding="0" cellspacing="0" border="0" class="cont_body_table_2 product">
          <tr>
           <td><img src="/images/app/cont_body_corn_tl.gif" border="0" alt="" width="20" height="20"></td>
           <td width="100%" class="cont_body_tall_t_2"><img src="/images/app/spacer.gif" border="0" alt="" width="1" height="1"></td>
           <td><img src="/images/app/cont_body_corn_tr.gif" border="0" alt="" width="20" height="20"></td>
          </tr>
          <tr>
           <td class="cont_body_tall_l_2"><img src="/images/app/spacer.gif" border="0" alt="" width="1" height="1"></td>
           <td width="100%" class="cont_body_td_2" align="center">
            <em>
             {if isset($subcategory)}
              {$subcategory}
             {else}
              Главная
             {/if}
            </em>
           </td>
           <td class="cont_body_tall_r_2"><img src="/images/app/spacer.gif" border="0" alt="" width="1" height="1"></td>
          </tr>
          <tr>
           <td><img src="/images/app/cont_body_corn_bl.gif" border="0" alt="" width="20" height="13"></td>
           <td width="100%" class="cont_body_tall_b_2"><img src="/images/app/spacer.gif" border="0" alt="" width="1" height="1"></td>
           <td><img src="/images/app/cont_body_corn_br.gif" border="0" alt="" width="20" height="13"></td>
          </tr>
          
         </table>
         
         <div class="h">
             <h2>
                 {if isset($subcategory)}
                     {$subcategory}
                 {else}
                     Стихи и поздравления
                 {/if}
             </h2>
         </div>
         
         <table cellpadding="0" cellspacing="0" border="0" class="heading_top_4">
          <tr>
           <td class="padd_44">
            <table cellpadding="0" cellspacing="0" border="0" class="heading_top_2">
             <tr>
              <td class="padd_22">
               <table cellspacing="0" cellpadding="0" border="0" class="product">
                <tr>
                 <td>
                  <table cellspacing="0" cellpadding="0" border="0">
                   <tr>
                    <td height="100%">
                     <div class="padd3">
                     
                      {if isset($section)}
                        {$section.text}
                      {/if}
                      
                      {if isset($search)}
                      	{literal}
                      		<div id="ya-site-results" onclick="return {'tld': 'ru', 'language': 'ru', 'encoding': ''}"></div><script type="text/javascript">(function(w,d,c){var s=d.createElement('script'),h=d.getElementsByTagName('script')[0];s.type='text/javascript';s.async=true;s.charset='utf-8';s.src=(d.location.protocol==='https:'?'https:':'http:')+'//site.yandex.net/v2.0/js/all.js';h.parentNode.insertBefore(s,h);(w[c]||(w[c]=[])).push(function(){Ya.Site.Results.init()})})(window,document,'yandex_site_callbacks');</script>
                      	{/literal}
                      {else}
                      
	                      {foreach from=$records item=record}
	                        <p style="text-align: justify; ">
	                        	<span style="color:purple;">
	                        		<span style="font-size: 14px; ">
	                                    <span id="mess_{$record.r_id}">
	                                        {$record.description}
	                                    </span>
	                                    <table style="width: 130px;float: right;">
	                                        <tr>
	                                            <td style="vertical-align: middle;">
	                                                <a href="/forms/send.html?height=500&width=600&r_id={$record.r_id}" title="Отправить по почте" class="thickbox" style=" color: purple;">Отправить по почте</a>
	                                            </td>
	                                            <td style="vertical-align: middle;"><a href="/forms/send.html?height=500&width=600&r_id={$record.r_id}" title="Отправить по почте" class="thickbox" style=" color: purple;"><img src="/images/app/mail2.png" width="20px" /></a></td>
	                                        </tr>
	                                    </table>
	                                    </span>
	                                </span>
	                        	</span>
	                        </p>
			                          
	                          <table cellspacing="0" cellpadding="0" border="0" align="center" style="margin:15px 0px 15px 0px; height:1px;">
	                           <tr>
	                            <td class="bg_line_x"><img src="/images/app/spacer.gif" border="0" alt="" width="1" height="1"></td>
	                           </tr>
	                          </table>
	                      {/foreach}
	                   {/if}
                     </div>                                                                 
                    </td>
                   </tr>
                  </table>
                 </td>
                </tr>
               </table>
              </td>
             </tr>
            </table>
           </td>
          </tr>
         </table>
         
         <table cellpadding="0" cellspacing="0" border="0" class="cont_heading_table">
          <tr>
           <td><img src="/images/app/cont_corn_bl_2.gif" border="0" alt="" width="16" height="16"></td>
           <td style="width:100%; background:url(/images/app/cont_corn_bc_2.gif) "><img src="/images/app/spacer.gif" border="0" alt="" width="1" height="1"></td>
           <td><img src="/images/app/cont_corn_br_2.gif" border="0" alt="" width="16" height="16"></td>
          </tr>
         </table>
         <table cellpadding="0" cellspacing="0">
          <tr>
           <td class="tep_draw_separate"><img src="/images/app/spacer.gif" border="0" alt="" width="1" height="1"></td>
          </tr>
         </table>
         
         {if isset($pages)}
         
         <table cellpadding="0" cellspacing="0" border="0" class="cont_heading_table">
          <tr>
           <td><img src="/images/app/cont_corn_tl.gif" border="0" alt="" width="12" height="12"></td>
           <td class="cont_body_tall_t"><img src="/images/app/spacer.gif" border="0" alt="" width="1" height="1"></td>
           <td><img src="/images/app/cont_corn_tr.gif" border="0" alt="" width="12" height="12"></td>
          </tr>
          <tr>
           <td><img src="/images/app/cont_heading_l_3.gif" border="0" alt="" width="12" height="26"></td>
           <td width="100%" class="cont_heading_td">
            <img src="/images/app/1_z1.gif" border="0" alt="" width="16" height="11"> &nbsp;
            Страницы&nbsp;&nbsp;
            {section name=pageNum start=1 loop=$pages step=1}
                {if $smarty.section.pageNum.index eq $currentPage}
                    {$smarty.section.pageNum.index}&nbsp;&nbsp;
                {else}
                	{if $smarty.section.pageNum.index eq 1}
                		<a href="{$url}" style="text-decoration: underline;" {if isset($subcategory_name)}title="{$subcategory_name}"{/if}>{$smarty.section.pageNum.index}</a>
                	{else}
                    	<a href="{$url}/{$smarty.section.pageNum.index}" style="text-decoration: underline;" {if isset($subcategory_name)}title="{$subcategory_name}, страница {$smarty.section.pageNum.index}"{/if}>{$smarty.section.pageNum.index}</a>
                    {/if}
                    &nbsp;&nbsp;
                {/if}
            {/section}
           </td>
           <td><img src="/images/app/cont_heading_r_3.gif" border="0" alt="" width="12" height="24"></td>
          </tr>
          <tr>
           <td><img src="/images/app/cont_corn_bl.gif" border="0" alt="" width="12" height="12"></td>
           <td class="cont_body_tall_b"><img src="/images/app/spacer.gif" border="0" alt="" width="1" height="1"></td>
           <td><img src="/images/app/cont_corn_br.gif" border="0" alt="" width="12" height="12"></td>
          </tr>                   
         </table> 
         
         {/if}
         
        </td>
       </tr>
      </table>
     </form>
     
    </td>
    <td class="col_right">
     <table border="0" cellspacing="0" cellpadding="0" class="box_width_right">
      <tr>
       <td></td>
       <td width="100%">
        <table border="0" cellspacing="0" cellpadding="0">
         <tr><td></td></tr>
        </table>
       </td>
      </tr>
     </table>
    </td>
   </tr>
  </table>
 </td>
</tr>