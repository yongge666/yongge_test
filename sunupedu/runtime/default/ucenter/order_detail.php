<?php 
	$myCartObj  = new Cart();
	$myCartInfo = $myCartObj->getMyCart();
	$siteConfig = new Config("site_config");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $siteConfig->name;?></title>
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/index.css";?>" />
	<link rel="shortcut icon" href="favicon.ico" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/site.js";?>'></script>
	<script type='text/javascript'>
		//用户中心导航条
		function menu_current()
		{
		    var current = "<?php echo $this->getAction()->getId();?>";
		    if(current == 'consult_old') current='consult';
		    else if(current == 'isevaluation') current ='evaluation';
		    else if(current == 'withdraw') current = 'account_log';
		    var tmpUrl = "<?php echo IUrl::creatUrl("/ucenter/current");?>";
		    tmpUrl = tmpUrl.replace("current",current);
		    $('div.cont ul.list li a[href^="'+tmpUrl+'"]').parent().addClass("current");
		}
	</script>
</head>
<body class="index">
<div class="ucenter container">
	<div class="header">
		<h1 class="logo"><a title="<?php echo $siteConfig->name;?>" style="background:url(<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/logo.gif";?>);" href="<?php echo IUrl::creatUrl("");?>"><?php echo $siteConfig->name;?></a></h1>
		<ul class="shortcut">
			<li class="first"><a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的账户</a></li><li><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>">我的订单</a></li><li class='last'><a href="<?php echo IUrl::creatUrl("/site/help_list");?>">使用帮助</a></li>
		</ul>
		<p class="loginfo"><?php echo isset($this->user['username'])?$this->user['username']:"";?>您好，欢迎您来到<?php echo $siteConfig->name;?>购物！[<a class='reg' href="<?php echo IUrl::creatUrl("/simple/logout");?>">安全退出</a>]</p>
	</div>
	<div class="navbar">
		<ul>
			<li><a href="<?php echo IUrl::creatUrl("");?>">首页</a></li>
			<?php foreach(Api::run('getGuideList') as $key => $item){?>
			<li><a href="<?php echo IUrl::creatUrl("".$item['link']."");?>"><?php echo isset($item['name'])?$item['name']:"";?><span> </span></a></li>
			<?php }?>
		</ul>
		<div class="mycart">
			<dl>
				<dt><a href="<?php echo IUrl::creatUrl("/simple/cart");?>">购物车<b name="mycart_count"><?php echo isset($myCartInfo['count'])?$myCartInfo['count']:"";?></b>件</a></dt>
				<dd><a href="<?php echo IUrl::creatUrl("/simple/cart");?>">去结算</a></dd>
			</dl>

			<!--购物车浮动div 开始-->
			<div class="shopping" id='div_mycart' style='display:none;'>
			</div>
			<!--购物车浮动div 结束-->

			<!--购物车模板 开始-->
			<script type='text/html' id='cartTemplete'>
			<dl class="cartlist">
				<%for(var item in goodsData){%>
				<%var data = goodsData[item]%>
				<dd id="site_cart_dd_<%=item%>">
					<div class="pic f_l"><img width="55" height="55" src="<?php echo IUrl::creatUrl("")."<%=data['img']%>";?>"></div>
					<h3 class="title f_l"><a href="<?php echo IUrl::creatUrl("/site/products/id/<%=data['goods_id']%>");?>"><%=data['name']%></a></h3>
					<div class="price f_r t_r">
						<b class="block">￥<%=data['sell_price']%> x <%=data['count']%></b>
						<input class="del" type="button" value="删除" onclick="removeCart('<?php echo IUrl::creatUrl("/simple/removeCart");?>','<%=data['id']%>','<%=data['type']%>');$('#site_cart_dd_<%=item%>').hide('slow');" />
					</div>
				</dd>
				<%}%>

				<dd class="static"><span>共<b name="mycart_count"><%=goodsCount%></b>件商品</span>金额总计：<b name="mycart_sum">￥<%=goodsSum%></b></dd>

				<%if(goodsData){%>
				<dd class="static">
					<?php if(ISafe::get('user_id')){?>
					<a class="f_l" href="javascript:void(0)" onclick="deposit_ajax('<?php echo IUrl::creatUrl("/simple/deposit_cart_set");?>');">寄存购物车>></a>
					<?php }?>
					<label class="btn_orange"><input type="button" value="去购物车结算" onclick="window.location.href='<?php echo IUrl::creatUrl("/simple/cart");?>';" /></label>
				</dd>
				<%}%>
			</dl>
			</script>
			<!--购物车模板 结束-->

		</div>
	</div>

	<div class="searchbar">
		<div class="allsort">
			<a href="javascript:void();">全部商品分类</a>

			<!--总的商品分类-开始-->
			<ul class="sortlist" id='div_allsort' style='display:none'>
				<?php foreach(Api::run('getCategoryListTop') as $key => $first){?>
				<li>
					<h2><a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$first['id']."");?>"><?php echo isset($first['name'])?$first['name']:"";?></a></h2>

					<!--商品分类 浮动div 开始-->
					<div class="sublist" style='display:none'>
						<div class="items">
							<strong>选择分类</strong>
							<?php foreach(Api::run('getCategoryByParentid',array('#parent_id#',$first['id'])) as $key => $second){?>
							<dl class="category selected">
								<dt>
									<a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$second['id']."");?>"><?php echo isset($second['name'])?$second['name']:"";?></a>
								</dt>

								<dd>
									<?php foreach(Api::run('getCategoryByParentid',array('#parent_id#',$second['id'])) as $key => $third){?>
									<a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$third['id']."");?>"><?php echo isset($third['name'])?$third['name']:"";?></a>|
									<?php }?>
								</dd>
							</dl>
							<?php }?>
						</div>
					</div>
					<!--商品分类 浮动div 结束-->
				</li>
				<?php }?>
			</ul>
			<!--总的商品分类-结束-->

		</div>

		<div class="searchbox">

			<form method='get' action='<?php echo IUrl::creatUrl("/");?>'>
				<input type='hidden' name='controller' value='site' />
				<input type='hidden' name='action' value='search_list' />
				<input class="text" type="text" name='word' autocomplete="off" value="输入关键字..." />
				<input class="btn" type="submit" value="商品搜索" onclick="checkInput('word','输入关键字...');" />
			</form>

			<!--自动完成div 开始-->
			<ul class="auto_list" style='display:none'></ul>
			<!--自动完成div 开始-->

		</div>
		<div class="hotwords">热门搜索：
			<?php foreach(Api::run('getKeywordList') as $key => $item){?>
			<?php $tmpWord = urlencode($item['word']);?>
			<a href="<?php echo IUrl::creatUrl("/site/search_list/word/".$tmpWord."");?>"><?php echo isset($item['word'])?$item['word']:"";?></a>
			<?php }?>
		</div>
	</div>

	<div class="position">
		您当前的位置： <a href="<?php echo IUrl::creatUrl("");?>">首页</a> » <a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的账户</a>
	</div>
	<div class="wrapper clearfix">
		<div class="sidebar f_l">
			<img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/ucenter/ucenter.gif";?>" width="180" height="40" />
			<div class="box">
				<div class="title"><h2>交易记录</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>">我的订单</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/integral");?>">我的积分</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/redpacket");?>">我的代金券</a></li>
					</ul>
				</div>
			</div>
			<div class="box">
				<div class="title"><h2 class='bg2'>服务中心</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/refunds");?>">退款申请</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/complain");?>">站点建议</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/consult");?>">商品咨询</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/evaluation");?>">商品评价</a></li>
					</ul>
				</div>
			</div>
			<div class="box">
				<div class="title"><h2 class='bg3'>应用</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/message");?>">短信息</a></li>
						<li style="display:none"><a href="<?php echo IUrl::creatUrl("/ucenter/favorite");?>">收藏夹</a></li>
					</ul>
				</div>
			</div>
			<div class="box">
				<div class="title"><h2 class='bg4'>账户资金</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/account_log");?>">帐户余额</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/online_recharge");?>">在线充值</a></li>
					</ul>
				</div>
			</div>
			<div class="box">
				<div class="title"><h2 class='bg5'>个人设置</h2></div>
				<div class="cont">
					<ul class="list">
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/address");?>">地址管理</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/info");?>">个人资料</a></li>
						<li><a href="<?php echo IUrl::creatUrl("/ucenter/password");?>">修改密码</a></li>
					</ul>
				</div>
			</div>
		</div>
		<?php $orderStatus = Order_Class::getOrderStatus($this->order_info)?>
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/artTemplate/area_select.js";?>'></script>

<div class="main f_r">
	<div class="uc_title m_10">
		<label class="current"><span>订单详情</span></label>
	</div>

	<div class="prompt_2 m_10">
		<div class="t_part">
			<?php $orderStep = Order_Class::orderStep($this->order_info)?>
			<?php foreach($orderStep as $eventTime => $stepData){?>
			<p><?php echo isset($eventTime)?$eventTime:"";?>&nbsp;&nbsp;<span class="black"><?php echo isset($stepData)?$stepData:"";?></span></p>
			<?php }?>
		</div>
		<p>
			<b>订单号：</b><?php echo isset($this->order_info['order_no'])?$this->order_info['order_no']:"";?>
			<b>下单日期：</b><?php echo isset($this->order_info['create_time'])?$this->order_info['create_time']:"";?>
			<b>状态：</b>
			<span class="red2">
				<b class="orange"><?php echo Order_Class::orderStatusText($orderStatus);?></b>
	        </span>
        </p>

        <form action='<?php echo IUrl::creatUrl("/ucenter/order_status");?>' method='post'>
        <p>
	        <input type="hidden" name="order_id" value="<?php echo isset($this->order_info['order_id'])?$this->order_info['order_id']:"";?>" />
	    	<?php if(in_array($orderStatus,array(1,2))){?>
	        <label class="btn_orange">
	        	<input type="hidden" name='op' value='cancel' />
	        	<input type="submit" value="取消订单" />
	        </label>
	        <?php }?>

			<?php if($orderStatus == 2){?>
			<label class="btn_green">
				<input type="button" value="立即付款" onclick="window.location.href='<?php echo IUrl::creatUrl("/block/doPay/order_id/".$this->order_info['order_id']."");?>'" />
			</label>
			<?php }?>

			<?php if(in_array($orderStatus,array(11,3))){?>
	        <label class="btn_green">
	        	<input type="hidden" name='op' value='confirm' />
	        	<input type="submit" value="确认收货" />
	        </label>
			<?php }?>

	        <?php if(Order_Class::isRefundmentApply($this->order_info)){?>
	        <label class="btn_orange">
	        	<input id="reimburse" type="button" value="申请退款" href="<?php echo IUrl::creatUrl("/ucenter/refunds_edit/order_id/".$this->order_info['order_id']."");?>" />
	        </label>
	    	<?php }?>
	    </p>
        </form>
	</div>

	<div class="box m_10">
		<div class="title">
			<h2><span class="orange">收件人信息</span></h2>
		</div>

		<!--收获信息展示-->
		<div class="cont clearfix" id="acceptShow">
		
			
			<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
			<?php foreach($this->order_info['address_list'] as $key => $item){?>
				<col width="130px" />
				<col />
				<tr>
					<th>收货人<?php echo $kk = $key+1;?>：</th>
					<td><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td>
				</tr>
				<tr>
					<th>地址：</th>
					<td> <?php echo isset($item['province_val'])?$item['province_val']:"";?><?php echo isset($item['city_val'])?$item['city_val']:"";?><?php echo isset($item['area_val'])?$item['area_val']:"";?><?php echo isset($item['address'])?$item['address']:"";?></td>
				</tr>
				<tr>
					<th>邮编：</th>
					<td><?php echo isset($item['zip'])?$item['zip']:"";?></td>
				</tr>
				<tr>
					<th>固定电话：</th>
					<td><?php echo isset($item['telphone'])?$item['telphone']:"";?></td>
				</tr>
				<tr>
					<th>手机号码：</th>
					<td><?php echo isset($item['mobile'])?$item['mobile']:"";?></td>
				</tr>
				<tr>
					<th>------------</th>
					<td>----------------------------------------------------------------------------------------</td>
				</tr>
				<?php }?>
			</table>
			
			
			
		</div>

		<!--收获信息修改表单-->
		<div class="cont clearfix" id="acceptForm" style="display:none;">
			<form method="post" action="<?php echo IUrl::creatUrl("/ucenter/order_accept");?>" name="modelForm">
				<input type="hidden" name="order_id" value="<?php echo isset($this->order_info['id'])?$this->order_info['id']:"";?>"/>
				<input type="hidden" name="goods_weight" value=""/>

				<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
					<col width="130px" />
					<col />
					<tr>
						<th>收货人：</th>
						<td><input class="normal" type="text" name="accept_name" pattern="required" value="<?php echo isset($this->order_info['accept_name'])?$this->order_info['accept_name']:"";?>" alt="收货人姓名错误"/><label>收货人姓名</label></td>
					</tr>
					<tr>
						<th>地址地区：</th>
						<td>
							<select name="province" child="city,area" onchange="areaChangeCallback(this);countDelievey();"></select>
							<select name="city" child="area" parent="province" onchange="areaChangeCallback(this);"></select>
							<select name="area" parent="city" pattern="required"></select>
						</td>
					</tr>
					<tr>
						<th>邮编：</th>
						<td><input class="normal" type="text" name="postcode" pattern="zip" value="<?php echo isset($this->order_info['postcode'])?$this->order_info['postcode']:"";?>" alt="填写正确的邮编"/><label>收货人邮编</label></td>
					</tr>
					<tr>
						<th>地址：</th>
						<td><input class="normal" type="text" name="address" pattern="required" value="<?php echo isset($this->order_info['address'])?$this->order_info['address']:"";?>" alt="收货地址错误"/><label>收货地址</label></td>
					</tr>
					<tr>
						<th>固定电话：</th>
						<td><input class="normal" type="text" name="telphone" empty pattern="phone" value="<?php echo isset($this->order_info['telphone'])?$this->order_info['telphone']:"";?>" alt="请输入正确的联系电话"/><label>联系电话</label></td>
					</tr>
					<tr>
						<th>手机号码：</th>
						<td><input class="normal" type="text" name="mobile" empty pattern="mobi" maxlength="11" value="<?php echo isset($this->order_info['mobile'])?$this->order_info['mobile']:"";?>" alt="手机号码错误"/><lable>手机号码</lable></td>
					</tr>
					<tr>
						<th></th><td colspan="2"><label class="btn"><input type="submit" value="保存" /></label></td>
					</tr>
				</table>
			</form>
		</div>
	</div>

	<!--支付和配送-->
	<div class="box m_10">
		<div class="title"><h2><span class="orange">支付及配送方式</span></h2></div>
		<div class="cont clearfix">
			<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<col width="130px" />
				<col />
				<tr>
					<th>配送方式：</th>
					<td><?php echo isset($this->order_info['delivery'])?$this->order_info['delivery']:"";?></td>
				</tr>

				<?php if($this->order_info['takeself']){?>
				<tr>
					<th>自提地址：</th>
					<td>
						<?php echo isset($this->order_info['takeself']['province_str'])?$this->order_info['takeself']['province_str']:"";?>
						<?php echo isset($this->order_info['takeself']['city_str'])?$this->order_info['takeself']['city_str']:"";?>
						<?php echo isset($this->order_info['takeself']['area_str'])?$this->order_info['takeself']['area_str']:"";?>
						<?php echo isset($this->order_info['takeself']['address'])?$this->order_info['takeself']['address']:"";?>
					</td>
				</tr>
				<tr>
					<th>自提联系方式：</th>
					<td>
						座机：<?php echo isset($this->order_info['takeself']['phone'])?$this->order_info['takeself']['phone']:"";?> &nbsp;&nbsp;
						手机：<?php echo isset($this->order_info['takeself']['mobile'])?$this->order_info['takeself']['mobile']:"";?>
					</td>
				</tr>
				<?php }?>

				<tr>
					<th>支付方式：</th>
					<td><?php echo isset($this->order_info['payment'])?$this->order_info['payment']:"";?></td>
				</tr>

				<?php if($this->order_info['paynote']){?>
				<tr>
					<th>支付说明：</th>
					<td><?php echo isset($this->order_info['paynote'])?$this->order_info['paynote']:"";?></td>
				</tr>
				<?php }?>

				<tr>
					<th>运费：</th>
					<td><?php echo isset($this->order_info['real_freight'])?$this->order_info['real_freight']:"";?></td>
				</tr>
				<tr>
					<th>物流公司：</th>
					<td><?php echo isset($this->order_info['freight']['freight_name'])?$this->order_info['freight']['freight_name']:"";?></td>
				</tr>
				<tr>
					<th>快递单号：</th>
					<td><?php echo isset($this->order_info['freight']['delivery_code'])?$this->order_info['freight']['delivery_code']:"";?></td>
				</tr>
			</table>
		</div>
	</div>

    <!--发票信息-->
    <?php if($this->order_info['invoice']==1){?>
	<div class="box m_10">
		<div class="title"><h2><span class="orange">发票信息</span></h2></div>
		<div class="cont clearfix">
			<table class="dotted_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<col width="129px" />
				<col />
				<tr>
					<th>所需税金：</th>
					<td><?php echo isset($this->order_info['taxes'])?$this->order_info['taxes']:"";?></td>
				</tr>
				<tr>
					<th>发票抬头：</th>
					<td><?php echo isset($this->order_info['invoice_title'])?$this->order_info['invoice_title']:"";?></td>
				</tr>
			</table>
		</div>
	</div>
    <?php }?>

	<!--物品清单-->
	<div class="box m_10">
		<div class="title"><h2><span class="orange">商品清单</span></h2></div>
		<div class="cont clearfix">
			<table class="list_table f_l" width="100%" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<th>图片</th>
						<th>商品名称</th>
						<th>赠送积分</th>
						<th>商品价格</th>
						<th>优惠金额</th>
						<th>商品数量</th>
						<th>小计</th>
						<th>配送</th>
					</tr>
                    <?php foreach(Api::run('getOrderGoodsListByGoodsid',array('#order_id#',$this->order_info['order_id'])) as $key => $good){?>
                    <?php $good_info = JSON::decode($good['goods_array'])?>
                    <?php $totalWeight = $good['goods_nums'] * $good['goods_weight']?>
					<tr>
						<td><img class="pro_pic" src="<?php echo IUrl::creatUrl("")."".$good['img']."";?>" width="50px" height="50px" onerror='this.src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/nopic_100_100.gif";?>"' /></td>
						<td class="t_l">
							<a class="blue" href="<?php echo IUrl::creatUrl("/site/products/id/".$good['goods_id']."");?>" target='_blank'><?php echo isset($good_info['name'])?$good_info['name']:"";?></a>
							<?php if($good_info['value']!=''){?><p><?php echo isset($good_info['value'])?$good_info['value']:"";?></p><?php }?>
						</td>
						<td><?php echo $good['point']*$good['goods_nums'];?></td>
						<td class="red2">￥<?php echo isset($good['goods_price'])?$good['goods_price']:"";?></td>
						<td class="red2">￥<?php echo $good['goods_price']-$good['real_price'];?></td>
						<td>x <?php echo isset($good['goods_nums'])?$good['goods_nums']:"";?></td>
						<td class="red2 bold">￥<?php echo $good['goods_nums']*$good['real_price'];?></td>
						<td>
							<?php echo Order_Class::goodsSendStatus($good['is_send']);?>
							<?php if($good['delivery_id']){?>
							<input type='button' class='sbtn' value='物流' onclick='freightLine(<?php echo isset($good['delivery_id'])?$good['delivery_id']:"";?>);' />
							<?php }?>
						</td>
					</tr>
                    <?php }?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="gray_box">
		<div class="t_part">
			<p>商品总金额：￥<?php echo isset($this->order_info['payable_amount'])?$this->order_info['payable_amount']:"";?></p>
			<p>+ 运费：￥<label id="freightFee"><?php echo isset($this->order_info['real_freight'])?$this->order_info['real_freight']:"";?></label></p>

            <?php if($this->order_info['taxes'] > 0){?>
            <p>+ 税金：￥<?php echo isset($this->order_info['taxes'])?$this->order_info['taxes']:"";?></p>
            <?php }?>

            <?php if($this->order_info['pay_fee'] > 0){?>
            <p>+ 支付手续费：￥<?php echo isset($this->order_info['pay_fee'])?$this->order_info['pay_fee']:"";?></p>
            <?php }?>

            <?php if($this->order_info['insured'] > 0){?>
            <p>+ 保价：￥<?php echo isset($this->order_info['insured'])?$this->order_info['insured']:"";?></p>
            <?php }?>

            <p>订单折扣或涨价：￥<?php echo isset($this->order_info['discount'])?$this->order_info['discount']:"";?></p>

            <?php if($this->order_info['promotions'] > 0){?>
            <p>- 促销优惠金额：￥<?php echo isset($this->order_info['promotions'])?$this->order_info['promotions']:"";?></p>
            <?php }?>
		</div>

		<div class="b_part">
			<p>订单支付金额：<span class="red2">￥<label id="order_amount"><?php echo isset($this->order_info['order_amount'])?$this->order_info['order_amount']:"";?></label></span></p>
		</div>
	</div>
</div>

<script type="text/javascript">
//DOM加载完毕
$(function(){
	//初始化地域联动
	template.compile("areaTemplate",areaTemplate);
	createAreaSelect('province',0,<?php echo isset($this->order_info['province'])?$this->order_info['province']:"";?>);
	createAreaSelect('city',<?php echo isset($this->order_info['province'])?$this->order_info['province']:"";?>,<?php echo isset($this->order_info['city'])?$this->order_info['city']:"";?>);
	createAreaSelect('area',<?php echo isset($this->order_info['city'])?$this->order_info['city']:"";?>,<?php echo isset($this->order_info['area'])?$this->order_info['area']:"";?>);

	//设置商品总重量
	$('[name="goods_weight"]').val(<?php echo isset($totalWeight)?$totalWeight:"";?>);


	//退款提示
	$("#reimburse").on("click",function(event){
		//event.preventDefault();
		//event.stopPropagation();
		var message = '1.申请退款的条件：已付款未发货的订单或者已与店主协商同意退款的订单；</br>2.申请退款的操作：在个人账户中申请退款后，登录用户支付宝账号，查找到本订单交易记录，在支付宝端再次申请退款，如退款不及时请及时与店主电话联系，店主电话通过下订单时选择的商品信息中查找。';
		//退货提示
		var dialog = art.dialog({
			title: '提示',
			content: message,
			width: '20em',
			button: [{
				name: '确定',
				focus: true
			}],
			ok:function(){
				window.location.href=$("#reimburse").attr('href');
			},
		});

	});



});

//计算运费
function countDelievey()
{
	var provinceId   = $('[name="province"]').val();
	var total_weight = <?php echo isset($totalWeight)?$totalWeight:"";?>;
	var goodsSum     = <?php echo isset($this->order_info['real_amount'])?$this->order_info['real_amount']:"";?>;
	var distribution = <?php echo isset($this->order_info['distribution'])?$this->order_info['distribution']:"";?>;

	$.getJSON('<?php echo IUrl::creatUrl("/block/order_delivery");?>',{"province":provinceId,"total_weight":total_weight,"goodsSum":goodsSum,"distribution":distribution},function(json){
		if(json)
		{
			//不能送达
			if(json.if_delivery == 1)
			{
				alert('对不起，该地区不能送达，请您重新选择省份');
				return;
			}

			//做订单差运算
			var oldFreightFee  = $('#freightFee').text();
			var oldOrderAmount = $('#order_amount').text();
			var diff           = parseFloat(json.price) - parseFloat(oldFreightFee);
			var diffAmount     = parseFloat(oldOrderAmount) + parseFloat(diff);

			//更新数据
			$('#freightFee').text(json.price);
			$('#order_amount').text(diffAmount);
		}
	});
}

/**
 * 生成地域js联动下拉框
 * @param name
 * @param parent_id
 * @param select_id
 */
function createAreaSelect(name,parent_id,select_id)
{
	//生成地区
	$.getJSON("<?php echo IUrl::creatUrl("/block/area_child");?>",{"aid":parent_id,"random":Math.random()},function(json)
	{
		$('[name="'+name+'"]').html(template.render('areaTemplate',{"select_id":select_id,"data":json}));
	});
}

//快递跟踪
function freightLine(doc_id)
{
	var urlVal = "<?php echo IUrl::creatUrl("/block/freight/id/@id@");?>";
	urlVal = urlVal.replace("@id@",doc_id);
	art.dialog.open(urlVal,{'title':'轨迹查询'});
}

//修改表单信息
function editForm()
{
	$('#acceptShow').toggle();
	$('#acceptForm').toggle();
}
</script>

	</div>

	<div class="help m_10">
		<div class="cont clearfix">
			<?php foreach(Api::run('getHelpCategoryFoot') as $key => $helpCat){?>
			<dl>
     			<dt><a href="<?php echo IUrl::creatUrl("/site/help_list/id/".$helpCat['id']."");?>"><?php echo isset($helpCat['name'])?$helpCat['name']:"";?></a></dt>
				<?php foreach(Api::run('getHelpListByCatidAll',array('#cat_id#',$helpCat['id'])) as $key => $item){?>
					<dd><a href="<?php echo IUrl::creatUrl("/site/help/id/".$item['id']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></dd>
				<?php }?>
      		</dl>
      		<?php }?>
		</div>
	</div>
	<?php echo IFilter::stripSlash($siteConfig->site_footer_code);?>
</div>
<script type='text/javascript'>
//DOM加载完毕后运行
$(function()
{
	$(".tabs").each(function(i){
	    var parrent = $(this);
		$('.tabs_menu .node',this).each(function(j){
			var current=".node:eq("+j+")";
			$(this).bind('click',function(event){
				$('.tabs_menu .node',parrent).removeClass('current');
				$(this).addClass('current');
				$('.tabs_content>.node',parrent).css('display','none');
				$('.tabs_content>.node:eq('+j+')',parrent).css('display','block');
			});
		});
	});

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

	menu_current();

	$('input:text[name="word"]').bind({
		keyup:function(){autoComplete('<?php echo IUrl::creatUrl("/site/autoComplete");?>','<?php echo IUrl::creatUrl("/site/search_list/word/@word@");?>','<?php echo isset($siteConfig->auto_finish)?$siteConfig->auto_finish:"";?>');}
	});

	<?php $word = IReq::get('word') ? IFilter::act(IReq::get('word'),'text') : '输入关键字...'?>
	$('input:text[name="word"]').val("<?php echo isset($word)?$word:"";?>");

	//购物车div层
	$('.mycart').hover(
		function(){
			showCart('<?php echo IUrl::creatUrl("/simple/showCart");?>');
		},
		function(){
			$('#div_mycart').hide('slow');
		}
	);
});
</script>
</body>
</html>
