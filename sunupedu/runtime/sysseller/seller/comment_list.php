<?php $seller_id = $this->seller['seller_id'];$seller_name = $this->seller['seller_name'];?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>商家管理后台</title>
	<link type="image/x-icon" href="favicon.ico" rel="icon">
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
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
		<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/my97date/wdatepicker.js"></script>
<?php $seller_id = $this->seller['seller_id']?>
<?php $condition = Util::search(IReq::get('search'));$where = $condition ? " and ".$condition : "";?>

<article class="module width_full">
	<header>
		<h3 class="tabs_involved">商品评价列表</h3>

		<ul class="tabs">
			<li><input type="button" class="alt_btn" onclick="filterResult();" value="检索" /></li>
		</ul>
	</header>

	<table class="tablesorter" cellspacing="0">
		<colgroup>
			<col width="140px" />
			<col />
			<col width="160px" />
			<col width="140px" />
			<col width="85px" />
		</colgroup>

		<thead>
			<tr>
				<th>评价人</th>
				<th>评价商品</th>
				<th>评价时间</th>
				<th>状态</th>
				<th>操作</th>
			</tr>
		</thead>

		<tbody>
			<?php $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;?>
			<?php $query = new IQuery("comment as c");$query->join = "left join goods as goods on c.goods_id = goods.id left join user as u on c.user_id = u.id";$query->fields = "c.*,u.username,goods.id as goods_id,goods.name as goods_name";$query->page = "$page";$query->where = "c.status = 1 and goods.seller_id = $seller_id $where";$query->order = "c.id desc";$items = $query->find(); foreach($items as $key => $item){?>
			<tr>
				<td><?php echo isset($item['username'])?$item['username']:"";?></td>
				<td><a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['goods_id']."");?>" target="_blank"><?php echo isset($item['goods_name'])?$item['goods_name']:"";?></a></td>
				<td><?php echo isset($item['time'])?$item['time']:"";?></td>
				<td><?php echo $item['recontents'] ? "已回复":"未回复";?></td>
				<td><a href="<?php echo IUrl::creatUrl("/seller/comment_edit/cid/".$item['id']."");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/main/icn_settings.png";?>" alt="查看" /></a></td>
			</tr>
			<?php }?>
		</tbody>
	</table>
	<?php echo $query->getPageBar();?>
</article>

<script type="text/html" id="filterTemplate">
<form action="<?php echo IUrl::creatUrl("/");?>" method="get" name="filterForm">
	<input type='hidden' name='controller' value='seller' />
	<input type='hidden' name='action' value='comment_list' />
	<div class="module_content">
		<fieldset>
			<select name="search[like]">
				<option value="u.username">评价人</option>
				<option value="goods.name">评价商品</option>
				<option value="c.order_no">订单号</option>
			</select>
			<input name="search[likeValue]" value="" type="text" />
		</fieldset>
		<fieldset>
			<label>开始时间：</label>
			<input type="text" name="search[time>=]" onfocus="WdatePicker()" />
		</fieldset>
		<fieldset>
			<label>截止时间：</label>
			<input type="text" name="search[time<=]" onfocus="WdatePicker()" />
		</fieldset>
		<fieldset>
			<label>回复状态：</label>
			<select name="search[status=]">
				<option value="">不限</option>
				<option value="0">未回复</option>
				<option value="1">已回复</option>
			</select>
		</fieldset>
    </div>
</form>
</script>

<script type="text/javascript">
//检索商品
function filterResult()
{
	var filterTemplate = template.render('filterTemplate');
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
		"content":filterTemplate,
		"okVal":"立即检索",
		"ok":function(iframeWin, topWin)
		{
			iframeWin.document.forms[0].submit();
		}
	});
}
</script>

	</section>
	<!--主题内容 结束-->
</body>
</html>