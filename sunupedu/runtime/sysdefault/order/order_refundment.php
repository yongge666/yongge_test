<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>管理后台</title>
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/style.css" />
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/admin.js";?>"></script>
</head>

<body style="width:600px;min-height:400px;">
<div class="pop_win">
	<form action="<?php echo IUrl::creatUrl("/order/order_refundment_doc");?>" method="post">
		<input type="hidden" name="refunds_id" value="<?php echo isset($refunds['id'])?$refunds['id']:"";?>"/>
		<input type="hidden" name="id" value="<?php echo isset($order_id)?$order_id:"";?>"/>
		<input type="hidden" name="order_no" value="<?php echo isset($order_no)?$order_no:"";?>"/>
		<input type="hidden" name="user_id" value="<?php echo isset($user_id)?$user_id:"";?>"/>

		<table width="95%" class="border_table" style="margin:10px auto">
			<colgroup>
				<col width="100px" />
				<col />
			</colgroup>

			<tbody>
				<tr>
					<th>订单号:</th><td align="left"><?php echo isset($order_no)?$order_no:"";?></td>
				</tr>
				<tr>
					<th>下单时间:</th><td align="left"><?php echo isset($create_time)?$create_time:"";?></td>
				</tr>
				<tr>
					<th>应付商品金额:</th>
					<td align="left"><?php echo isset($payable_amount)?$payable_amount:"";?></td>
				</tr>
				<tr>
					<th>实际支付商品金额:</th>
					<td align="left"><?php echo isset($real_amount)?$real_amount:"";?></td>
				</tr>
				<tr>
					<th>应付运费金额:</th>
					<td align="left"><?php echo isset($payable_freight)?$payable_freight:"";?></td>
				</tr>
				<tr>
					<th>实际支付运费金额:</th>
					<td align="left"><?php echo isset($real_freight)?$real_freight:"";?></td>
				</tr>

				<?php if($if_insured == 1){?>
				<tr>
					<th>订单保价金额:</th>
					<td align="left"><?php echo isset($insured)?$insured:"";?></td>
				</tr>
				<?php }?>

				<?php if($pay_fee > 0){?>
				<tr>
					<th>订单支付手续费金额:</th>
					<td align="left"><?php echo isset($pay_fee)?$pay_fee:"";?></td>
				</tr>
				<?php }?>

				<?php if($invoice == 1){?>
				<tr>
					<th>订单税金金额:</th>
					<td align="left"><?php echo isset($taxes)?$taxes:"";?></td>
				</tr>
				<?php }?>

				<?php if($promotions > 0){?>
				<tr>
					<th>订单优惠金额:</th>
					<td align="left"><?php echo isset($promotions)?$promotions:"";?></td>
				</tr>
				<?php }?>

				<?php if($discount != 0){?>
				<tr>
					<th>订单价格修改:</th>
					<td align="left"><?php echo isset($discount)?$discount:"";?></td>
				</tr>
				<?php }?>

				<tr>
					<th>订单总额:</th>
					<td align="left"><?php echo isset($order_amount)?$order_amount:"";?></td>
				</tr>
				<tr>
					<th>退款商品:</th>
					<td align="left">
					<?php if(isset($refunds)){?>
						<?php $query = new IQuery("order_goods");$query->where = "order_id = $refunds[order_id] and goods_id = $refunds[goods_id] and product_id = $refunds[product_id]";$items = $query->find(); foreach($items as $key => $item){?>
						<?php $goods = JSON::decode($item['goods_array'])?>
						<?php echo isset($goods['name'])?$goods['name']:"";?> X <?php echo isset($item['goods_nums'])?$item['goods_nums']:"";?>件
						【<?php echo Order_Class::goodsSendStatus($item['is_send']);?>】
						<?php }?>
						<?php if($refunds['seller_id']){?>
						<a href="<?php echo IUrl::creatUrl("/site/home/id/".$refunds['seller_id']."");?>" target="_blank"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/seller_ico.png";?>" /></a>
						<?php }?>
					<?php }else{?>
						<?php foreach(Api::run('getOrderGoodsListByGoodsid',array('#order_id#',$order_id)) as $key => $good){?>
						<?php $good_info = JSON::decode($good['goods_array'])?>
						<?php if($good['is_send'] != 2){?>
						<label>
							<input type="radio" name="order_goods_id" value="<?php echo isset($good['id'])?$good['id']:"";?>" onclick="countGoodsAmount(<?php echo $good['goods_nums']*$good['real_price'];?>);" />
							<a class="blue" href="<?php echo IUrl::creatUrl("/site/products/id/".$good['goods_id']."");?>" target='_blank'><?php echo isset($good_info['name'])?$good_info['name']:"";?><?php if($good_info['value']){?><?php echo isset($good_info['value'])?$good_info['value']:"";?><?php }?> X <?php echo isset($good['goods_nums'])?$good['goods_nums']:"";?>件</a>
						</label>
						<br/>
						<?php }?>
						<?php }?>
					<?php }?>
					</td>
				</tr>
				<tr>
					<th>退款金额:</th><td align="left"><input type="text" class="small" name="amount" id="amount" value="<?php echo isset($refunds['amount'])?$refunds['amount']:"";?>" pattern="float" /></td>
				</tr>
				<tr>
					<th>说明:</th>
					<td align="left">点击退款后，<退款金额>将直接转入到用户的余额中</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
</body>
<script type="text/javascript">
//计算商品退款金额
function countGoodsAmount(amount)
{
	$('#amount').val(amount);
}
</script>
</html>