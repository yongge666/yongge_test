<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>单据打印</title>
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
<link rel="shortcut icon" href="favicon.ico" />
<style media="print" type="text/css">.noprint{display:none}</style>
<style media="screen,print" type="text/css">
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td,button{padding:0;margin:0;font-size:100%;}
body{font:12px/1.5 "宋体", Arial, Helvetica, sans-serif;color:#404040;background-color:#fff;text-align:center}
table{border-collapse:collapse;}
.container{width:90%;margin:20px auto}
.v_m{vertical-align: middle}
.ml_20{margin-left:20px;}
.m_10{ margin-bottom:10px;}
.f14{font-size:14px;}
.f18{font-size:18px;}
.f30{font-size:30px;}
.bold{font-weight:bold}
.gray{color:#979797}
.orange{color:#f76f10;}
table.table.topBorder{border-top:2px solid #b0b0b0;}
table.table tr{_background-image:none}
.btn_print{width:112px;height:31px;margin:20px auto;border:0;}
</style>
</head>

<body>
	<div class="container">
	<table class="m_10" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="f18"><?php if(isset($set['name'])){?><?php echo isset($set['name'])?$set['name']:"";?><?php }?>购物清单</td>
		</tr>
		<tr>
			<td valign="bottom" align="right"><p>客户:<?php echo isset($accept_name)?$accept_name:"";?><span class="ml_20">地址:<?php echo isset($address)?$address:"";?></span><span class="ml_20">电话:<?php echo isset($mobile)?$mobile:"";?></span></p></td>
		</tr>
	</table>

	<table class="table" width="100%" cellspacing="0" cellpadding="0" border="1">
		<colgroup>
			<col width="370px" />
			<col width="120px" />
			<col width="120px" />
			<col width="100px" />
			<col width="100px" />
			<col width="120px" />
		</colgroup>

		<tbody>
			<tr class="f17">
				<th colspan="2" style="text-align:left;border-right:none;">
					<b>订单号:<?php echo isset($order_no)?$order_no:"";?></b>
				</th>
				<th colspan="4" style="text-align:right;border-left:none;">
					<b>订购日期:<?php echo date('Y-m-d',strtotime($create_time));?></b>
				</th>
			</tr>

			<tr class="f14">
				<th>商品名称</th>
				<th>商品货号</th>
				<th>单价</th>
				<th>重量</th>
				<th>数量</th>
				<th>小计</th>
			</tr>
			<?php $goodsSum = 0;$orderWeight = 0?>
			<?php $query = new IQuery("order_goods as og");$query->join = "left join goods as go on go.id = og.goods_id";$query->where = "order_id = $id";$items = $query->find(); foreach($items as $key => $item){?>
			<?php if($seller_id && $item['seller_id'] != $seller_id){?>
			<?php continue;?>
			<?php }?>
			<?php $goodsSum    += $item['real_price'] * $item['goods_nums']?>
			<?php $orderWeight += $item['goods_weight']* $item['goods_nums']?>
			<?php $goodsRow = JSON::decode($item['goods_array'])?>
			<tr>
				<td align="left">
					<label>
						<?php echo isset($goodsRow['name'])?$goodsRow['name']:"";?> &nbsp;
						<span class="gray"><?php echo isset($goodsRow['value'])?$goodsRow['value']:"";?></span>
					</label>
				</td>
				<td><?php echo isset($goodsRow['goodsno'])?$goodsRow['goodsno']:"";?></td>
				<td>￥<?php echo isset($item['real_price'])?$item['real_price']:"";?>元</td>
				<td><?php echo isset($item['goods_weight'])?$item['goods_weight']:"";?></td>
				<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
				<td>￥<?php echo $item['real_price'] * $item['goods_nums'];?>元</td>
			</tr>
			<?php }?>
		</tbody>
	</table>

	<?php $orderCount = CountSum::countOrderFee($goodsSum,$goodsSum,$orderWeight,$province,$distribution,0,false,$if_insured,$invoice)?>
	<table class="table f14" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td align="right">商品总价：￥<?php echo isset($goodsSum)?$goodsSum:"";?>元</td>
		</tr>
		<tr>
			<td align="right">运费价格：￥<?php echo isset($orderCount['deliveryPrice'])?$orderCount['deliveryPrice']:"";?>元</td>
		</tr>
		<tr>
			<td align="left">订单附言：<?php echo isset($postscript)?$postscript:"";?></td>
		</tr>
	</table>

	<table class="table topBorder" width="100%" cellspacing="0" cellpadding="0" border="0">
		<colgroup>
			<col />
			<col width="350px" />
		</colgroup>

		<tr>
			<td align="left">服务商：<?php if(isset($set['name'])){?><?php echo isset($set['name'])?$set['name']:"";?><?php }?></td>
			<td align="left">电话：<?php if(isset($set['phone'])){?><?php echo isset($set['phone'])?$set['phone']:"";?><?php }?></td>
		</tr>
		<tr>
			<td align="left">邮箱：<?php if(isset($set['email'])){?><?php echo isset($set['email'])?$set['email']:"";?><?php }?></td>
			<td align="left">网站：<?php if(isset($set['url'])){?><?php echo isset($set['url'])?$set['url']:"";?><?php }?></td>
		</tr>
	</table>
</div>

<div class="container">
	<table class="m_10" width="100%" cellspacing="0" cellpadding="0" border="0">
		<colgroup>
			<col width="30%" />
			<col width="30%" />
			<col />
		</colgroup>

		<tr>
			<td align="left">
				<p>
					订单号:<?php echo isset($order_no)?$order_no:"";?><br />
					日期:<?php echo date('Y-m-d',strtotime($create_time));?>
				</p>
			</td>
			<td class="f18">配货清单</td>
			<td valign="bottom" align="right"><p>客户:<?php echo isset($accept_name)?$accept_name:"";?><span class="ml_20">电话:<?php echo isset($mobile)?$mobile:"";?></span></p></td>
		</tr>
	</table>

	<table class="table" width="100%" cellspacing="0" cellpadding="0" border="1">
		<colgroup>
			<col width="400px" />
			<col width="160px" />
			<col width="120px" />
			<col width="100px" />
			<col width="120px" />
		</colgroup>

		<tbody>
			<tr class="f14">
				<th>商品名称</th>
				<th>商品货号</th>
				<th>单价</th>
				<th>数量</th>
				<th>小计</th>
			</tr>
			<?php $query = new IQuery("order_goods as og");$query->join = "left join goods as go on go.id = og.goods_id";$query->where = "order_id = $id";$items = $query->find(); foreach($items as $key => $item){?>
			<?php if($seller_id && $item['seller_id'] != $seller_id){?>
			<?php continue;?>
			<?php }?>
			<?php $goodsRow = JSON::decode($item['goods_array'])?>
			<tr>
				<td align="left">
					<label>
						<?php echo isset($goodsRow['name'])?$goodsRow['name']:"";?> &nbsp;
						<span class="gray"><?php echo isset($goodsRow['value'])?$goodsRow['value']:"";?></span>
					</label>
				</td>
				<td><?php echo isset($goodsRow['goodsno'])?$goodsRow['goodsno']:"";?></td>
				<td>￥<?php echo isset($item['real_price'])?$item['real_price']:"";?>元</td>
				<td><?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?></td>
				<td>￥<?php echo $item['real_price'] * $item['goods_nums'];?>元</td>
			</tr>
			<?php }?>
		</tbody>
	</table>

	<table class="table" width="100%" cellspacing="0" cellpadding="0" border="0">
		<colgroup>
			<col width="60%" />
			<col />
		</colgroup>

		<tr>
			<td align="left">订单附言：<?php echo isset($postscript)?$postscript:"";?></td>
			<td align="left">配送：<?php $query = new IQuery("delivery");$query->where = "id = $distribution";$items = $query->find(); foreach($items as $key => $item){?><?php echo isset($item['name'])?$item['name']:"";?><?php }?></td>
		</tr>
		<tr>
			<td align="left">地址：<?php echo isset($address)?$address:"";?></td>
			<td align="left">收货人：<?php echo isset($accept_name)?$accept_name:"";?></td>
		</tr>
		<tr>
			<td align="left">手机：<?php echo isset($mobile)?$mobile:"";?></td>
			<td align="left">电话：<?php echo isset($telphone)?$telphone:"";?></td>
		</tr>
	</table>

	<table class="table topBorder" width="100%" cellspacing="0" cellpadding="0" border="0">
		<tr><td class="f18" align="left"><b>签字：</b></td></tr>
	</table>

	<input type="submit" class="btn_print noprint" onclick="window.print();" value="打印" />
</div>
</body>

</html>