<html>
<head>
    <script>
     {if isset($post)}
      window.close();
     {/if}
    </script>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="/js/calendar.js"></script>
    <script type="text/javascript" src="/js/calendar-ru.js"></script>
    <script type="text/javascript" src="/js/calendar-setup.js"></script>
    
    <link rel="stylesheet" type="text/css" href="/css/calendar.css" />
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