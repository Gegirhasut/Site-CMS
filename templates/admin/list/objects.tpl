<html xmlns="http://www.w3.org/1999/html">
<head>
    <!-- <script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script> -->
    <script type="text/javascript" src="/js/jquery-ui-1.9.2/jquery-1.8.3.js"></script>

    <link rel="stylesheet" href="/css/thickbox.css" type="text/css" media="screen">
    <script type="text/javascript" src="/js/thickbox.js"></script>
    
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <style type="text/css">
        .fields {ldelim} font-size: 13px; {rdelim}
    </style>

    <!--<script src="/js/jquery.ui.core.min.js"></script>
    <script src="/js/jquery.ui.widget.min.js"></script>
    <script src="/js/jquery.ui.position.min.js"></script>
    <script src="/js/jquery.ui.autocomplete.min.js"></script>-->

    <script src="/js/jquery-ui-1.9.2/ui/jquery-ui.js"></script>

    <link href="/css/themes/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css">
    <link href="/css/admin.css" rel="stylesheet" type="text/css">
    
    <script>
        {literal}
        function open_window(link,w,h)
        {
            var win = "width="+w+",height="+h+",menubar=no,location=no,resizable=yes,scrollbars=yes";
            newWin = window.open(link,'newWin',win);
            setTimeout("checkWin()", 1000);
        }
        
        function checkWin() {
            if (newWin.closed == false) {
                setTimeout("checkWin()", 500);
            } else {
                window.location.reload();
            }
        }
        {/literal}
    </script>
    
</head>
<body>

    {$menu}

    <div width="100%" style="padding: 10px;">
    
    <a href="javascript:open_window('/admin/add-update/{$class}/',1000,800);">Добавить!</a>
    <br/><br/>
    
    <table border="1" cellspacing="0" cellpadding="3" bordercolor="#C3BD7C" bordercolordark="#FFFFE2" width="100%" id="sortable">

    {include file="admin/list/units/head.tpl"}

    {include file="admin/list/units/objects.tpl"}
    
    </table>

    {if isset($sort)}
        <script>
            {literal}
            $( "#sortable" ).sortable({
                helper: "clone",
                cursor: "move",
                items: "tr.drag",
                update: function(event, ui) {
                    var id_order = $('#sortable tr .hidden_identity');
                    var new_order = '';
                    for (i = 0; i < id_order.length; i++) {
                        var cur = $(id_order[i]).val();
                        new_order += (new_order == '') ? cur : ',' + cur;
                    }
                    $.get('/admin/sort/{/literal}{$class}{literal}/?order=' + new_order, function (data) {
                        var index = 1;
                        var fields = $('.sort_field');
                        for (i = 0; i < fields.length; i++) {
                            $(fields[i]).html(index);
                            index++;
                        }

                    });
                },
                start: function (event, ui) {
                    var tds = $('#sortable tr th');
                    var helper = $($('#sortable tr')[$('#sortable tr').length-1]);
                    //if (typeof helper !== 'undefined') {
                        for (i = 0; i < tds.length; i++) {
                            $($(helper).find('td')[i]).width($(tds[i]).width());
                        }
                    //}
                }
            });
            {/literal}
        </script>
    {/if}

    {include file="admin/units/pager.tpl"}

    {if isset($fields.truncate)}
    	<br/>
	    <a href="javascript:open_window('/admin/truncate/{$class}/',200,200);">Удалить всех</a>
    {/if}
   
   </div>
    
<br/>
<hr/>
<br/>
{include file="admin/admin-logout.tpl"}
    
</body>
</html>