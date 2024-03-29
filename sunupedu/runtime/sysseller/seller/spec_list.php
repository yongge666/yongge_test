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
		<?php $seller_id = $this->seller['seller_id']?>
<article class="module width_full">
	<header>
		<h3 class="tabs_involved">规格列表</h3>

		<ul class="tabs">
			<li><input type="button" class="alt_btn" onclick="addNewSpec();" value="添加规格" /></li>
			<li><input type="button" class="alt_btn" onclick="selectAll('id[]')" value="全选" /></li>
			<li><input type="button" class="alt_btn" onclick="delModel();" value="批量删除" /></li>
		</ul>
	</header>

	<form action='<?php echo IUrl::creatUrl("/seller/spec_del");?>' method='post' name='specForm'>
		<table class="tablesorter" cellspacing="0">
			<colgroup>
				<col width="40px" />
				<col width="150px" />
				<col width="80px" />
				<col />
				<col width="100px" />
			</colgroup>

			<thead>
				<tr>
					<th class="header"></th>
					<th class="header">规格名称</th>
					<th class="header">显示方式</th>
					<th class="header">规格数据</th>
					<th class="header">操作</th>
				</tr>
			</thead>

			<tbody>
				<?php $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;?>
				<?php $query = new IQuery("spec");$query->where = "is_del = 0 and seller_id = $seller_id";$query->order = "id desc";$query->page = "$page";$items = $query->find(); foreach($items as $key => $item){?>
				<tr>
					<td><input type="checkbox" name="id[]" value="<?php echo isset($item['id'])?$item['id']:"";?>" /></td>
					<td><?php echo isset($item['name'])?$item['name']:"";?><?php echo $item['note']?"【".$item['note']."】":"";?></td>
					<td><?php if($item['type']==1){?>文字<?php }else{?>图片<?php }?></td>
					<td>
						<?php foreach(JSON::decode($item['value']) as $key => $rs){?>
							<?php if($item['type']==1){?>
							<?php echo isset($rs)?$rs:"";?>,
							<?php }else{?>
							<img class="spec_photo" src=<?php echo IUrl::creatUrl("")."".$rs."";?> />
							<?php }?>
						<?php }?>
					</td>
					<td>
						<a href="javascript:addNewSpec(<?php echo isset($item['id'])?$item['id']:"";?>);"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/main/icn_edit.png";?>" alt="修改" /></a>
						<a href='javascript:void(0)' onclick="delModel({link:'<?php echo IUrl::creatUrl("/seller/spec_del/id/".$item['id']."");?>'});"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/main/icn_del.png";?>" alt="删除" title="删除" /></a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</form>
	<?php echo $query->getPageBar();?>
</article>

<script type='text/javascript'>
//添加新规格
function addNewSpec(spec_id)
{
	var url = '<?php echo IUrl::creatUrl("/goods/spec_edit/id/@spec_id@/seller_id/".$seller_id."");?>';
	url = url.replace('@spec_id@',spec_id?spec_id:0);

	art.dialog.open(url,{
		id:'addSpecWin',
	    title:'规格设置',
	    okVal:'确定',
	    ok:function(iframeWin, topWin){
	    	var formObject = iframeWin.document.forms['specForm'];
			$.post(formObject.action,$(formObject).serialize(),function(json){
				if(json.flag == 'success')
				{
					window.location.reload();
					return true;
				}
				else
				{
					alert(json.message);
					return false;
				}
			},'json');
	    }
	});
}
</script>
	</section>
	<!--主题内容 结束-->
</body>
</html>
