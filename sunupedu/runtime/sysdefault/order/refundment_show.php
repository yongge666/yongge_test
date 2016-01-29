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
			<div class="headbar clearfix">
	<div class="position">订单<span>></span><span>单据管理</span><span>></span><span>退款单信息</span></div>
</div>

<div class="content">
	<table width="100%" class="border_table" style="margin:10px auto">
		<col width="200px" />
		<col />
		<tbody>
			<tr class='t_l'>
				<th>订单号:</th><td><?php echo isset($order_no)?$order_no:"";?></td>
			</tr>
			<tr class='t_l'>
				<th>订单时间:</th><td><?php echo isset($create_time)?$create_time:"";?></td>
			</tr>
			<tr class='t_l'>
				<th>操作员:</th><td><?php $query = new IQuery("admin");$query->where = "id = $admin_id";$query->fields = "admin_name";$items = $query->find(); foreach($items as $key => $item){?><?php echo isset($item['admin_name'])?$item['admin_name']:"";?><?php }?></td>
			</tr>
			<tr class='t_l'>
				<th>用户名:</th><td><?php echo isset($username)?$username:"";?></td>
			</tr>
			<tr class='t_l'>
				<th>退款金额:</th><td><?php echo isset($amount)?$amount:"";?></td>
			</tr>
			<tr class='t_l'>
				<th>退款商品:</th>
				<td>
					<?php $query = new IQuery("order_goods");$query->where = "order_id = $order_id and goods_id = $goods_id and product_id = $product_id";$items = $query->find(); foreach($items as $key => $item){?>
					<?php $goods = JSON::decode($item['goods_array'])?>
					<?php echo isset($goods['name'])?$goods['name']:"";?> X <?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?>件
					【<?php echo Order_Class::goodsSendStatus($item['is_send']);?>】
					<?php }?>
					<?php if($seller_id){?>
					<a href="<?php echo IUrl::creatUrl("/site/home/id/".$seller_id."");?>" target="_blank"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/seller_ico.png";?>" /></a>
					<?php }?>
				</td>
			</tr>
			<tr class='t_l'>
				<th>处理状态</th>
				<td><?php echo Order_Class::refundmentText($pay_status);?></td>
			</tr>
			<tr class='t_l'>
				<th>处理时间:</th><td><?php echo isset($dispose_time)?$dispose_time:"";?></td>
			</tr>
			<tr class='t_l'>
				<th>退款原因:</th><td><?php echo isset($content)?$content:"";?></td>
			</tr>
			<tr class='t_l'>
				<th>处理意见:</th><td><?php echo isset($dispose_idea)?$dispose_idea:"";?></td>
			</tr>
		</tbody>
	</table>
</div>
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
