<link href="/css/jquery.Jcrop.css" type="text/css" rel="stylesheet">
<link href="/css/ajaxfileupload.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="/css/thickbox.css" type="text/css" media="screen" />

<script type="text/javascript" src="/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="/js/jquery.Jcrop.js"></script>
<script type="text/javascript" src="/js/thickbox.js"></script>

<script type="text/javascript">
var picW = {$fields.img.w};
var picH = {$fields.img.h};
var imgField = '{$fields.img.field}';
var imgSmallPath = '{$fields.img.small_path}';
var imgUpload = '{$fields.img.upload}';

{literal}
var jcrop_api;

function replaceImageContent(smallPath, bigPath, fileName) {
    var content = '<a href="/' + bigPath + '" title="Большая картинка" class="thickbox">';
    content += '<img src="/' + smallPath + '" alt="Увеличить картинку">';
    content += '</a>';
    
    content += "<input type='hidden' name='" + imgField + "' value='" + fileName + "' />";
    $('#' + imgField).html(content);
    
    tb_init('a.thickbox');
}

function ajaxFileUpload()
{
    if ($('#fileToUpload').val() == "")
        return;
	$("#loading")
	.ajaxStart(function(){
		$(this).show();
	})
	.ajaxComplete(function(){
		$(this).hide();
	});

	$.ajaxFileUpload
	(
		{
			url:'/ajax/file_upload/',
			secureuri:false,
			fileElementId:'fileToUpload',
			dataType: 'json',
			data: {name: 'logan', id: 'id', upload: imgUpload},			
			success: function (data, status)
			{
			    $("#submit").attr("disabled", "disabled");
				weight = data.w;
				height = data.h;
				var table = '<table>';
				table += '<tr>';
                table += '<td valign="top">Выберите облать на картинке для создания маленького изображения</td>';
                table += '</tr>';
				table += '<tr>';
				table += '<td valign="top"><img id="jcrop_target" src="/' + data.path + '" style="width: "' + data.w + '"px; height: "' + data.h + '"px; display: none; "/></td>';
				table += '</tr>';
				table += '<tr>';
				table += '<td valign="top"><div style="width:' + picW + 'px;height:' + picH + 'px;overflow:hidden;margin-left:5px;"><img src="/' + data.path + '" id="preview"/></div><button class="button" onclick="createUserPic(\'' + data.path + '\',  \'' + imgSmallPath + '\', \'' + imgUpload + '\', \'' + data.fileName + '\')"> Создать маленькую картинку </button>&nbsp;&nbsp;&nbsp;<button class="button" onclick="cancelUpload()"> Отменить </button>';
				table += '</tr>';
				table += '</table>';
				
				$("#img_preview").html(table);
				
				$('#jcrop_target').Jcrop({
					onChange: showPreview,
					onSelect: showPreview,
					setSelect: [0,0,picW,picH],
					aspectRatio: picW / picH
				}, function() {
				    jcrop_api = this;
				});
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	)
	
	return false;
}

function cancelUpload() {
    $('#img_preview').html('');
    $("#submit").removeAttr("disabled");
}

function createUserPic(path, imgSmallPath, uploadPath, fileName) {
    $("#submit").removeAttr("disabled");
    var obj = jcrop_api.tellSelect();
    $.post(
        "/ajax/user_pic/",
        {path: path, x: obj.x, y: obj.y, x2: obj.x2, y2: obj.y2, dest_w: picW, dest_h: picH, operation: "upload", imgSmallPath: imgSmallPath, uploadPath: uploadPath},
        function (newPath) {
            var html = '<img src="/' + newPath + '" />';
            $('#img_preview').html('');
            replaceImageContent(newPath, path, fileName);
        }
    );
}

var weight = 500;
var height = 370;

function showPreview(coords)
{
	var rx = picW / coords.w;
	var ry = picH / coords.h;
	
    $('#preview').css({
        width: Math.round(rx * weight) + 'px',
        height: Math.round(ry * height) + 'px',
        marginLeft: '-' + Math.round(rx * coords.x) + 'px',
        marginTop: '-' + Math.round(ry * coords.y) + 'px'
    });
}
</script>
{/literal}

<img id="loading" src="/images/loading.gif" style="display:none;">
<form name="form" action="" method="POST" enctype="multipart/form-data">
	<input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input" />
	<button class="button" id="buttonUpload" onclick="return ajaxFileUpload();"> Загрузить файл </button>
</form>

<div id="img_preview"></div>