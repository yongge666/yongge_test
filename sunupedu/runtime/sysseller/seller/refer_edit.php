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
		<?php $id = IFilter::act(IReq::get('id'),'int')?>
<?php $query = new IQuery("refer as r");$query->join = "left join goods as goods on r.goods_id = goods.id left join user as u on r.user_id = u.id left join admin as admin on r.admin_id = admin.id left join seller as se on se.id = r.seller_id";$query->fields = "se.seller_name,r.*,u.username,goods.name as goods_name,goods.id as goods_id,admin.admin_name";$query->where = "r.id = $id";$items = $query->find(); foreach($items as $key => $item){?><?php }?>

<article class="module width_full">
	<header>
		<h3>咨询回复</h3>
	</header>

	<form action="<?php echo IUrl::creatUrl("/seller/refer_reply");?>" method="post" name="refer_edit">
		<input type="hidden" value="<?php echo isset($item['id'])?$item['id']:"";?>" name="refer_id" />

		<div class="module_content">
			<fieldset>
				<label>咨询人</label>
				<div class="box">
					<?php if(isset($item['username'])){?><a href="<?php echo IUrl::creatUrl("/member/member_edit/uid/".$item['user_id']."");?>"><?php echo isset($item['username'])?$item['username']:"";?></a><?php }else{?>非会员顾客<?php }?>
				</div>
			</fieldset>

			<fieldset>
				<label>咨询时间</label>
				<div class="box">
					<?php echo isset($item['time'])?$item['time']:"";?>
				</div>
			</fieldset>

			<fieldset>
				<label>咨询内容</label>
				<div class="box">
					<?php echo isset($item['question'])?$item['question']:"";?>
				</div>
			</fieldset>

			<fieldset>
				<label>回复</label>
				<div class="box">
					<textarea name="content" rows="" cols=""><?php echo isset($item['answer'])?$item['answer']:"";?></textarea>
				</div>
			</fieldset>
		</div>

		<footer>
			<div class="submit_link">
				<input type="submit" class="alt_btn" value="回 复" />
				<input type="reset" value="重 置" />
			</div>
		</footer>
	</form>
</article>
	</section>
	<!--主题内容 结束-->
</body>
</html>
