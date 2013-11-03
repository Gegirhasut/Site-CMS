<html>
<head>
<script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
<link rel="stylesheet" href="/css/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="/js/thickbox.js"></script>

<script type="text/javascript" src="/js/calendar.js"></script>
<script type="text/javascript" src="/js/calendar-ru.js"></script>
<script type="text/javascript" src="/js/calendar-setup.js"></script>

<link rel="stylesheet" type="text/css" href="/css/calendar.css" />

    <script>
     {if isset($post)}
      window.close();
     {/if}
    </script>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    
    <script src="/js/jquery.ui.core.min.js"></script>
    <script src="/js/jquery.ui.widget.min.js"></script>
    <script src="/js/jquery.ui.position.min.js"></script>
    <script src="/js/jquery.ui.autocomplete.min.js"></script>
    <link href="/css/themes/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css">

</head>
<body>
    <script>
        var callFunctions = [];
        {literal}
        function callCallFunctions() {
            for(var i = 0; i< callFunctions.length; i++) {
                callFunctions[i]();
            }
            return true;
        }
        {/literal}
    </script>

    <table {if !isset($fields.img)}width="100%"{/if}>
     <tr>
      <td valign="top">
          {include file="admin/units/fields.tpl"}
       </td>
         {include file="admin/units/field_upload.tpl"}
      </tr>

        {include file="admin/units/field_many_to_many.tpl"}

     </table>

    {include file="admin/units/field_geo.tpl"}

</body>
</html>