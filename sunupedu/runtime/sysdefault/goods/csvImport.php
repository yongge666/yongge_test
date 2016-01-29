<?php $goods_class = new goods_class();$tb_category = new IModel('category');$category = $goods_class->sortdata($tb_category->query(false,'*','sort','asc'),0,'--');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理后台</title>
<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/skins/default.css" />
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/form/form.js"></script>
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/style.css" />
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/admin.js";?>"></script>
</head>
<body style="width:500px;min-height:470px;">
	<div class="pop_win">
		<ul class="red_box">
			<li>1、默认的CSV文件编码不是UTF-8编码的，必须要先转换编码，利用工具另存为UTF-8格式</li>
			<li>2、导入的商品必须插入到指定的一个或者多个商品分类中</li>
			<li>3、导入的CSV数据包必须是小于 <?php echo IUpload::getMaxSize();?> 的.ZIP压缩包，您可以通过修改php.ini中的 &lt;post_max_size&gt;和&lt;upload_max_filesize&gt;选项来修改上传数据包的大小</li>
			<li>4、数据包里面一级目录必须包括CSV文件和与之对应的CSV图片文件夹，且两者的名字必须相同对应起来且必须是英文。例如：&lt;summer.csv&gt; 和 &lt;summer&gt;</li>
		</ul>
		<form action='<?php echo IUrl::creatUrl("/goods/importCsvFile");?>' method='post' enctype='multipart/form-data' callback='checkForm();'>
			<table class="form_table" width="90%" cellspacing="0" cellpadding="0" border="0">
				<col width="120px" />
				<col />

				<tbody>
					<tr>
						<td>CSV数据类型</td>
						<td>
							<select name='csvType' pattern='required' class='auto'>
								<option value=''>请选择</option>
								<option value='taobao'>淘宝csv数据包</option>
							</select>
							<label>选择要导入的CSV数据格式</label>
						</td>
					</tr>
					<tr>
						<td>添加到商品分类</td>
						<td>
							<?php if($category){?>
							<ul class="select">
								<?php foreach($category as $key => $item){?>
								<li><label><input type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" name="category[]" /><?php echo isset($item['name'])?$item['name']:"";?></label></li>
								<?php }?>
							</ul>
							<?php }else{?>
							系统暂无商品分类，<a href='<?php echo IUrl::creatUrl("/goods/category_edit");?>' class='orange' target='_blank'>请点击添加</a>
							<?php }?>
						</td>
					</tr>
					<tr>
						<td>上传ZIP压缩包</td>
						<td>
							<input type="file" name="csvPacket" class="file" />
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</body>

<script type='text/javascript'>
//检测form表单
function checkForm()
{
	if($('[name="csvPacket"]').val() == '')
	{
		alert('请上传csv数据包');
		return false;
	}
	document.forms[0].submit();
}
</script>
</html>