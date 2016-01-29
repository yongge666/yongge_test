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
			<div class="headbar">
	<div class="position">订单<span>></span><span>订单管理</span><span>></span><span>订单列表</span></div>
	<div class="operating">
		<a href="javascript:void(0);"><button class="operating_btn" type="button" onclick="window.location='<?php echo IUrl::creatUrl("/order/order_edit");?>'"><span class="addition">添加订单</span></button></a>
		<a href="javascript:void(0);" onclick="selectAll('id[]')"><button class="operating_btn" type="button"><span class="sel_all">全选</span></button></a>
		<a href="javascript:void(0);" onclick="delModel({form:'orderForm'})"><button class="operating_btn" type="button"><span class="delete">批量删除</span></button></a>
		<a href="javascript:void(0);" onclick="$('#orderForm').attr('action','<?php echo IUrl::creatUrl("/order/expresswaybill_template");?>');$('#orderForm').submit();"><button class="operating_btn"><span class="export">批量打印快递单</span></button></a>
		<a href="javascript:void(0);"><button class="operating_btn" onclick="location.href='<?php echo IUrl::creatUrl("/order/print_template");?>'"><span class="export">单据模板</span></button></a>
		<a href="javascript:void(0);"><button class="operating_btn" type="button" onclick="location.href='<?php echo IUrl::creatUrl("/order/order_recycle_list");?>'"><span class="recycle">回收站</span></button></a>
	</div>
	<div class="searchbar">
		<form action="<?php echo IUrl::creatUrl("/");?>" method="get" name="order_list">
			<input type='hidden' name='controller' value='order' />
			<input type='hidden' name='action' value='order_list' />

			<select name="search[pay_status]" class="auto">
				<option value="">选择支付状态</option>
				<option value="0">未支付</option>
				<option value="1">已支付</option>
			</select>

			<select name="search[distribution_status]" class="auto">
				<option value="">选择发货状态</option>
				<option value="0">未发货</option>
				<option value="1">已发货</option>
				<option value="2">部分发货</option>
			</select>

			<select name="search[status]" class="auto">
				<option value="">选择订单状态</option>
				<option value="1">新订单</option>
				<option value="2">确认订单</option>
				<option value="3">取消订单</option>
				<option value="4">作废订单</option>
				<option value="5">完成订单</option>
				<option value="6">退款</option>
				<option value="7">部分退款</option>
			</select>

			<select class="auto" name="search[name]">
				<option value="">选择订单条件</option>
				<option value="accept_name">收件人姓名</option>
				<option value="order_no">订单号</option>
				<option value="seller_name">商户真实名称</option>
			</select>
			<input class="small" name="search[keywords]" type="text" value="" />
			<button class="btn" type="submit"  onclick='changeAction(false)'><span class="sel">筛 选</span></button>
			<button class="btn" onclick='changeAction(true)'><span class="sel">导出Excel</span></button>
		</form>
	</div>
	<div class="field">
		<table class="list_table">
			<col width="30px" />
			<col width="160px" />
			<col width="80px" />
			<col width="80px" />
			<col width="80px" />
			<col width="80px" />
			<col width="115px" />
			<col width="80px" />
			<col />
			<thead>
				<tr>
					<th class="t_c">选择</th>
					<th>订单号</th>
					<th>收货人</th>
					<th>支付状态</th>
					<th>发货状态</th>
					<th>配送方式</th>
					<th>打印</th>
					<th>支付方式</th>
					<th>用户名</th>
					<th>下单时间</th>
					<th>操作</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<form name="orderForm" id="orderForm" action="<?php echo IUrl::creatUrl("/order/order_del");?>" method="post">
	<div class="content">
		<table class="list_table">
			<col width="30px" />
			<col width="160px" />
			<col width="80px" />
			<col width="80px" />
			<col width="80px" />
			<col width="80px" />
			<col width="115px" />
			<col width="80px" />
			<col />
			<tbody>
				<?php foreach($this->orderHandle->find() as $key => $item){?>
				<tr>
					<td class="t_c"><input name="id[]" type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" /></td>
					<td title="<?php echo isset($item['order_no'])?$item['order_no']:"";?>"><?php echo isset($item['order_no'])?$item['order_no']:"";?></td>
					<td title="<?php echo isset($item['accept_name'])?$item['accept_name']:"";?>"><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td>
					<td><span name="payStatusColor<?php echo isset($item['pay_status'])?$item['pay_status']:"";?>"><?php echo Order_Class::getOrderPayStatusText($item);?></span></td>
					<td><span name="disStatusColor<?php echo isset($item['distribution_status'])?$item['distribution_status']:"";?>"><?php echo Order_Class::getOrderDistributionStatusText($item);?></span></td>
					<td title="<?php echo isset($item['distribute_name'])?$item['distribute_name']:"";?>"><?php echo isset($item['distribute_name'])?$item['distribute_name']:"";?></td>
					<td>
						<span class="prt" title="购物清单打印" onclick="window.open('<?php echo IUrl::creatUrl("/order/shop_template/id/".$item['id']."");?>');">购</span>
						<span class="prt" title="配货单打印" onclick="window.open('<?php echo IUrl::creatUrl("/order/pick_template/id/".$item['id']."");?>');">配</span>
						<span class="prt" title="联合打印" onclick="window.open('<?php echo IUrl::creatUrl("/order/merge_template/id/".$item['id']."");?>');">合</span>
						<span class="prt" title="快递单打印" onclick="window.open('<?php echo IUrl::creatUrl("/order/expresswaybill_template/id/".$item['id']."");?>');">递</span>
					</td>
					<td><?php echo isset($item['payment_name'])?$item['payment_name']:"";?></td>
					<td><?php echo $item['username']=='' ? '游客' : $item['username'];?></td>
					<td title="<?php echo isset($item['create_time'])?$item['create_time']:"";?>"><?php echo isset($item['create_time'])?$item['create_time']:"";?></td>
					<td>
						<a href="<?php echo IUrl::creatUrl("/order/order_show/id/".$item['id']."");?>"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_check.gif";?>" title="查看" /></a>
						<?php if(Order_class::getOrderStatus($item) < 3){?>
						<a href="<?php echo IUrl::creatUrl("/order/order_edit/id/".$item['id']."");?>"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_edit.gif";?>" title="编辑"/></a>
						<?php }?>
						<a href="javascript:void(0)" onclick="delModel({link:'<?php echo IUrl::creatUrl("/order/order_del/id/".$item['id']."");?>'})" ><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" title="删除"/></a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
	<?php echo $this->orderHandle->getPageBar();?>
</form>

<script type='text/javascript'>
//DOM加载结束
$(function(){
	<?php if($this->search){?>
	var searchData = <?php echo JSON::encode($this->search);?>;
	for(var index in searchData)
	{
		$('[name="search['+index+']"]').val(searchData[index]);
	}
	<?php }?>

	//高亮色彩
	$('[name="payStatusColor1"]').addClass('green');
	$('[name="disStatusColor1"]').addClass('green');
});
function changeAction(excel)
{
	if (excel){
		$("input[name=\"action\"]").val("order_report");
		$("form[name=\"order_list\"]").attr("target", "_blank");
	}else{
		$("input[name=\"action\"]").val("order_list");
		$("form[name=\"order_list\"]").attr("target", "_self");
	}
}
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
