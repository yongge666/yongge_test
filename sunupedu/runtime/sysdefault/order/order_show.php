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
			<?php $orderStatus = Order_class::getOrderStatus(array('status' => $status,'pay_type' => $pay_type,'distribution_status' => $distribution_status))?>

<div class="headbar clearfix">
	<div class="position">订单<span>></span><span>订单管理</span><span>></span><span>订单查看</span></div>
	<ul class="tab" name="menu1">
		<li id="li_1"><a href="javascript:selectTab('1');" hidefocus="true">基本信息</a></li>
		<li id="li_2"><a href="javascript:selectTab('2');" hidefocus="true">收退款记录</a></li>
		<li id="li_3"><a href="javascript:selectTab('3');" hidefocus="true">发货记录</a></li>
		<li id="li_4"><a href="javascript:selectTab('4');" hidefocus="true">优惠方案</a></li>
		<li id="li_5"><a href="javascript:selectTab('5');" hidefocus="true">订单备注</a></li>
		<li id="li_6"><a href="javascript:selectTab('6');" hidefocus="true">订单日志</a></li>
		<li id="li_7"><a href="javascript:selectTab('7');" hidefocus="true">订单附言</a></li>
	</ul>
</div>

<div id="tab-1" name="table" style="display:none">
	<div class="content">
		<table class="list_table">
			<col width="500px" />
			<col width="100px" />
			<col width="100px" />
			<col width="100px" />
			<col />
			<thead>
				<tr>
					<th>商品名称</th>
					<th>商品原价</th>
					<th>实际价格</th>
					<th>商品数量</th>
					<th>小计</th>
					<th>配送方式</th>
				</tr>
			</thead>
			<tbody>
				<?php $query = new IQuery("order_goods");$query->where = "order_id = $order_id";$items = $query->find(); foreach($items as $key => $item){?>
				<tr>
					<td>
						<?php $goodsRow = JSON::decode($item['goods_array'])?>
						<?php echo isset($goodsRow['name'])?$goodsRow['name']:"";?> &nbsp;&nbsp; <?php echo isset($goodsRow['value'])?$goodsRow['value']:"";?>
					</td>
					<td><?php echo isset($item['goods_price'])?$item['goods_price']:"";?></td>
					<td><?php echo isset($item['real_price'])?$item['real_price']:"";?></td>
					<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
					<td><?php echo $item['real_price']*$item['goods_nums'];?></td>
					<td>
						<?php echo Order_Class::goodsSendStatus($item['is_send']);?>

						<?php if($item['delivery_id']){?>
						<button class="btn" onclick="freightLine(<?php echo isset($item['delivery_id'])?$item['delivery_id']:"";?>)">快递跟踪</button>
						<?php }?>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>

		<table style="width:300px;margin-right:20px;" class="border_table f_l">
			<col width="80px" />
			<col />
			<thead>
				<tr><th colspan="2">订单金额明细</th></tr>
			</thead>
			<tbody>
				<tr>
					<th>商品总额:</th><td>￥<?php echo isset($payable_amount)?$payable_amount:"";?></td>
				</tr>
				<tr>
					<th>配送费用:</th><td>￥<?php echo isset($payable_freight)?$payable_freight:"";?></td>
				</tr>
				<tr>
					<th>保价费用:</th><td>￥<?php echo isset($insured)?$insured:"";?></td>
				</tr>
				<tr>
					<th>税金:</th><td>￥<?php echo isset($taxes)?$taxes:"";?></td>
				</tr>
				<tr>
					<th>优惠总额:</th><td>￥<?php echo isset($promotions)?$promotions:"";?></td>
				</tr>
				<tr>
					<th>增加或减少金额:</th><td>￥<?php echo isset($discount)?$discount:"";?></td>
				</tr>
				<tr>
					<th>订单总额:</th><td>￥<?php echo isset($order_amount)?$order_amount:"";?></td>
				</tr>
				<tr>
					<th>已支付金额:</th><td><?php $query = new IQuery("collection_doc");$query->where = "order_id = $order_id and if_del = 0";$query->fields = "amount";$items = $query->find(); foreach($items as $key => $item){?>￥<?php echo isset($item['amount'])?$item['amount']:"";?><?php }?></td>
				</tr>
			</tbody>
		</table>

		<table style="width:300px;margin-right:20px;" class="border_table f_l">
			<col width="80px" />
			<col />
			<thead>
				<tr><th colspan="2">收货人信息</th></tr>
			</thead>
			<tbody>
				<?php foreach($address_list as $key => $item){?>
					<tr>
						<th>姓名:</th><td><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td>
					</tr>
					<tr>
						<th>电话:</th><td><?php echo isset($item['telphone'])?$item['telphone']:"";?></td>
					</tr>
					<tr>
						<th>手机 :</th><td><?php echo isset($item['mobile'])?$item['mobile']:"";?></td>
					</tr>
					<tr>
						<th>地址:</th><td><?php echo isset($item['province_val'])?$item['province_val']:"";?><?php echo isset($item['city_val'])?$item['city_val']:"";?><?php echo isset($item['area_val'])?$item['area_val']:"";?><?php echo isset($item['address'])?$item['address']:"";?></td>
					</tr>
					<tr>
						<th>邮编:</th><td><?php echo isset($item['zip'])?$item['zip']:"";?></td>
					</tr>
					<tr>
						<th>----------------</th><td>-------------------------------------------</td>
					</tr>
				<?php }?>
			</tbody>
		</table>

		<table style="width:300px;margin-right:20px;" class="border_table f_l">
			<col width="80px" />
			<col />
			<thead>
				<tr><th colspan="2">配送支付信息</th></tr>
			</thead>
			<tbody>
				<tr>
					<th>发货日期:</th><td><?php echo isset($send_time)?$send_time:"";?></td>
				</tr>
				<tr>
					<th>配送方式:</th><td><?php echo isset($delivery)?$delivery:"";?></td>
				</tr>
				
				<tr>
					<th>送货时间:</th><td><?php echo isset($accept_time)?$accept_time:"";?></td>
				</tr>
				
				<?php if($takeself){?>
				<tr>
					<th>自提地址:</th>
					<td>
						<?php echo isset($takeself['province_str'])?$takeself['province_str']:"";?>
						<?php echo isset($takeself['city_str'])?$takeself['city_str']:"";?>
						<?php echo isset($takeself['area_str'])?$takeself['area_str']:"";?>
						<?php echo isset($takeself['address'])?$takeself['address']:"";?>
					</td>
				</tr>
				<tr>
					<th>自提联系方式:</th>
					<td>
						座机：<?php echo isset($takeself['phone'])?$takeself['phone']:"";?> &nbsp;&nbsp;
						手机：<?php echo isset($takeself['mobile'])?$takeself['mobile']:"";?>
					</td>
				</tr>
				<tr>
					<th>自提验证码:</th>
					<td class="green"><?php echo isset($checkcode)?$checkcode:"";?></td>
				</tr>
				<?php }?>

				<tr>
					<th>配送保价:</th><td><?php if($if_insured==0){?>不保价<?php }else{?>保价<?php }?></td>
				</tr>
				<tr>
					<th>商品重量:</th><td><?php echo isset($goods_weight)?$goods_weight:"";?></td>
				</tr>
				<tr>
					<th>支付方式:</th><td><?php echo isset($payment)?$payment:"";?></td>
				</tr>
				<tr>
					<th>是否开票:</th><td><?php if($invoice==0){?>否<?php }else{?>是<?php }?></td>
				</tr>
				<tr>
					<th>发票抬头:</th><td><?php echo isset($invoice_title)?$invoice_title:"";?></td>
				</tr>
				<tr>
					<th>可得积分:</th><td><?php echo isset($point)?$point:"";?></td>
				</tr>
			</tbody>
		</table>

		<table style="width:300px;margin-right:20px;" class="border_table f_l">
			<col width="80px" />
			<col />
			<thead>
				<tr><th colspan="2">买家信息</th></tr>
			</thead>
			<tbody>
				<tr>
					<th>用户名:</th><td><?php echo isset($username)?$username:"";?></td>
				</tr>
				<tr>
					<th>姓名:</th><td><?php echo isset($true_name)?$true_name:"";?></td>
				</tr>
				<tr>
					<th>电话:</th><td><?php echo isset($u_mobile)?$u_mobile:"";?></td>
				</tr>
				<tr>
					<th>地区:</th><td><?php echo isset($contact_addr)?$contact_addr:"";?></td>
				</tr>
				<tr>
					<th>Email:</th><td><?php echo isset($email)?$email:"";?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div id="tab-2" name="table" style="display:none">
	<div class="content">
		<table style="width:45%;margin-right:20px;" class="border_table f_l">
			<colgroup>
				<col width="120px" />
				<col />
			</colgroup>

			<thead>
				<tr><th colspan="2">收款单据</th></tr>
			</thead>
			<tbody>
				<?php $query = new IQuery("collection_doc as c");$query->join = "left join payment as p on c.payment_id = p.id";$query->where = "c.order_id = $order_id";$query->fields = "c.*,p.name";$collectionData = $query->find(); foreach($collectionData as $key => $item){?><?php }?>
				<?php if($collectionData){?>
				<tr>
					<th>时间：</th><td><?php echo isset($item['time'])?$item['time']:"";?></td>
				</tr>
				<tr>
					<th>金额：</th><td><?php echo isset($item['amount'])?$item['amount']:"";?></td>
				</tr>
				<tr>
					<th>支付方式：</th><td><?php echo isset($item['name'])?$item['name']:"";?></td>
				</tr>
				<tr>
					<th>付款备注：</th><td><?php echo isset($item['note'])?$item['note']:"";?></td>
				</tr>
				<tr>
					<th>状态：</th><td><?php if($item['pay_status']==0){?>准备中<?php }else{?>支付完成<?php }?></td>
				</tr>
				<?php }else{?>
				<tr><td colspan='2'>暂无数据</td></tr>
				<?php }?>
			</tbody>
		</table>

		<table style="width:45%;margin-right:20px;" class="border_table f_l">
			<colgroup>
				<col width="120px" />
				<col />
			</colgroup>

			<thead>
				<tr><th colspan="2">退款单据列表</th></tr>
			</thead>
			<tbody>
				<?php $query = new IQuery("refundment_doc");$query->where = "order_id = $order_id";$refundmentData = $query->find(); foreach($refundmentData as $key => $item){?>
				<tr>
					<th>退款商品：</th>
					<td>
						<?php $query = new IQuery("order_goods");$query->where = "order_id = $order_id and goods_id = $item[goods_id] and product_id = $item[product_id]";$items = $query->find(); foreach($items as $key => $good){?>
						<?php $goods = JSON::decode($good['goods_array'])?>
						<a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['goods_id']."");?>" target="_blank" title="<?php echo isset($goods['name'])?$goods['name']:"";?>"><?php echo IString::substr($goods['name'],25);?> X <?php echo isset($good['goods_nums'])?$good['goods_nums']:"";?>件</a>
						<?php }?>
						<?php if($item['seller_id']){?>
						<a href="<?php echo IUrl::creatUrl("/site/home/id/".$item['seller_id']."");?>" target="_blank"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/seller_ico.png";?>" /></a>
						<?php }?>
					</td>
				</tr>
				<tr>
					<th>退款金额：</th><td><?php echo isset($item['amount'])?$item['amount']:"";?></td>
				</tr>
				<tr>
					<th>申请时间：</th><td><?php echo isset($item['time'])?$item['time']:"";?></td>
				</tr>
				<tr>
					<th>状态：</th><td><?php echo Order_Class::refundmentText($item['pay_status']);?></td>
				</tr>
				<tr>
					<th>退款理由：</th><td><?php echo isset($item['content'])?$item['content']:"";?></td>
				</tr>
				<tr><th colspan="2"></th></tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>

<div id="tab-3" name="table" style="display:none">
	<div class="content">
		<table style="width:98%" class="border_table">
			<colgroup>
				<col width="150px" />
				<col width="150px" />
				<col width="200px" />
				<col width="200px" />
				<col />
			</colgroup>

			<thead>
				<tr>
					<th>配送时间</th>
					<th>配送方式</th>
					<th>物流单号</th>
					<th>收件人</th>
					<th>备注</th>
				</tr>
			</thead>

			<tbody>
				<?php $query = new IQuery("delivery_doc as c");$query->join = "left join delivery as p on c.delivery_type = p.id";$query->fields = "c.*,p.name as pname";$query->where = "c.order_id = $order_id";$deliveryData = $query->find(); foreach($deliveryData as $key => $item){?>
				<tr>
					<td><?php echo isset($item['time'])?$item['time']:"";?></td>
					<td><?php echo isset($item['pname'])?$item['pname']:"";?></td>
					<td><?php echo isset($item['delivery_code'])?$item['delivery_code']:"";?></td>
					<td><?php echo isset($item['name'])?$item['name']:"";?></td>
					<td><?php echo isset($item['note'])?$item['note']:"";?></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>

<div id="tab-4" name="table" style="display:none">
	<div class="content">
		<table width="98%" class="border_table">
			<col width="250px" />
			<col />
			<thead>
				<tr>
					<th>方案</th>
					<th>优惠内容</th>
				</tr>
			</thead>
			<tbody>
			<?php if($this->result){?>
			<?php foreach($this->result as $key => $item){?>
			<tr>
				<td><?php echo isset($item['plan'])?$item['plan']:"";?></td>
				<td><?php echo isset($item['info'])?$item['info']:"";?></td>
			</tr>
			<?php }?>
			<?php }else{?>
			<tr><td colspan='2'>暂无数据</td></tr>
			<?php }?>
			</tbody>
		</table>
	</div>
</div>

<div id="tab-5" name="table" style="display:none">
	<div class="content">
		<div class="content form_content">
		<form name="ModelForm" action="<?php echo IUrl::creatUrl("/order/order_note");?>" method="post">
			<input type="hidden" name="order_id" value="<?php echo isset($order_id)?$order_id:"";?>"/>
			<input type="hidden" name="tab" value="6"/>
			<table class="form_table">
				<col width="150px" />
				<col />
				<tbody>
					<tr>
						<th>订单备注:</th>
						<td align="left"><textarea name="note" id="note" rows="8" cols="100"><?php echo isset($note)?$note:"";?></textarea></td>
					</tr>
					<tr>
						<td></td>
						<td align="left"><button type="submit" class="submit"><span>保存</span></button></td>
					</tr>
				</tbody>
			</table>
		</form>
		</div>
	</div>
</div>

<div id="tab-6" name="table" style="display:none">
	<div class="content">
		<table class="border_table" style='width:98%'>
			<colgroup>
			<col width="200px">
			<col width="150px">
			<col width="150px">
			<col width="100px">
			<col />
			</colgroup>
			<thead>
				<tr>
					<th>时间</th>
					<th>操作人</th>
					<th>动作</th>
					<th>结果</th>
					<th>备注</th>
				</tr>
			</thead>
			<tbody>
				<?php $query = new IQuery("order_log as ol");$query->where = "ol.order_id = $order_id";$items = $query->find(); foreach($items as $key => $item){?>
				<tr>
					<td><?php echo isset($item['addtime'])?$item['addtime']:"";?></td>
					<td><?php echo isset($item['user'])?$item['user']:"";?></td>
					<td><?php echo isset($item['action'])?$item['action']:"";?></td>
					<td><?php echo isset($item['result'])?$item['result']:"";?></td>
					<td><?php echo isset($item['note'])?$item['note']:"";?></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>

<div id="tab-7" name="table" style="display:none">
	<div class="content">
		<div class="content form_content">
			<table class="form_table">
				<col width="150px" />
				<col />
				<tbody>
					<tr>
						<th>订单附言:</th>
						<td align="left"><?php echo isset($postscript)?$postscript:"";?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="pages_bar">
	<div class="t_c" id="ctrlButtonArea">
		<button type="button" class="submit" id="to_pay" onclick="pay(<?php echo isset($order_id)?$order_id:"";?>);"><span>支付</span></button>
		<button type="button" class="submit" id="to_deliver" onclick="deliver(<?php echo isset($order_id)?$order_id:"";?>);"><span>发货</span></button>
		<button type="button" class="submit" id="to_refundment" onclick="refundment(<?php echo isset($order_id)?$order_id:"";?>);"><span>退款</span></button>
		<button type="button" class="submit" id="to_finish" onclick="complete(<?php echo isset($order_id)?$order_id:"";?>,5)"><span>完成</span></button>
		<button type="button" class="submit" id="to_cancel" onclick="complete(<?php echo isset($order_id)?$order_id:"";?>,4)"><span>作废</span></button>
	</div>
</div>

<script type='text/javascript'>
//DOM加载完毕后运行
$(function()
{
	selectTab(1);
	initButton();
});

/**
 * 订单操作按钮初始化
 */
function initButton()
{
	//全部操作区域的按钮锁定
	$('#ctrlButtonArea button').attr('disabled','disabled');
	$('#ctrlButtonArea button').addClass('inactive');

	//作废
	$('#to_cancel').removeAttr('disabled');
	$('#to_cancel').removeClass('inactive');

	//完成
	<?php if(in_array($orderStatus,array(11,3))){?>
	$('#to_finish').removeAttr('disabled');
	$('#to_finish').removeClass('inactive');
	<?php }?>

	//付款
	<?php if(in_array($orderStatus,array(11,2))){?>
	$('#to_pay').removeAttr('disabled');
	$('#to_pay').removeClass('inactive');
	<?php }?>

	//发货
	<?php if(in_array($orderStatus,array(1,4,8,9))){?>
	$('#to_deliver').removeAttr('disabled');
	$('#to_deliver').removeClass('inactive');
	<?php }?>

	//退款
	<?php if(in_array($orderStatus,array(4,6,9,10))){?>
	$('#to_refundment').removeAttr('disabled');
	$('#to_refundment').removeClass('inactive');
	<?php }?>
}

//选择当前Tab
function selectTab(curr_tab)
{
	$("div[name='table']").hide();
	$("#tab-"+curr_tab).show();
	$("ul[name=menu1] > li").removeClass('selected');
	$('#li_'+curr_tab).addClass('selected');
}

//完成或作废订单
function complete(id,statusVal)
{
	$.get("<?php echo IUrl::creatUrl("/order/order_complete");?>",{'order_no':"<?php echo isset($order_no)?$order_no:"";?>",'type':statusVal,'id':id}, function(data)
	{
		if(data=='success')
		{
			actionCallback();
		}
		else
		{
			alert('发生错误');
		}
	});
}

//退款
function refundment(id)
{
	var tempUrl = '<?php echo IUrl::creatUrl("/order/order_refundment/id/@id@");?>';
	tempUrl     = tempUrl.replace('@id@',id);
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

//付款
function pay(id)
{
	var tempUrl = '<?php echo IUrl::creatUrl("/order/order_collection/id/@id@");?>';
	tempUrl     = tempUrl.replace('@id@',id);

	art.dialog.open(tempUrl,{
		id:'pay',
	    title: '订单号:<?php echo isset($order_no)?$order_no:"";?>【付款】',
	    cancelVal:'关闭',
		okVal:'付款',
	    ok:function(iframeWin, topWin){
			iframeWin.document.forms[0].submit();
			return false;
	    },
	    cancel:function (){
	    	return true;
		}
	});
}

//发货
function deliver(id)
{
	var tempUrl = '<?php echo IUrl::creatUrl("/order/order_deliver/id/@id@");?>';
	tempUrl     = tempUrl.replace('@id@',id);

	var deliv = art.dialog.open(tempUrl,{
		id:'deliver',
	    title: '订单号:<?php echo isset($order_no)?$order_no:"";?>【发货】',
	    cancelVal:'关闭',
		okVal:'发货',
	    ok:function(iframeWin, topWin){
	    	var checkedNums = $(iframeWin.document).find('[name="sendgoods[]"]:checked').length;
	    	if(checkedNums == 0)
	    	{
	    		alert('请选择要发货的商品');
	    		return false;
	    	}
	    	iframeWin.document.forms[0].submit();
	    	return false;
	    },
	    cancel:function (){
	    	return true;
		}
	});
}

//执行回调处理
function actionCallback(msg)
{
	msg ? alert(msg) : window.location.reload();
}

//操作失败回调
function actionFailCallback(msg)
{
	var alertText = msg ? msg : '操作失败';
	alert(alertText);
}

//快递跟踪
function freightLine(doc_id)
{
	var urlVal = "<?php echo IUrl::creatUrl("/block/freight/id/@id@");?>";
	urlVal = urlVal.replace("@id@",doc_id);
	art.dialog.open(urlVal,{title:'轨迹查询'});
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
