<?php 
	$siteConfig = new Config("site_config");
	$callback   = IReq::get('callback') ? urlencode(IFilter::act(IReq::get('callback'),'url')) : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $siteConfig->name;?></title>
	<link type="image/x-icon" href="favicon.ico" rel="icon">
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/index.css";?>" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/runtime/_systemjs/artdialog/skins/default.css" />
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/site.js";?>'></script>
</head>
<body class="second" >
	<div class="brand_list container_2">
		<div class="header">
			<h1 class="logo"><a title="<?php echo $siteConfig->name;?>" style="background:url(<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/logo.gif";?>);" href="<?php echo IUrl::creatUrl("");?>"><?php echo $siteConfig->name;?></a></h1>
			<ul class="shortcut">
				<li class="first"><a href="<?php echo IUrl::creatUrl("/ucenter/index");?>">我的账户</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/ucenter/order");?>">我的订单</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/simple/seller");?>">申请开店</a></li>
				<li><a href="<?php echo IUrl::creatUrl("/seller/index");?>">商家管理</a></li>
		   		<li class='last'><a href="<?php echo IUrl::creatUrl("/site/help_list");?>">使用帮助</a></li>
			</ul>

			<p class="loginfo">
			<?php if($this->user){?>
			<?php echo isset($this->user['username'])?$this->user['username']:"";?>您好，欢迎您来到<?php echo $siteConfig->name;?>购物！[<a href="<?php echo IUrl::creatUrl("/simple/logout");?>" class="reg">安全退出</a>]
			<?php }else{?>
			[<a href="<?php echo IUrl::creatUrl("/simple/login?callback=".$callback."");?>">登录</a><a class="reg" href="<?php echo IUrl::creatUrl("/simple/reg?callback=".$callback."");?>">免费注册</a>]
			<?php }?>
			</p>
		</div>
	    <div class="wrapper clearfix">
	<div class="position mt_10"> <span>您当前的位置：</span> <a href="<?php echo IUrl::creatUrl("");?>"> 首页</a> » 购物车</div>
	<div class="myshopping m_10">
		<ul class="order_step">
			<li class="current"><span class="first">1、查看购物车</span></li>
			<li><span>2、填写核对订单信息</span></li>
			<li class="last"><span>3、成功提交订单</span></li>
		</ul>
	</div>

	<div id="cart_prompt" class="cart_prompt f14 t_l" <?php if(empty($this->promotion)){?>style="display:none"<?php }?>>
		<p class="m_10 gray"><b class="orange">恭喜，</b>您的订单已经满足了以下优惠活动！</p>
		<?php foreach($this->promotion as $key => $item){?>
		<p class="indent blue"><?php echo isset($item['plan'])?$item['plan']:"";?>，<?php echo isset($item['info'])?$item['info']:"";?></p>
		<?php }?>
	</div>

	<table width="100%" class="cart_table m_10">
		<col width="115px" />
		<col />
		<col width="80px" />
		<col width="80px" />
		<col width="80px" />
		<col width="80px" />
		<col width="80px" />
		<col width="80px" />
		<caption>查看购物车</caption>
		<thead>
			<tr><th>图片</th><th>商品名称</th><th>赠送积分</th><th>单价</th><th>优惠</th><th>数量</th><th>小计</th><th class="last">操作</th></tr>
		</thead>
		<tbody>
			<?php foreach($this->goodsList as $key => $item){?>
			<?php $type=isset($item['spec_array'])?'product':'goods'?>
			<?php $item['id']=isset($item['spec_array'])?$item['product_id']:$item['goods_id']?>
			<tr>
				<td><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/66/h/66");?>" width="66px" height="66px" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></td>
				<td class="t_l">
					<a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['goods_id']."");?>" class="blue"><?php echo isset($item['name'])?$item['name']:"";?></a>
					<?php if(isset($item['spec_array'])){?>
					<p>
					<?php $spec_array=Block::show_spec($item['spec_array']);?>
					<?php foreach($spec_array as $specName => $specValue){?>
						<?php echo isset($specName)?$specName:"";?>：<?php echo isset($specValue)?$specValue:"";?> &nbsp&nbsp
					<?php }?>
					</p>
					<?php }?>
				</td>
				<td><?php echo isset($item['point'])?$item['point']:"";?></td>
				<td><b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></td>
				<td>减￥<?php echo isset($item['reduce'])?$item['reduce']:"";?></td>
				<td>
					<div class="num">
						<?php $item_json = JSON::encode($item)?>
						<a class="reduce" href="javascript:void(0)" onclick='cart_reduce("<?php echo isset($type)?$type:"";?>",<?php echo isset($item_json)?$item_json:"";?>);'>-</a>
						<input class="tiny" value="<?php echo isset($item['count'])?$item['count']:"";?>" onblur='cartCount("<?php echo isset($type)?$type:"";?>",<?php echo isset($item_json)?$item_json:"";?>);' type="text" id="<?php echo isset($type)?$type:"";?>_count_<?php echo isset($item['id'])?$item['id']:"";?>" />
						<a class="add" href="javascript:void(0)" onclick='cart_increase("<?php echo isset($type)?$type:"";?>",<?php echo isset($item_json)?$item_json:"";?>);'>+</a>
					</div>
				</td>
				<td>￥<b class="red2" id="<?php echo isset($type)?$type:"";?>_sum_<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['sum'])?$item['sum']:"";?></b></td>
				<td><a href="<?php echo IUrl::creatUrl("/simple/removeCart/link/cart/type/".$type."/goods_id/".$item['id']."");?>">删除</a></td>
			</tr>
			<?php }?>

			<tr class="stats">
				<td colspan="8">
					<span>商品总重量：<b id='weight'><?php echo isset($this->weight)?$this->weight:"";?></b>g</span><span>商品总金额：￥<b id='origin_price'><?php echo isset($this->sum)?$this->sum:"";?></b> - 商品优惠：￥<b id='discount_price'><?php echo isset($this->reduce)?$this->reduce:"";?></b> - 促销活动优惠：￥<b id='promotion_price'><?php echo isset($this->proReduce)?$this->proReduce:"";?></b></span><br />
					金额总计（不含运费）：￥<b class="orange" id='sum_price'><?php echo isset($this->final_sum)?$this->final_sum:"";?></b>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2" class="t_l">
					<?php if($this->user['user_id']){?>
					<a class="file" href="<?php echo IUrl::creatUrl("/simple/deposit_cart_set");?>">寄存购物车</a>
					<a class="file" href="javascript:deposit_cart_get();">取出购物车</a>
					<a class="file" href="javascript:void(0)" onclick="delModel({msg:'确定要清空寄存购物车么？',link:'<?php echo IUrl::creatUrl("/simple/deposit_cart_clear");?>'});">清空寄存购物车</a>
					<?php }?>
					<a class="del" href="javascript:void(0);" onclick="delModel({msg:'确定要清空购物车么？',link:'<?php echo IUrl::creatUrl("/simple/clearCart");?>'});">清空购物车</a>
				</td>
				<td colspan="6" class="t_r">
					<?php $callback = IFilter::act(IReq::get('callback'),'text');?>
					<a class="btn_continue" href="<?php echo IUrl::creatUrl("".$callback."");?>">继续购物</a>
					<?php if($this->goodsList){?>
					<a class="btn_pay" href="javascript:check_finish();">去结算</a>
					<?php }?>
				</td>
			</tr>
		</tfoot>
	</table>

	<div class="box"><div class="title">热门商品推荐</div></div>
		<ul id="scrollpic" class="prolist">
			<?php foreach(Api::run('getCommendHot',5) as $key => $item){?>
			<li>
				<a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>">
					<img width="98px" height="106px" src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/98/h/106");?>" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>">
				</a>
				<p class="pro_title"><a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>">"<?php echo isset($item['name'])?$item['name']:"";?>"</a></p>
				<p class="brown"><b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></p>
				<label class="btn_orange2"><input type="submit" onclick="window.location.href='<?php echo IUrl::creatUrl("/simple/joinCart/link/cart/type/goods/goods_id/".$item['id']."");?>';" value="加入购物车"></label>
			</li>
			<?php }?>
		</ul>
</div>

<script type='text/javascript'>
//购物车数量改动计算
function cartCount(type,obj,oldCount)
{
	var countInput    = $('#'+type+'_count_'+obj.id);
	var countInputVal = parseInt(countInput.val());

	//商品数量大于1件
	if(isNaN(countInputVal) || (countInputVal <= 0))
	{
		alert('购买的数量必须大于1件');
		countInput.val(1);
		cartCount(type,obj,oldCount);
	}

	//商品数量小于库存量
	else if(countInputVal > parseInt(obj.store_nums))
	{
		alert('购买的数量不能大于此商品的库存量');
		countInput.val(parseInt(obj.store_nums));
		cartCount(type,obj,oldCount);
	}
	else
	{
		//修改按钮状态
		countInput.attr('disabled',true);
		$('.btn_pay').val('wait');

		//获取之前的购买数量
		if(oldCount == undefined)
		{
			oldCount = countInput.data('oldCount') ? parseInt(countInput.data('oldCount')) : parseInt(obj.count);
		}

		//修改的购买数量
		var changeNum = parseInt(countInput.val()) - oldCount;

		//商品数量没有改动
		if(changeNum == 0)
		{
			//修改按钮状态
			countInput.attr('disabled',false);
			$('.btn_pay').val('ok');
			return '';
		}

		//更新购物车中此商品的数量
		$.getJSON("<?php echo IUrl::creatUrl("/simple/joinCart");?>",{"type":type,"goods_id":obj.id,"goods_num":changeNum,"random":Math.random()},function(content){
			if(content.isError == true)
			{
				alert(content.message);
				var countInput = $('#'+type+'_count_'+obj.id);

				//上次数量回填
				if(changeNum < 0)
				{
					countInput.val(parseInt(countInput.val() - changeNum));
				}
				else
				{
					countInput.val(parseInt(countInput.val() + changeNum));
				}

				//修改按钮状态
				countInput.attr('disabled',false);
				$('.btn_pay').val('ok');
			}
			else
			{
				var countInput = $('#'+type+'_count_'+obj.id);

				//缓存旧的购买数量
				countInput.data('oldCount',parseInt(countInput.val()));

				/*变动的价格可能为负数(减少购买量)*/
				var smallSumC   = (mathSub(parseFloat(obj.sell_price),parseFloat(obj.reduce))) * changeNum; //价格变动
				var weightC     = mathMul(parseFloat(obj.weight),changeNum);       //重量变动
				var originC     = mathMul(parseFloat(obj.sell_price),changeNum);   //原始价格变动
				var discountC   = mathMul(parseFloat(obj.reduce),changeNum);       //优惠变动

				/*开始更新数据(1)*/

				//商品小结计算
				var smallSum    = $('#'+type+'_sum_'+obj.id);
				smallSum.html(mathAdd(parseFloat(smallSum.text()),smallSumC));

				//最终重量
				$('#weight').html(mathAdd(parseFloat($('#weight').text()),weightC));

				//原始金额
				$('#origin_price').html(mathAdd(parseFloat($('#origin_price').text()),originC));

				//优惠价
				$('#discount_price').html(mathAdd(parseFloat($('#discount_price').text()),discountC));

				//促销规则检测
				var final_sum   = mathSub(parseFloat($('#origin_price').text()),parseFloat($('#discount_price').text()));
				var tmpUrl = '<?php echo IUrl::creatUrl("/simple/promotionRuleAjax/random/@random@");?>';
				tmpUrl = tmpUrl.replace("@random@",Math.random());
				$.getJSON( tmpUrl ,{final_sum:final_sum},function(content){
					if(content.promotion.length > 0)
					{
						$('#cart_prompt .indent').remove();

						for(var i = 0;i < content.promotion.length; i++)
						{
							$('#cart_prompt').append('<p class="indent blue">'+content.promotion[i].plan+'，'+content.promotion[i].info+'</p>');
						}
						$('#cart_prompt').show();
					}
					else
					{
						$('#cart_prompt .indent').remove();
						$('#cart_prompt').hide();
					}
					/*开始更新数据 (2)*/

					//促销活动
					$('#promotion_price').html(content.proReduce);

					//最终金额
					$('#sum_price').html(mathSub(mathSub(parseFloat($('#origin_price').text()),parseFloat($('#discount_price').text())),parseFloat($('#promotion_price').text())));

					//修改按钮状态
					countInput.attr('disabled',false);
					$('.btn_pay').val('ok');
				});
			}
		});
	}
}

//增加商品数量
function cart_increase(type,obj)
{
	//库存超量检查
	var countInput = $('#'+type+'_count_'+obj.id);
	var oldCount   = parseInt(countInput.val());
	if(parseInt(countInput.val()) + 1 > parseInt(obj.store_nums))
	{
		alert('购买的数量大于此商品的库存量');
	}
	else
	{
		if(countInput.attr('disabled') == true)
		{
			return false;
		}
		else
		{
			countInput.attr('disabled',true);
		}
		countInput.val(parseInt(countInput.val()) + 1);
		cartCount(type,obj,oldCount);
	}
}

//减少商品数量
function cart_reduce(type,obj)
{
	//库存超量检查
	var countInput = $('#'+type+'_count_'+obj.id);
	var oldCount   = parseInt(countInput.val());
	if(parseInt(countInput.val()) - 1 <= 0)
	{
		alert('购买的数量必须大于1件');
	}
	else
	{
		if(countInput.attr('disabled') == true)
		{
			return false;
		}
		else
		{
			countInput.attr('disabled',true);
		}
		countInput.val(parseInt(countInput.val()) - 1);
		cartCount(type,obj,oldCount);
	}
}

//检测购买完成量
function check_finish()
{
	if($.trim($('.btn_pay').val()) == 'wait')
	{
		window.setInterval("check_finish()", 400);
	}
	else
	{
		window.location.href = '<?php echo IUrl::creatUrl("/simple/cart2");?>';
	}
}

/**
 * 读取购物车
 */
function deposit_cart_get()
{
	$.getJSON('<?php echo IUrl::creatUrl("/simple/deposit_cart_get");?>',{"random":Math.random()},function(json)
	{
		if(json.isError == 1)
		{
			alert('读取购物车失败');
			return;
		}
		//页面刷新
		window.location.reload();
	});
}
</script>

<!--滑动门-->
<link rel="stylesheet" type="text/css" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.bxSlider/jquery.bxslider.css";?>" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.bxSlider/jquery.bxSlider.min.js";?>"></script>
<script type="text/javascript">
jQuery(function(){
	$('#scrollpic').bxSlider({controls:false,minSlides: 5,slideWidth: 180,maxSlides: 5,pager:false});
});
</script>
		<?php echo IFilter::stripSlash($siteConfig->site_footer_code);?>
	</div>
</body>
</html>
