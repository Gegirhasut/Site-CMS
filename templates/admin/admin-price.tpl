<html>
<body>
    {$menu}
	<form method="post" enctype="multipart/form-data">
		<input type="file" name="file" id="file"><br>
		<input type="submit" name="submit" value="Залить">
	</form>
	<br/>
	{if isset($lastFile)}
		В данный момент используются данные файла <b>{$lastFile}</b>!<br/>
	{/if}
	{if isset($lastFileClients)}
		Клиентам отдается файл <b>{$lastFileClients}</b>!<br/>
	{/if}
	{if isset($removed)}
		Старый файл с таким же именем был удален!<br/>
	{/if}
	{if isset($uploaded)}
		Новый файл успешно загружен!<br/>
	{/if}
	{if isset($error)}
		{$error}<br/>
	{/if}
	
	{if isset($lastFile)}
		</br></br>
		Для импорта данных из последнего прайс-листа перейдите по ссылке:
		<a target="_blank" href="/excel/import.php?file={$lastFile}">ИМПОРТ</a>
		</br></br>
		Скрипт делает следующее:</br>
		1. Создает новые категории, если такие будут в файле.</br>
		2. Добавляет новые товары.</br>
		3. Изменяет данные по существующим товарам, признаком идентификации товара используется КОД товара из excel файла.</br>
	{/if}
		     
</body>
</html>