<?php $seller_id = $this->seller['seller_id'];$seller_name = $this->seller['seller_name'];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>商家管理后台</title>
	<link type="image/x-icon" href="favicon.ico" rel="icon">
	<script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/sunupedu/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/sunupedu/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/ie.css";?>" type="text/css" media="screen" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" type="text/css" media="screen" />
</head>

<body>
	<!--头部 开始-->
	<header id="header">
		<hgroup>
			<h1 class="site_title"><a href="<?php echo IUrl::creatUrl("/seller/index");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/main/logo.png";?>" /></a></h1>
			<h2 class="section_title"></h2>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("");?>" target="_blank">网站首页</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/site/home/id/".$seller_id."");?>" target="_blank">店铺首页</a></div>
			<div class="btn_view_site"><a href="<?php echo IUrl::creatUrl("/systemseller/logout");?>" target="_blank">退出登录</a></div>
		</hgroup>
	</header>
	<!--头部 结束-->

	<!--面包屑导航 开始-->
	<section id="secondary_bar">
		<div class="user">
			<p><?php echo isset($seller_name)?$seller_name:"";?></p>
		</div>
	</section>
	<!--面包屑导航 结束-->

	<!--侧边栏菜单 开始-->
	<aside id="sidebar" class="column">
		<h3>统计结算模块</h3>
		<ul class="toggle">
			<li class="icn_tags"><a href="<?php echo IUrl::creatUrl("/seller/index");?>">管理首页</a></li>
			<li class="icn_settings"><a href="<?php echo IUrl::creatUrl("/seller/account");?>">销售额统计</a></li>
			<li class="icn_categories"><a href="<?php echo IUrl::creatUrl("/seller/order_goods_list");?>">货款明细列表</a></li>
			<li  style="display: none;" class="icn_photo"><a href="<?php echo IUrl::creatUrl("/seller/bill_list");?>">货款结算申请</a></li>
		</ul>

		<h3>商品模块</h3>
		<ul class="toggle">
			<li class="icn_categories"><a href="<?php echo IUrl::creatUrl("/seller/goods_list");?>">商品列表</a></li>
			<li class="icn_new_article"><a href="<?php echo IUrl::creatUrl("/seller/goods_edit");?>">添加商品</a></li>
			<li  style="display: none;" class="icn_photo"><a href="<?php echo IUrl::creatUrl("/seller/share_list");?>">平台共享商品</a></li>
			<li class="icn_audio"><a href="<?php echo IUrl::creatUrl("/seller/refer_list");?>">商品咨询</a></li>
			<li class="icn_audio"><a href="<?php echo IUrl::creatUrl("/seller/comment_list");?>">商品评价</a></li>
			<li class="icn_audio"><a href="<?php echo IUrl::creatUrl("/seller/refundment_list");?>">商品退款</a></li>
			<li class="icn_categories"><a href="<?php echo IUrl::creatUrl("/seller/spec_list");?>">规格列表</a></li>
		</ul>

		<h3>订单模块</h3>
		<ul class="toggle">
			<li class="icn_categories"><a href="<?php echo IUrl::creatUrl("/seller/order_list");?>">订单列表</a></li>
		</ul>

		<h3  style="display: none;">营销模块</h3>
		<ul  style="display: none;" class="toggle">
			<li class="icn_view_users"><a href="<?php echo IUrl::creatUrl("/seller/regiment_list");?>">团购</a></li>
		</ul>

		<h3>信息模块</h3>
		<ul class="toggle">
			<li class="icn_profile"><a href="<?php echo IUrl::creatUrl("/seller/seller_edit");?>">资料修改</a></li>
			<li class="icn_profile"><a href="<?php echo IUrl::creatUrl("/seller/payment_conf");?>">收款信息</a></li>
			<li class="icn_video"><a href="<?php echo IUrl::creatUrl("/site/home/id/".$seller_id."");?>" target="_blank">主页信息</a></li>
		</ul>

		<footer>
			<hr />
			<p><strong>Copyright &copy; 2015 Sunup</strong></p>
			<p>Powered by <a href="<?php echo BASE_URL;?>">尚普商城</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<?php $seller_id = $this->seller['seller_id']?>
<?php $searchParam = http_build_query(Util::getUrlParam('search'))?>
<?php $condition = Util::search(IReq::get('search'));$where = $condition ? " and ".$condition : "";?>
<script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/my97date/wdatepicker.js"></script>
<article class="module width_full">
	<header>
		<h3 class="tabs_involved">订单列表</h3>
		<ul class="tabs">
			<li><input type="button" class="alt_btn" onclick="filterResult();" value="检索" /></li>
			<li><input type="button" class="alt_btn" onclick="window.open('<?php echo IUrl::creatUrl("/seller/order_report/?".$searchParam."");?>')" value="导出Excel" /></li>
			<li><input type="button" class="alt_btn" onclick="order_deliveries()" value="一键发货" /></li>
		</ul>
	</header>

	<table class="tablesorter" cellspacing="0">
		<colgroup>
			<col width="145px" />
			<col width="85px" />
			<col width="115px" />
			<col width="125px" />
			<col width="125px" />
			<col width="155px" />
			<col width="75px" />
			<col />
		</colgroup>

		<thead>
			<tr>
				<th>订单号</th>
				<th>收货人</th>
				<th>联系电话</th>
				<th>配送状态</th>
				<th>支付状态</th>
				<th>下单时间</th>
				<th>打印</th>
				<th>操作</th>
			</tr>
		</thead>

		<tbody>
			<?php $page = IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1?>
			<?php $orderObject = new IQuery("order_goods as og");$orderObject->join = "left join goods as go on go.id = og.goods_id left join order as o on o.id = og.order_id";$orderObject->fields = "o.*";$orderObject->page = "$page";$orderObject->where = "go.seller_id = $seller_id and o.if_del = 0 and o.status  !=  4 $where";$items = $orderObject->find(); foreach($items as $key => $item){?>
			<tr>
				<td title="<?php echo isset($item['order_no'])?$item['order_no']:"";?>"><?php echo isset($item['order_no'])?$item['order_no']:"";?></td>
				<td title="<?php echo isset($item['accept_name'])?$item['accept_name']:"";?>"><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td>
				<td title="<?php echo isset($item['mobile'])?$item['mobile']:"";?>"><?php echo isset($item['mobile'])?$item['mobile']:"";?></td>
				<td><span name="disStatusColor<?php echo isset($item['distribution_status'])?$item['distribution_status']:"";?>"><?php echo Order_class::getOrderDistributionStatusText($item);?></span></td>
				<td>
					<span name="payStatusColor<?php echo isset($item['pay_status'])?$item['pay_status']:"";?>">
					<?php if($item['pay_type']==0){?>货到付款<?php }?>
					&nbsp;&nbsp;
					<?php echo Order_class::getOrderPayStatusText($item);?>
					</span>
				</td>
				<td title="<?php echo isset($item['create_time'])?$item['create_time']:"";?>"><?php echo isset($item['create_time'])?$item['create_time']:"";?></td>
				<td>
					<span class="prt" title="购物清单打印" onclick="window.open('<?php echo IUrl::creatUrl("/order/shop_template/id/".$item['id']."/seller_id/".$seller_id."");?>');">购</span>
					<span class="prt" title="配货单打印" onclick="window.open('<?php echo IUrl::creatUrl("/order/pick_template/id/".$item['id']."/seller_id/".$seller_id."");?>');">配</span>
					<span class="prt" title="联合打印" onclick="window.open('<?php echo IUrl::creatUrl("/order/merge_template/id/".$item['id']."/seller_id/".$seller_id."");?>');">合</span>
					<span class="prt" title="快递单打印" onclick="window.open('<?php echo IUrl::creatUrl("/order/expresswaybill_template/id/".$item['id']."");?>');">递</span>
				</td>
				<td>
					<a class="order_deliery" data-id="<?php if(Order_class::isGoDelivery($item)){?><?php echo IUrl::creatUrl("/seller/order_deliver/id/".$item['id']."");?><?php }else{?><?php }?>" href="<?php if(Order_class::isGoDelivery($item)){?><?php echo IUrl::creatUrl("/seller/order_deliver/id/".$item['id']."");?><?php }else{?>javascript:alert('此单不满足发货条件');<?php }?>"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/main/icn_jump_back.png";?>" title="立即发货" alt="立即发货" /></a>
					<a href="<?php echo IUrl::creatUrl("/seller/order_show/id/".$item['id']."");?>"><img title="订单详情" alt="订单详情" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/main/icn_settings.png";?>" /></a>
				</td>
			</tr>
		   <?php }?>
		</tbody>
	</table>
    <?php echo $orderObject->getPageBar();?>
</article>

<script type="text/html" id="orderTemplate">
<form action="<?php echo IUrl::creatUrl("/");?>" method="get" name="filterForm">
	<input type='hidden' name='controller' value='seller' />
	<input type='hidden' name='action' value='order_list' />
	<div class="module_content">
	  
		<fieldset>
			<label>订单号</label>
			<input name="search[order_no=]" value="" type="text" />
		</fieldset>
		<fieldset>
			<label>收货人</label>
			<input name="search[accept_name=]" value="" type="text" />
		</fieldset>
		
		<fieldset>
			<label>支付时间开始检索</label>
			<input name="search[pay_time_start]" value="" type="text" pattern='datetime' readonly="true" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd 00:00:00'})" onblur="FireEvent(this,'onchange');" alt='请填写一个日期' />
		</fieldset>
		
		
		<fieldset>
			<label>支付时间结束检索</label>
			<input name="search[pay_time_end]" value="" type="text"  pattern='datetime' readonly="true" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd 23:59:59'})" onblur="FireEvent(this,'onchange');" alt='请填写一个日期' />
		</fieldset>
 
		<fieldset>
			<label>选择支付状态</label>
			<select name="search[pay_status=]">
				<option value="">全部</option>
				<option value="0">未支付</option>
				<option value="1">已支付</option>
				<option value="2">退款成功</option>
			</select>
		</fieldset>
		 <fieldset>
			<label>选择发货状态</label>
			<select name="search[distribution_status=]">
				<option value="">全部</option>
				<option value="0">未发货</option>
				<option value="1">已发货</option>
				<option value="2">部分发货</option>
			</select>
		</fieldset>
	 
		<fieldset>
			<label>订单状态</label>
			<select name="search[status=]">
				<option value="">全部</option>
				<option value="1">新订单</option>
				<option value="2">确认订单</option>
				<option value="3">取消订单</option>
				<option value="4">作废订单</option>
				<option value="5">完成订单</option>
			</select>
		</fieldset>  
    </div>
</form>
</script>
<script type='text/javascript'>

//检索商品
function filterResult()
{
	var ordersHeadHtml = template.render('orderTemplate');
	art.dialog(
	{
		"init":function()
		{
			var filterPost = <?php echo JSON::encode(IReq::get('search'));?>;
			var formObj = new Form('filterForm');
			for(var index in filterPost)
			{
				formObj.setValue("search["+index+"]",filterPost[index]);
			}
		},
		"title":"检索条件",
		"content":ordersHeadHtml,
		"okVal":"立即检索",
		"ok":function(iframeWin, topWin)
		{
			iframeWin.document.forms[0].submit();
		}
	});
}

function order_deliveries()  {
	var idStr = '';
	$('.order_deliery').each(function(i){

		if($(this).attr('data-id') !='') {
			//console.log($(this).attr('data-id').split('=')[3]);
		    idStr += $(this).attr('data-id').split('=')[3]+',';
		}

	});
	idStr = idStr.substring(0,idStr.length-1);
	var data = {'ids':idStr}
	//console.log(idStr);
	console.log();
	$.ajax({
		type:'POST',
		async:false,
		url:'<?php echo IUrl::creatUrl("/seller/order_deliveries");?>',
		data:data,
		success:function(res){
			alert(res)
	},
	});

}

//DOM加载结束
$(function(){
	//高亮色彩
	$('[name="payStatusColor1"]').addClass('green');
	$('[name="disStatusColor1"]').addClass('green');
});
</script>

	</section>
	<!--主题内容 结束-->
</body>
</html>
