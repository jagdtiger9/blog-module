<script language="javascript">
function setDefault(formName,fieldType)
{
   if (fieldType=='imglist_tpl') {
      code = '<div class="fileItem"><a id="fancyImage" href="!imgPath"><img src="!previewPath" border="1" width="!width" height="!height"></a><div style="align:center;margin:5px 0 0 0;"><a href="#" onclick="opener.window.document.getElementById('src').value='!imgPath'; window.close();"><img src="/static/icon/ico_ok.gif" border="0"></a>&nbsp;&nbsp;<a href="#"><img src="/static/icon/close16x16.png" border="0"></a></div></div>';
   }
   document.getElementById(formName).elements[fieldType].value = code;
}
</script>

<table>
<form name="mainForm" method="post" action="">
<tr bgcolor="#DFDFDF">
  <td colspan="2" align="center"><h4>Настройки блогов</h4></td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
  <td colspan="2" bgcolor="#DFDFDF"><h5>Настройки редактора</h5></td>
</tr>
<tr>
   <td><b>Панель инструментов</b></td>
   <td>
     <select name="toolBar">
   	    <option value="full" <?= $setting->toolBar == 'full' ? 'selected' : ''?>>Полная</option>
   	    <option value="light" <?= $setting->toolBar == 'light' ? 'selected' : ''?>>Облегченная</option>
   	    <option value="simple" <?= $setting->toolBar == 'simple' ? 'selected' : ''?>>Простая</option>
    </select> &nbsp;
    [ Таблицы
    <select name="withTables">
   	    <option value="0" <?= $setting->withTables == '0' ? 'selected' : ''?>>выкл</option>
   	    <option value="1" <?= $setting->withTables == '1' ? 'selected' : ''?>>вкл</option>
	</select> ]
   </td>
</tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr>
  <td colspan="2" bgcolor="#DFDFDF"><h5>Вывод картинок в списке для вставки в текст</h5></td>
</tr>
<tr>
   <td><b>Макс. ширина картинок</b></td>
   <td><input type="text" name='maxImgX' value=<?= $setting->maxImgX ? : '1200';?>></td>
</tr>
<tr>
   <td><b>Ширина превью</b></td>
   <td><input type="text" name='prevX' value=<?= $setting->prevX ? : '200';?>></td>
</tr>
<tr>
   <td><b>Высота превью</b></td>
   <td><input type="text" name='prevY' value=<?= $setting->prevY ? : '150';?>></td>
</tr>
<tr>
   <td><b>Кол-во столбцов</b></td>
   <td><input type="text" name='columnCount' value=<?= $setting->columnCount ? : '3';?>></td>
</tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr>
   <td><b>Типы загружаемых картинок</b><br>
   (через запятую)</td>
   <td><input type="text" name='imageTypes' value=<?= $setting->imageTypes ? : 'image/gif,image/jpeg,image/png';?> size="50"></td>
</tr>
<tr><td colspan="2" align="center"><input type="submit" value="Принять изменения"></td></tr>
</form>
</table>