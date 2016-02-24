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
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL;?>/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
        <script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/artTemplate/area_select.js";?>'></script>
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
                
                <!--地址选择弹窗开始-->
                <div id="address_select" style="display: none">
                    <form action="<?php echo IUrl::creatUrl("/site/pro_list");?>"  method="post">
                        <tr>
                            <th>选择学生学校地址：</th>
                            <td>
                                <select  style="width:70px" name="province" child="city,area,school" onchange="areaChangeCallback(this);"></select>
                                <select  style="width:70px" name="city" child="area,school" parent="province" onchange="areaChangeCallback(this);"></select>
                                <select  style="width:70px" name="area" child="school" parent="city"   onchange="areaChangeCallback(this);"></select>
                                <select  style="width:100px" name="school" parent="area" pattern="required"></select>
                            </td>
                        </tr>
                    </form>

                </div>
                 <!--地址选择弹窗结束-->
                

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

	<?php $seo_data=array(); $site_config=new Config('site_config');?>
<?php $seo_data['title'] = $this->catRow['title']?$this->catRow['title']:$this->catRow['name']?>
<?php $seo_data['title'].="_".$site_config->name?>
<?php $seo_data['keywords']=$this->catRow['keywords']?>
<?php $seo_data['description']=$this->catRow['descript']?>
<?php seo::set($seo_data);?>
<?php $breadGuide = goods_class::catRecursion($this->catId)?>
<?php $goodsObj = search_goods::find(array('category_extend' => $this->childId));$resultData1 = $goodsObj->find();?>
<?php $resultData = $this->resultData?>
<div class="position">
	<span>您当前的位置：</span>
	<a href="<?php echo IUrl::creatUrl("");?>">首页</a><?php foreach($breadGuide as $key => $item){?> » <a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$item['id']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a><?php }?>
</div>

<div class="wrapper clearfix container_2">
	<div class="sidebar f_l">
		<!--侧边栏分类-->
		<?php $catSide = goods_class::catTree($this->catId)?>
		<?php if($catSide){?>
		<div class="box_2 m_10">
			<div class="title"><?php echo isset($this->catRow['name'])?$this->catRow['name']:"";?></div>
			<div class="content">
				<?php foreach($catSide as $key => $first){?>
				<dl class="clearfix">
					<dt><a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$first['id']."");?>"><?php echo isset($first['name'])?$first['name']:"";?></a></dt>
					<?php foreach(Api::run('getCategoryByParentid',array('#parent_id#',$first['id'])) as $key => $second){?>
					<dd><a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$second['id']."");?>"><?php echo isset($second['name'])?$second['name']:"";?></a></dd>
					<?php }?>
				</dl>
				<?php }?>
			</div>
		</div>
		<?php }?>
		<!--侧边栏分类-->
	</div>

	<div class="main f_r">
		<!--推荐商品-->
                <!--
		<?php $pro_list = Api::run('getCategoryExtendByCommendid',array('#childId#',$this->childId))?>
	  	<?php if($pro_list){?>
		<div class="brown_box m_10 clearfix">
			<p class="caption"><span>推荐</span></p>

			<ul class="prolist">
				<?php foreach($pro_list as $key => $item){?>
				<li>
					<a class="pic" href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/85/h/85");?>" alt="<?php echo isset($item['name'])?$item['name']:"";?>" height="85px" width="85px"></a>
					<p class="pro_title"><a class="blue" href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a><span class="gray"><?php echo isset($item['description'])?$item['description']:"";?></span></p>
					<p><b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b> <s>￥<?php echo isset($item['market_price'])?$item['market_price']:"";?></s></p>
				</li>
				<?php }?>
			</ul>
		</div>
		<?php }?>
                -->
		<!--推荐商品-->

		<!--商品条件检索-->
		<div class="box m_10">
			<div class="title"><?php echo isset($this->catRow['name'])?$this->catRow['name']:"";?></div>
			<div class="cont">

				<!--品牌展示-->
				<?php $brandList = search_goods::$brandSearch?>
				<?php if($brandList){?>
				<dl class="sorting">
					<dt>品牌：</dt>
					<dd id='brand_dd'>
						<a class="nolimit current" href="<?php echo search_goods::searchUrl('brand','');?>">不限</a>
						<?php foreach($brandList as $key => $item){?>
						<a href="<?php echo search_goods::searchUrl('brand',$item['id']);?>" id='brand_<?php echo isset($item['id'])?$item['id']:"";?>'><?php echo isset($item['name'])?$item['name']:"";?></a>
						<?php }?>
					</dd>
				</dl>
				<?php }?>
				<!--品牌展示-->

				<!--商品属性-->
				<?php foreach(search_goods::$attrSearch as $key => $item){?>
				<dl class="sorting">
					<dt><?php echo isset($item['name'])?$item['name']:"";?>：</dt>
					<dd id='attr_dd_<?php echo isset($item['id'])?$item['id']:"";?>'>
						<a class="nolimit current" href="<?php echo search_goods::searchUrl('attr['.$item["id"].']','');?>">不限</a>
						<?php foreach($item['value'] as $key => $attr){?>
						<a href="<?php echo search_goods::searchUrl('attr['.$item["id"].']',$attr);?>" id="attr_<?php echo isset($item['id'])?$item['id']:"";?>_<?php echo md5($attr);?>"><?php echo isset($attr)?$attr:"";?></a>
						<?php }?>
					</dd>
				</dl>
				<?php }?>
				<!--商品属性-->

				<!--商品价格-->
				<dl class="sorting">
					<dt>价格：</dt>
					<dd id='price_dd'>
						<p class="f_r"><input type="text" class="mini" name="min_price" value="<?php echo IFilter::act(IReq::get('min_price'),'url');?>" onchange="checkPrice(this);"> 至 <input type="text" class="mini" name="max_price" onchange="checkPrice(this);" value="<?php echo IFilter::act(IReq::get('max_price'),'url');?>"> 元
						<label class="btn_gray_s"><input type="button" onclick="priceLink();" value="确定"></label></p>
						<a class="nolimit current" href="<?php echo search_goods::searchUrl(array('min_price','max_price'),'');?>">不限</a>
						<?php foreach(search_goods::$priceSearch as $key => $item){?>
						<?php $priceZone = explode('-',$item)?>
						<a href="<?php echo search_goods::searchUrl(array('min_price','max_price'),array($priceZone[0],$priceZone[1]));?>" id="<?php echo isset($priceZone[0])?$priceZone[0]:"";?>-<?php echo isset($priceZone[1])?$priceZone[1]:"";?>"><?php echo isset($item)?$item:"";?></a>
						<?php }?>
					</dd>
				</dl>
				<!--商品价格-->
			</div>
		</div>
		<!--商品条件检索-->

		<!--商品列表展示-->
		<div class="display_title">
			<span class="l"></span>
			<span class="r"></span>
			<span class="f_l">排序：</span>
			<ul>
				<?php foreach(search_goods::getOrderType() as $key => $item){?>
				<?php $next = search_goods::getOrderValue($key)?>
				<li class="<?php echo search_goods::isOrderCurrent($key) ? 'current':'';?>">
					<span class="l"></span><span class="r"></span>
					<a href="<?php echo search_goods::searchUrl('order',$next);?>"><?php echo isset($item)?$item:"";?><span class="<?php echo search_goods::isOrderDesc() ? 'desc':'';?>">&nbsp;</span></a>
				</li>
				<?php }?>
			</ul>
			<span class="f_l">显示方式：</span>
			<a class="show_b" href="<?php echo search_goods::searchUrl('show_type','win');?>" title='橱窗展示' alt='橱窗展示'><span class='<?php echo search_goods::getListShow(IReq::get('show_type')) == 'win' ? 'current':'';?>'></span></a>
			<a class="show_s" href="<?php echo search_goods::searchUrl('show_type','list');?>" title='列表展示' alt='列表展示'><span class='<?php echo search_goods::getListShow(IReq::get('show_type')) == 'list' ? 'current':'';?>'></span></a>
		</div>

		<?php if($resultData){?>
		<?php $listSize = search_goods::getListSize(IFilter::act(IReq::get('show_type')))?>
		<ul class="display_list clearfix m_10">
			<?php foreach($resultData as $key => $item){?>

                         <?php if((isset($item['area']))){?>
卖家区域是：              <?php echo isset($item['area'])?$item['area']:"";?>

                          <?php }?>

			<li class="clearfix <?php echo search_goods::getListShow(IFilter::act(IReq::get('show_type')));?>">
				<div class="pic">
					<a title="<?php echo isset($item['name'])?$item['name']:"";?>" href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/".$listSize['width']."/h/".$listSize['height']."");?>" width="<?php echo isset($listSize['width'])?$listSize['width']:"";?>" height="<?php echo isset($listSize['height'])?$listSize['height']:"";?>" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
				</div>
				<h3 class="title"><a title="<?php echo isset($item['name'])?$item['name']:"";?>" class="p_name" href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a><span>总销量：<?php echo isset($item['sale'])?$item['sale']:"";?><a class="blue" href="<?php echo IUrl::creatUrl("/site/comments_list/id/".$item['id']."");?>">( <?php echo isset($item['comments'])?$item['comments']:"";?>人评论 )</a></span><span class='grade'><i style='width:<?php echo Common::gradeWidth($item['grade'],$item['comments']);?>px'></i></span></h3>


	<div class="handle">
				

				<?php if(empty($item['seller_id'])){?>
					<label class="btn_gray_m"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/ucenter/shopping.gif";?>" width="15" height="15" /><input type="button" value="加入购物车" onclick="joinCart_list(<?php echo isset($item['id'])?$item['id']:"";?>);"></label>
				<?php }?>
					<label class="btn_gray_m"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/ucenter/favorites.gif";?>" width="15" height="14" /><input type="button" value="收藏" onclick="favorite_add_ajax('<?php echo IUrl::creatUrl("/simple/favorite_add");?>','<?php echo isset($item['id'])?$item['id']:"";?>',this);"></label>
				
				</div>
				<div class="price">￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?><s>￥<?php echo isset($item['market_price'])?$item['market_price']:"";?></s></div>
			</li>
			<?php }?>
		</ul>
		<?php echo $goodsObj->getPageBar();?>

		<?php }else{?>
		<p class="display_list mt_10" style='margin-top:50px;margin-bottom:50px'>
			<strong class="gray f14">对不起，没有找到相关商品</strong>
		</p>
		<?php }?>
		<!--商品列表展示-->

	</div>
</div>

<script type='text/javascript'>
//价格跳转
function priceLink()
{
	var minVal = $('[name="min_price"]').val();
	var maxVal = $('[name="max_price"]').val();
	if(isNaN(minVal) || isNaN(maxVal))
	{
		alert('价格填写不正确');
		return '';
	}
	var urlVal = "<?php echo IFilter::act(preg_replace('|&min_price=\w*&max_price=\w*|','',search_goods::searchUrl(array('min_price','max_price'),'')),'url');?>";
	window.location.href=urlVal+'&min_price='+minVal+'&max_price='+maxVal;
}

//价格检查
function checkPrice(obj)
{
	if(isNaN(obj.value))
	{
		obj.value = '';
	}
}

//筛选条件按钮高亮
jQuery(function(){
	<?php 
		$brand = IFilter::act(IReq::get('brand'),'int');
	?>

	<?php if($brand){?>
	$('#brand_dd>a').removeClass('current');
	$('#brand_<?php echo isset($brand)?$brand:"";?>').addClass('current');
	<?php }?>

	<?php $tempArray = IFilter::act(IReq::get('attr'),'url')?>
	<?php if($tempArray){?>
		<?php $json = JSON::encode(array_map('md5',$tempArray))?>
		var attrArray = <?php echo isset($json)?$json:"";?>;
		for(val in attrArray)
		{
			if(attrArray[val])
			{
				$('#attr_dd_'+val+'>a').removeClass('current');
				document.getElementById('attr_'+val+'_'+attrArray[val]).className = 'current';
			}
		}
	<?php }?>

	<?php if(IReq::get('min_price') != ''){?>
	$('#price_dd>a').removeClass('current');
	$('#<?php echo IReq::get('min_price');?>-<?php echo IReq::get('max_price');?>').addClass('current');
	<?php }?>
});
</script>

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

        //地址选择弹窗
        $('#div_allsort .sublist').on('click','dd',function(event){
            var GetUrl = $(this).find('a').attr('href');
            event.preventDefault();
            isLogin();
            //已登录用户直接跳转
            if(userId !='false'){
                window.location = GetUrl;
                return false;
            }
            
            art.dialog({
                width:600,
                height:150,
                lock: true,
                title: '请选择所在区域',
                content:document.getElementById('address_select'),
                okVal:'提交',
                cancelVal:'关闭',
                ok: function () {
                    //var oform = $('#address_select form').get(0);
                    var prolistUrl = GetUrl+'&'+$('#address_select form').serialize();
                    //oform.submit();
                    //alert(prolistUrl);
                    //跳转页面
                    window.location = prolistUrl;
                   /*
                      $.ajax({
                        type: 'GET',
                        url: prolistUrl,
                        success: function(res) {
                           alert(res);
                                
                        }
                    });
                    */
                    
//                    $.getJSON(prolistUrl,function(json){
//                        
//                        alert(json);
//                    });
                    
                    
                  return false;
                },
                cancel: function () {
                }
                
                });
            
            return false;
        });
        
        $('.prolist').on('click','li',function(event){
            var GetUrl = $(this).find('a').attr('href');
            event.preventDefault();
            isLogin();
            //已登录用户直接跳转
            if(userId !='false'){
                window.location = GetUrl;
                return false;
            }
            
            art.dialog({
                width:600,
                height:150,
                lock: true,
                title: '请选择所在区域',
                content:document.getElementById('address_select'),
                okVal:'提交',
                cancelVal:'关闭',
                ok: function () {
                    //var oform = $('#address_select form').get(0);
                    var prolistUrl = GetUrl+'&'+$('#address_select form').serialize();
                    //oform.submit();
                    //alert(prolistUrl);
                    //跳转页面
                    window.location = prolistUrl;
                   /*
                      $.ajax({
                        type: 'GET',
                        url: prolistUrl,
                        success: function(res) {
                           alert(res);
                                
                        }
                    });
                    */
                    
//                    $.getJSON(prolistUrl,function(json){
//                        
//                        alert(json);
//                    });
                    
                    
                  return false;
                },
                cancel: function () {
                }
                
                });
            
            return false;
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
})
</script>
    
<script type='text/javascript'>
//DOM加载完毕
$(function(){
	//初始化地域联动
	template.compile("areaTemplate",areaTemplate);

	createAreaSelect('province',0,'');
        
});

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

//修改地址
function form_back(obj)
{
    //自动填充表单
	var form = new Form('form');
	form.init(obj);

	createAreaSelect('province',0,obj.province);
	createAreaSelect('city',obj.province,obj.city);
	createAreaSelect('area',obj.city,obj.area);

	createAreaSelect('school',obj.area,obj.school);

}

//清空表单
function form_empty()
{
	var formInstance = new Form('form');
	$('form[name="form"] input[name]').each(function(){
		formInstance.setValue(this.name,'');
	});

	createAreaSelect('province',0,'');
	$('select[name="city"]').empty();
	$('select[name="area"]').empty();
	
}
</script>
</body>
</html>
