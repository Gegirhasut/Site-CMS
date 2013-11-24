{include file="units/html_head.tpl"}
<center>

    <input type="hidden" id="small_path" value="/{$small_path}" />
    <input type="hidden" id="big_path" value="/{$big_path}" />

    <div class="wrapper">
        <div class="wrapper_content">
            {include file="units/search-form.tpl"}
            {include file="app/pages/$content_page.tpl"}
        </div>
    </div>
</center>
{include file="units/html_bottom.tpl"}