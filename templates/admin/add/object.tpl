<html>
<head>
    <script>
     {if isset($post)}
      window.close();
     {/if}
    </script>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/js/jquery-ui-1.9.2/jquery-1.8.3.js"></script>
    <script type="text/javascript" src="/js/calendar.js"></script>
    <script type="text/javascript" src="/js/calendar-ru.js"></script>
    <script type="text/javascript" src="/js/calendar-setup.js"></script>
    
    <link rel="stylesheet" type="text/css" href="/css/calendar.css" />
    <link rel="stylesheet" type="text/css" href="/css/admin.css" />

    <script src="/js/jquery-ui-1.9.2/ui/jquery-ui.js"></script>
    <link href="/css/themes/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css">

</head>
<body>
	<table>
	 <tr>
	  <td valign="top">
          {include file="admin/units/fields.tpl"}
	  </td>
         {include file="admin/units/field_upload.tpl"}
     </tr>
	</table>

    {include file="admin/units/field_geo.tpl"}
	 
</body>
</html>