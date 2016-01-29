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

<body style="width:700px;height:450px;">
	<div class="pop_win">
		<ul class="red_box">
			<li>1、要采集的URL必须符合一定的规范，<a href="http://www.aircheng.com/notice-box/71-collect" target="_blank" class="blue">采集帮助说明</a></li>
			<li>2、在线商品数据采集，由于包括图片的下载，所以对网速要求比较高，需要耐心等待</li>
		</ul>

		<form action='<?php echo IUrl::creatUrl("/goods/collect_goods");?>' method='post'>
			<table class="form_table" width="90%" cellspacing="0" cellpadding="0" border="0">
				<colgroup>
					<col width="130px" />
					<col />
				</colgroup>

				<tbody>
					<tr>
						<td>添加到商品分类：</td>
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
						<td>URL类型：</td>
						<td>
							<label class='attr'><input type="radio" value="1" name="urlType" checked="checked" onchange="$('#collectNum').toggle();" />商品详情页面</label>
							<label class='attr'><input type="radio" value="2" name="urlType" onchange="$('#collectNum').toggle();" />商品列表页面</label>
							<label>选择所填写URL的类型，商品详情页面或者商品列表页面</label>
						</td>
					</tr>
					<tr>
						<td>采集URL地址：</td>
						<td>
							<input type='text' name='url[]' class='normal' pattern='url' value='' />
							<input type='text' name='url[]' class='normal' pattern='url' value='' />
							<input type='text' name='url[]' class='normal' pattern='url' value='' />
							<input type='text' name='url[]' class='normal' pattern='url' value='' />
							<input type='text' name='url[]' class='normal' pattern='url' value='' />
							<input type='text' name='url[]' class='normal' pattern='url' value='' />
						</td>
					</tr>
					<tr id="collectNum" style="display:none">
						<td>开始与截止位置：</td>
						<td>
							<input type='text' name='start' class='tiny' pattern='int' value='1' />
							--
							<input type='text' name='end' class='tiny' pattern='int' value='5' />
							<label>列表页面要采集的商品位置，如设置1-5则采集列表页面中的第1个到第5个商品</label>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
</body>
</html>