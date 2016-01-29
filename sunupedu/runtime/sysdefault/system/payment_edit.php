<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>后台管理</title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
	<meta name="robots" content="noindex,nofollow">
	<link rel="shortcut icon" href="favicon.ico" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/admin.js";?>"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/menu.js";?>"></script>
</head>
<body>
	<div class="container">
		<div id="header">
			<div class="logo">
				<a href="<?php echo IUrl::creatUrl("/system/default");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/logo.gif";?>" width="303" height="43" /></a>
			</div>
			<div id="menu">
				<ul name="menu">
				</ul>
			</div>
			<p><a href="<?php echo IUrl::creatUrl("/systemadmin/logout");?>">退出管理</a> <a href="<?php echo IUrl::creatUrl("/system/admin_repwd");?>">修改密码</a> <a href="<?php echo IUrl::creatUrl("/system/default");?>">后台首页</a> <a href="<?php echo IUrl::creatUrl("");?>" target='_blank'>商城首页</a> <span>您好 <label class='bold'><?php echo isset($this->admin['admin_name'])?$this->admin['admin_name']:"";?></label>，当前身份 <label class='bold'><?php echo isset($this->admin['admin_role_name'])?$this->admin['admin_role_name']:"";?></label></span></p>
		</div>
		<div id="info_bar">
			<label class="navindex"><a href="<?php echo IUrl::creatUrl("/system/navigation");?>">快速导航管理</a></label>
			<span class="nav_sec">
			<?php $adminId = $this->admin['admin_id']?>
			<?php $query = new IQuery("quick_naviga");$query->where = "admin_id = $adminId and is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
			<a href="<?php echo isset($item['url'])?$item['url']:"";?>" class="selected"><?php echo isset($item['naviga_name'])?$item['naviga_name']:"";?></a>
			<?php }?>
			</span>
		</div>

		<div id="admin_left">
			<ul class="submenu"></ul>
			<div id="copyright"></div>
		</div>

		<div id="admin_right">
			<?php $paymentInstance = Payment::createPaymentInstance($this->paymentRow['id']);$paramData = JSON::decode($this->paymentRow['config_param'])?>
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/editor/kindeditor-min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/editor/lang/zh_CN.js"></script><script type="text/javascript">window.KindEditor.options.uploadJson = "/index.php?controller=pic&action=upload_json";window.KindEditor.options.fileManagerJson = "/index.php?controller=pic&action=file_manager_json";</script>
<div class="headbar">
	<div class="position"><span>系统</span><span>></span><span>支付管理</span><span>></span><span>支付插件配置</span></div>
</div>

<div class="content_box">
	<div class="content form_content">
		<form action="<?php echo IUrl::creatUrl("/system/payment_update");?>" method="post">
			<input type='hidden' name='id' value='' />
			<table class="form_table" cellpadding="0" cellspacing="0">
				<col width="150px" />
				<col />
				<tr>
					<th>支付方式名称：</th>
					<td>
						<input class="normal" name="name" type="text" value="" pattern="required" alt="支付方式名称不能为空！" />
						<label>*</label>
					</td>
				</tr>

				<?php $configParam = $paymentInstance->configParam()?>
				<?php foreach($configParam as $key => $item){?>
				<tr>
					<th><?php echo isset($item)?$item:"";?>：</th>
					<td><input class="normal" name="<?php echo isset($key)?$key:"";?>" type="text" value="<?php echo isset($paramData[$key])?$paramData[$key]:"";?>" /></td>
				</tr>
				<?php }?>

				<tr>
					<th valign="top">简述：</th>
					<td><?php echo isset($this->paymentRow['description'])?$this->paymentRow['description']:"";?></td>
				</tr>
				<tr>
					<th>手续费设置：</th>
					<td>
						<label class='attr'><input name="poundage_type" type="radio" value="1" onclick="$('#paymentFeeText').text('商品总额的百分比：');" checked="checked" />按商品总额的百分比</label>
						<label class='attr'><input name="poundage_type" type="radio" value="2" onclick="$('#paymentFeeText').text('固定收取的手续费：');" />按固定金额</label>
						<label><span id="paymentFeeText">{说明}</span><input class="small" name="poundage" type="text" value=""  pattern="required" alt="费用不能为空！" /></label>
					</td>
				</tr>
				<tr>
					<th>应用客户端：</th>
					<td>
						<label class='attr'><input name="client_type" type="radio" value="1" checked="checked" />PC电脑</label>
						<label class='attr'><input name="client_type" type="radio" value="2" />MOBILE移动端</label>
						<label class='attr'><input name="client_type" type="radio" value="3" />通用</label>
						<label>在不同的客户端访问时，会显示不同的支付方式</label>
					</td>
				</tr>
				<tr>
					<th>排序：</th><td><input class="small" name="order" type="text" value="" pattern="required" alt="排序不能为空！" /></td>
				</tr>
				<tr>
					<th>支付说明：</th>
					<td>
						<textarea id="note" name="note" style="width:700px;height:280px;visibility:hidden;"><?php echo isset($this->paymentRow['note'])?$this->paymentRow['note']:"";?></textarea>
						<label>此信息会展示在用户的支付页面</label>
					</td>
				</tr>
				<tr>
					<th>开启：</th>
					<td>
						<label class='attr'><input name="status" type="radio" value="0" checked="checked" />开启</label>
						<label class='attr'><input name="status" type="radio" value="1" />关闭</label>
						<label>只有开启后，用户才能从前台进行支付选择</label>
					</td>
				</tr>
				<tr>
					<th></th>
					<td>
						<button class="submit" type='submit'><span>确 定</span></button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script language="javascript">
//DOM加载完毕
$(function(){
	var formInstance = new Form();
	formInstance.init(<?php echo JSON::encode($this->paymentRow);?>);

	//展示支付费用
	$('input[name="poundage_type"]:checked').trigger('click');

	KindEditor.ready(function(K){
		K.create('#note');
	});
});
</script>

		</div>
	</div>

	<script type='text/javascript'>
		//DOM加载完毕执行
		$(function(){
			//隔行换色
			$(".list_table tr:nth-child(even)").addClass('even');
			$(".list_table tr").hover(
				function () {
					$(this).addClass("sel");
				},
				function () {
					$(this).removeClass("sel");
				}
			);

			//后台菜单创建
			<?php $menu = new Menu();?>
			var data = <?php echo $menu->submenu();?>;
			var current = '<?php echo $menu->current;?>';
			var url='<?php echo IUrl::creatUrl("/");?>';
			initMenu(data,current,url);
		});
	</script>
</body>
</html>
