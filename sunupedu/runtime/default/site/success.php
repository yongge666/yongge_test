<?php 
	$myCartObj  = new Cart();
	$myCartInfo = $myCartObj->getMyCart();
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
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/site.js";?>'></script>
	<?php $sonline = new Sonline();$sonline->show($siteConfig->phone,$siteConfig->service_online);?>
</head>
<body class="index">
<div class="container">
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
			<?php echo $this->user['username'];?>您好，欢迎您来到<?php echo $siteConfig->name;?>购物！[<a href="<?php echo IUrl::creatUrl("/simple/logout");?>" class="reg">安全退出</a>]
			<?php }else{?>
			[<a href="<?php echo IUrl::creatUrl("/simple/login?callback=".$callback."");?>">登录</a><a class="reg" href="<?php echo IUrl::creatUrl("/simple/reg?callback=".$callback."");?>">免费注册</a>]
			<?php }?>
		</p>
	</div>
	<div class="navbar">
		<ul>
			<li><a href="<?php echo IUrl::creatUrl("/site/index");?>">首页</a></li>
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
			<a href="javascript:void(0);">全部商品分类</a>

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
	<?php echo Ad::show(1);?>

	<div class="wrapper clearfix">
	<div class="wrap_box">
		<div class="error box clearfix">
			<table class="form_table prompt_3">
				<colgroup>
					<col width="320px" />
					<col />
				</colgroup>

				<tbody>
					<tr>
						<th><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/right.gif";?>" width="48px" height="51px" /></th>
						<td>
							<strong class="f14">
							<?php echo IReq::get('message') ? IFilter::act(IReq::get('message'),'text') : '操作成功！';?>
							</strong>
						</td>
					</tr>

					<tr>
						<th></th>
						<td>
							您现在可以去：
							<?php $callback = IFilter::act(IReq::get('callback'),'text')?>
							<?php if($callback){?>
							<a class="blue" href="<?php echo IUrl::creatUrl("".$callback."");?>">继续操作 >></a>
							<?php }?>

							<?php if($this->user['user_id']){?>
							<a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/index");?>">个人中心 >></a>
							<?php }?>

							<?php $email = IFilter::act(IReq::get('email'))?>
							<?php if($email){?>
							<a class="blue" href="<?php echo IUrl::creatUrl("/simple/send_check_mail/email/".$email."");?>">重新发送验证邮件 >></a>
							<?php }?>

							<a class="blue" href="<?php echo IUrl::creatUrl("/site/index");?>">网站首页 >></a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
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
$(function()
{
	<?php $word = IReq::get('word') ? IFilter::act(IReq::get('word'),'text') : '输入关键字...'?>
	$('input:text[name="word"]').val("<?php echo isset($word)?$word:"";?>");

	$('input:text[name="word"]').bind({
		keyup:function(){autoComplete('<?php echo IUrl::creatUrl("/site/autoComplete");?>','<?php echo IUrl::creatUrl("/site/search_list/word/@word@");?>','<?php echo isset($siteConfig->auto_finish)?$siteConfig->auto_finish:"";?>');}
	});

	var mycartLateCall = new lateCall(200,function(){showCart('<?php echo IUrl::creatUrl("/simple/showCart");?>')});

	//购物车div层
	$('.mycart').hover(
		function(){
			mycartLateCall.start();
		},
		function(){
			mycartLateCall.stop();
			$('#div_mycart').hide('slow');
		}
	);
});

//[ajax]加入购物车
function joinCart_ajax(id,type)
{
	$.getJSON("<?php echo IUrl::creatUrl("/simple/joinCart");?>",{"goods_id":id,"type":type,"random":Math.random()},function(content){
		if(content.isError == false)
		{
			var count = parseInt($('[name="mycart_count"]').html()) + 1;
			$('[name="mycart_count"]').html(count);
			alert(content.message);
		}
		else
		{
			alert(content.message);
		}
	});
}

//列表页加入购物车统一接口
function joinCart_list(id)
{
	$.getJSON('<?php echo IUrl::creatUrl("/simple/getProducts");?>',{"id":id},function(content){
		if(!content)
		{
			joinCart_ajax(id,'goods');
		}
		else
		{
			var url = "<?php echo IUrl::creatUrl("/block/goods_list/goods_id/@goods_id@/type/radio/is_products/1");?>";
			url = url.replace('@goods_id@',id);
			artDialog.open(url,{
				id:'selectProduct',
				title:'选择货品到购物车',
				okVal:'加入购物车',
				ok:function(iframeWin, topWin)
				{
					var goodsList = $(iframeWin.document).find('input[name="id[]"]:checked');

					//添加选中的商品
					if(goodsList.length == 0)
					{
						alert('请选择要加入购物车的商品');
						return false;
					}
					var temp = $.parseJSON(goodsList.attr('data'));

					//执行处理回调
					joinCart_ajax(temp.product_id,'product');
					return true;
				}
			})
		}
	});
}
</script>
</body>
</html>
