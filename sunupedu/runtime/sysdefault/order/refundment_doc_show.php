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
	<div class="position"><span>订单</span><span>></span><span>单据管理</span><span>></span><span>退款单申请信息</span></div>
</div>

<div class="content">
	<form method="post" action="<?php echo IUrl::creatUrl("/order/refundment_doc_show_save");?>">
		<input type="hidden" name="id" value="<?php echo isset($id)?$id:"";?>"/>
		<table class="border_table" width="100%" style="margin:10px auto">
			<colgroup>
				<col width="200px" />
				<col />
			</colgroup>

			<tbody>
				<tr>
					<th>订单号：</th><td align="left"><?php echo isset($order_no)?$order_no:"";?></td>
				</tr>
				<tr>
					<th>退款商品：</th>
					<td align="left">
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
				<tr>
					<th>用户名：</th><td align="left"><?php $query = new IQuery("user");$query->fields = "username";$query->where = "id = $user_id";$items = $query->find(); foreach($items as $key => $item){?><?php echo isset($item['username'])?$item['username']:"";?><?php }?></td>
				</tr>
				<tr>
					<th>联系方式：</th><td align="left"><?php $query = new IQuery("member");$query->fields = "mobile";$query->where = "user_id = $user_id";$items = $query->find(); foreach($items as $key => $item){?><?php echo isset($item['mobile'])?$item['mobile']:"";?><?php }?></td>
				</tr>
				<tr>
					<th>退款金额：</th><td align="left"><?php echo isset($amount)?$amount:"";?></td>
				</tr>
				<tr>
					<th>申请时间：</th><td align="left"><?php echo isset($time)?$time:"";?></td>
				</tr>
				<tr>
					<th>退款原因：</th><td align="left"><?php echo isset($content)?$content:"";?></td>
				</tr>
				<tr>
					<th>处理：</th>
					<td align="left">
						<label><input type="radio" name="pay_status" value="2" checked='checked' />同意</label>&nbsp;&nbsp;
						<label><input type="radio" name="pay_status" value="1" />拒绝</label>
					</td>
				</tr>
				<tr>
					<th>处理意见：</th>
					<td align="left">
						<textarea name="dispose_idea" class="normal"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2"><button type="submit" class="submit" onclick="return checkForm()"><span>确 定</span></button></td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<script type="text/javascript">
//退款
function refundment(id,refundsId)
{
	var tempUrl = '<?php echo IUrl::creatUrl("/order/order_refundment/id/@id@/refunds_id/@refunds_id@");?>';
	tempUrl     = tempUrl.replace('@id@',id).replace('@refunds_id@',refundsId);;
	art.dialog.open(tempUrl,{
		id:'refundment',
		cancelVal:'关闭',
		okVal:'退款',
	    title: '订单号:<?php echo isset($order_no)?$order_no:"";?>【退款到余额账户】',
	    ok:function(iframeWin, topWin){
	    	iframeWin.document.forms[0].submit();
	    	return false;
	    },
	    cancel:function(){
	    	return true;
		}
	});
}

//执行回调处理
function actionCallback(msg)
{
	if(msg)
	{
		alert(msg);
		return;
	}
	document.forms[0].submit();
}

//表单提交
function checkForm()
{
	var payValue = $('[name="pay_status"]:checked').val();
	if(payValue == 2)
	{
		refundment(<?php echo isset($order_id)?$order_id:"";?>,<?php echo isset($id)?$id:"";?>);
		return false;
	}
	return true;
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
