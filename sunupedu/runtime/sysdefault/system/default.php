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
			<div class="content_box" style="border:none">
	<div class="content">
		<?php $safeInstance = new safeStrategy();$checkResult = $safeInstance->check();?>
		<?php if($checkResult){?>
		<ul class="red_box">
		<?php foreach($checkResult as $key => $item){?>
		<li><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/error.gif";?>" /><?php echo isset($item['content'])?$item['content']:"";?></li>
		<?php }?>
		</ul>
		<?php }?>
		
		

		<table width="32%" cellspacing="0" cellpadding="5" class="border_table_org" style="float:left">
			<thead>
				<tr><th>基础统计</th></tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<table class="list_table2" width="100%">
							<colgroup>
								<col width="80px" />
								<col />
							</colgroup>
							<tbody>
								<tr><th>商家数量</th><td><?php $query = new IQuery("seller");$query->fields = "count(*) as amount";$items = $query->find(); foreach($items as $key => $item){?><a href="<?php echo IUrl::creatUrl("/member/seller_list");?>"><b class="f14 red3"><?php echo isset($item['amount'])?$item['amount']:"";?></b> 家</a><?php }?></td></tr>
								<tr><th>销售总额</th><td><?php $query = new IQuery("order");$query->fields = "sum(order_amount) as amount";$query->where = "`status` = 5";$items = $query->find(); foreach($items as $key => $item){?><a href="<?php echo IUrl::creatUrl("/market/amount");?>"><b class="f14 red3"><?php echo empty($item['amount']) ? 0 : $item['amount'];?></b> 元</a><?php }?></td></tr>
								<tr><th>注册用户</th><td><?php $query = new IQuery("user");$query->fields = "count(id) as countNums";$items = $query->find(); foreach($items as $key => $item){?><a href="<?php echo IUrl::creatUrl("/member/member_list");?>"><b class="f14 red3"><?php echo isset($item['countNums'])?$item['countNums']:"";?></b> 个</a><?php }?></td></tr>
								<tr><th>产品数量</th><td><a href="<?php echo IUrl::creatUrl("/goods/goods_list");?>"><b class="f14 red3"><?php echo statistics::goodsCount();?></b> 个</a></td></tr>
								<tr><th>品牌数量</th><td><?php $query = new IQuery("brand");$query->fields = "count(id) as countNums";$items = $query->find(); foreach($items as $key => $item){?><a href="<?php echo IUrl::creatUrl("/brand/brand_list");?>"><b class="f14 red3"><?php echo isset($item['countNums'])?$item['countNums']:"";?></b> 个</a><?php }?></td></tr>
								<tr><th>订单数量</th><td><?php $query = new IQuery("order");$query->fields = "count(id) as countNums";$query->where = "if_del = 0";$items = $query->find(); foreach($items as $key => $item){?><a href="<?php echo IUrl::creatUrl("/order/order_list");?>"><b class="f14 red3"><?php echo isset($item['countNums'])?$item['countNums']:"";?></b> 个</a><?php }?></td></tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>

		<table width="33%" cellspacing="0" cellpadding="5" class="border_table_org" style="float:left">
			<thead>
				<tr><th>待处理</th></tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<table class="list_table2" width="100%">
							<colgroup>
								<col width="80px" />
								<col />
							</colgroup>

							<tbody>
								<tr><th>待回复评论</th><td><a href="<?php echo IUrl::creatUrl("/comment/comment_list");?>"><b class="red3 f14"><?php echo statistics::commentCount();?></b></a> 个</td></tr>
								<tr><th>待回复建议</th><td><?php $query = new IQuery("suggestion");$query->where = "re_time is null";$query->fields = "count(*) as countNums";$items = $query->find(); foreach($items as $key => $item){?><a href='<?php echo IUrl::creatUrl("/comment/suggestion_list");?>'><b class="red3 f14"><?php echo isset($item['countNums'])?$item['countNums']:"";?></b></a><?php }?> 个</td></tr>
								<tr><th>待回复咨询</th><td><a href="<?php echo IUrl::creatUrl("/comment/refer_list/status/0");?>"><b class="red3 f14"><?php echo statistics::referWaitCount();?></b></a> 个</td></tr>
								<tr><th>未发货订单</th><td><?php $query = new IQuery("order");$query->fields = "count(id) as countNums";$query->where = "distribution_status = 0 and if_del = 0";$items = $query->find(); foreach($items as $key => $item){?><a href="<?php echo IUrl::creatUrl("/order/order_list/distribution_status/0");?>"><b class="f14 red3"><?php echo isset($item['countNums'])?$item['countNums']:"";?></b></a> 个<?php }?></td></tr>
								<tr><th>退款申请</th><td><a href="<?php echo IUrl::creatUrl("/order/refundment_list");?>"><b class="red3 f14"><?php echo statistics::refundsCount();?></b></a> 个</td></tr>
								<tr><th>待审商家</th><td><?php $query = new IQuery("seller");$query->fields = "count(id) as countNums";$query->where = "is_lock = 1";$items = $query->find(); foreach($items as $key => $item){?><a href="<?php echo IUrl::creatUrl("/member/seller_list");?>"><b class="red3 f14"><?php echo isset($item['countNums'])?$item['countNums']:"";?></b></a> 个<?php }?></td></tr>
								<tr><th>待审商品</th><td><?php $query = new IQuery("goods");$query->fields = "count(id) as countNums";$query->where = "is_del = 3";$items = $query->find(); foreach($items as $key => $item){?><a href="<?php echo IUrl::creatUrl("/goods/goods_list/search['is_del']/3");?>"><b class="red3 f14"><?php echo isset($item['countNums'])?$item['countNums']:"";?></b></a> 个<?php }?></td></tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>

		<table width="98%" cellspacing="0" cellpadding="0" class="border_table_org" style="float:left">
			<thead>
				<tr><th>最新10条订单</th></tr>
			</thead>
			<tbody>
				<tr>
					<td style="padding:5px 0">
						<table class="list_table3" width="100%">
							<thead>
								<th>订单号</th>
								<th>收货人</th>
								<th>支付状态</th>
								<th>金额</th>
								<th>下单时间</th>
								<th>操作</th>
							</thead>
							<tbody>
							<?php $query = new IQuery("order as o");$query->join = "left join delivery as d on o.distribution = d.id left join payment as p on o.pay_type = p.id left join user as u on u.id = o.user_id";$query->fields = "o.id as oid,d.name as dname,p.name as pname,o.order_no,o.accept_name,o.pay_status,o.distribution_status,u.username,o.create_time,o.status,o.order_amount";$query->where = "o.status < 3 and if_del = 0";$query->order = "o.id desc";$query->limit = "10";$items = $query->find(); foreach($items as $key => $item){?>
							<tr>
								<td><?php echo isset($item['order_no'])?$item['order_no']:"";?></td>
								<td><b><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></b></td>
								<td><?php if($item['pay_status']==0){?>未付款<?php }elseif($item['pay_status']==1){?><b>已付款</b><?php }elseif($item['pay_status']==2){?>退款完成<?php }else{?><span class="red"><b>申请退款</b></span><?php }?></td>
								<td><b class="red3">￥<?php echo isset($item['order_amount'])?$item['order_amount']:"";?></b></td>
								<td><?php echo isset($item['create_time'])?$item['create_time']:"";?></td>
								<td>
									<a href="<?php echo IUrl::creatUrl("/order/order_show/id/".$item['oid']."");?>"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_check.gif";?>" title="查看" /></a>
									<?php if($item['status']<3){?>
									<a href="<?php echo IUrl::creatUrl("/order/order_edit/id/".$item['oid']."");?>"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_edit.gif";?>" title="编辑"/></a>
									<?php }?>
									<a href="javascript:void(0)" onclick="delModel({link:'<?php echo IUrl::creatUrl("/order/order_del/id/".$item['oid']."");?>'})" ><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" title="删除"/></a>
								</td>
							</tr>
							<?php }?>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
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
