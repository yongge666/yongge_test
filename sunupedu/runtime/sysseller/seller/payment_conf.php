<?php $seller_id = $this->seller['seller_id'];$seller_name = $this->seller['seller_name'];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>商家管理后台</title>
	<link type="image/x-icon" href="favicon.ico" rel="icon">
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
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
			<p>Powered by <a href="<?php echo BASE_URL; ?>">尚普商城</a></p>
		</footer>
	</aside>
	<!--侧边栏菜单 结束-->

	<!--主体内容 开始-->
	<section id="main" class="column">
		<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/artTemplate/area_select.js";?>'></script>

<article class="module width_full">
	<header>
		<h3>编辑商户收款信息 ( 只支持支付宝,金额将会直接支付到该商家账号 )</h3>
	</header>

	<form action="<?php echo IUrl::creatUrl("/seller/payment_conf_save");?>" method="post" name="paymentForm" enctype='multipart/form-data'>
		<div class="module_content">
	 
			<!-- <fieldset>
				<label>合作者身份（PID,以2088开头的16位纯数字）:</label>
				<input name="parent_id" type="text" value="" pattern="required"  />
			</fieldset>
			
			<fieldset>
				<label>安全校验码（Key,以数字和字母组成的32位字符）:</label>
				<input name="parent_key" type="text" value="" pattern="required"  />
			</fieldset> -->
			
			<fieldset>
				<label>收款账户 (Email或者手机号,收款支付宝账号) :</label>
				<input name="parent_email" type="text" value="" pattern="required"  />
			</fieldset>
 

		<footer>
			<div class="submit_link">
				<input type="submit" class="alt_btn" value="确 定" />
				<input type="reset" value="重 置" />
			</div>
		</footer>
	</form>
</article>

<script language="javascript">
//DOM加载完毕
$(function(){
	//修改模式
	<?php if(isset($this->paymentRow)){?>
		var formObj = new Form('paymentForm');
		formObj.init(<?php echo JSON::encode($this->paymentRow);?>);
	<?php }?>
});

 
</script>

	</section>
	<!--主题内容 结束-->
</body>
</html>
