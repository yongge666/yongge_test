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
	<script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="/sunupedu/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="/sunupedu/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="/sunupedu/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
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

	﻿<?php 
	$site_config=new Config('site_config');
	$seo_data=array();
	$seo_data['title']=$site_config->name;
	$seo_data['title'].=$site_config->index_seo_title;
	$seo_data['keywords']=$site_config->index_seo_keywords;
	$seo_data['description']=$site_config->index_seo_description;
	seo::set($seo_data);
?>

<link rel="stylesheet" type="text/css" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.bxSlider/jquery.bxslider.css";?>" />
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/jquery.bxSlider/jquery.bxSlider.min.js";?>"></script>

<div class="wrapper clearfix">
	<div class="sidebar f_r">

			<!--公告通知-->
		<div class="box m_10">
			<div class="title"><h2>公告通知</h2><a class="more" href="<?php echo IUrl::creatUrl("/site/notice");?>">更多...</a></div>
			<div class="cont">
				<ul class="list">
					<?php foreach(Api::run('getAnnouncementList',5) as $key => $item){?>
					<?php $tmpId=$item['id'];?>
					<li><a href="<?php echo IUrl::creatUrl("/site/notice_detail/id/".$tmpId."");?>"><?php echo isset($item['title'])?$item['title']:"";?></a></li>
					<?php }?>
				</ul>
			</div>
		</div>
		<!--公告通知-->
		

		
		<?php echo Ad::show(7);?>
	</div>

	<!--幻灯片 开始-->
	<div class="main f_l">
            <?php if($this->index_slide){?>
            <ul class="bxslider">
                <?php foreach($this->index_slide as $key => $item){?>
                <li title="<?php echo isset($item['name'])?$item['name']:"";?>"><a href="<?php echo IUrl::creatUrl("".$item['url']."");?>" target="_blank"><img src="<?php echo IUrl::creatUrl("")."".$item['img']."";?>" width="750px" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></a></li>
                <?php }?>
            </ul>
            <?php }?>
	</div>
	<!--幻灯片 结束-->
</div>

<?php echo Ad::show(6);?>

<div class="wrapper clearfix">
	<div class="sidebar f_r">




	</div>

	<div class="main f_l">


		<!--最新商品-->
                <div class="box yellow m_10">
                    <div class="title2">
                        <h2><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/new_product.gif";?>" alt="最新商品" width="160" height="36" /></h2>
                    </div>
                    <div class="cont clearfix">
                        <ul class="prolist">
                            <?php if($this->area_id){?>

                            <?php $items = Api::run('getCommendNewSameArea',array('#area_val#',$this->area_id));?>


                            <?php }else{?>
                            <?php $items = Api::run('getCommendNew',4);?>
                            <?php }?>
                            <?php foreach($items as $key => $item){?>
                            <?php $tmpId=$item['id'];?>
                            <li style="overflow:hidden">
                                <a href="<?php echo IUrl::creatUrl("/site/products/id/".$tmpId."");?>"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/175/h/175");?>" width="175" height="175" alt="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
                                <p class="pro_title"><a title="<?php echo isset($item['name'])?$item['name']:"";?>" href="<?php echo IUrl::creatUrl("/site/products/id/".$tmpId."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></p>
                                <p class="brown">惊喜价：<b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></p>
                                <p class="light_gray">市场价：<s>￥<?php echo isset($item['market_price'])?$item['market_price']:"";?></s></p>
                            </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
		<!--最新商品-->

		<!--首页推荐商品-->
		<?php foreach(Api::run('getCategoryListTop') as $key => $first){?>
		<div class="box m_10" name="showGoods">
			<div class="title title3">
				<h2><strong><?php echo isset($first['name'])?$first['name']:"";?></strong></h2>
				
				<ul class="category">
					<?php foreach(Api::run('getCategoryByParentid',array('#parent_id#',$first['id'])) as $key => $second){?>
					<li><?php echo isset($second['name'])?$second['name']:"";?><span></span></li>
					<?php }?>
				</ul>
			</div>

			<div class="cont clearfix">
				<ul class="prolist">
					<?php if($this->area_id){?>
						<?php $items = Api::run('getCategoryExtendListSameArea',array('#categroy_id#',$first['id']),array('#area_val#',$this->area_id),20);?>
                                                   
					<?php foreach($items as $key => $item){?>
					<li style="overflow:hidden">
                                            <?php if($this->user_id){?>
						<a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/175/h/175");?>" width="175" height="175" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
                                                <?php }else{?>
                                                <a href="<?php echo IUrl::creatUrl("/site/pro_list/cat/".$first['id']."");?>"><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/175/h/175");?>" width="175" height="175" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
                                                <?php }?>
						<p class="pro_title"><a title="<?php echo isset($item['name'])?$item['name']:"";?>" href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>"><?php echo isset($item['name'])?$item['name']:"";?></a></p>
						<p class="brown">销售价<b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></p>
					
					</li>
					<?php }?>
					
					
									<?php }else{?>
<?php $items = Api::run('getCategoryExtendList',array('#categroy_id#',$first['id']),4);?>
					<?php }?>	
					
					
							<?php foreach($items as $key => $item){?>
					<li style="overflow:hidden">
						<a href="<?php echo BASE_URL; ?>/index.php?controller=simple&action=login&callback="><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/175/h/175");?>" width="175" height="175" alt="<?php echo isset($item['name'])?$item['name']:"";?>" title="<?php echo isset($item['name'])?$item['name']:"";?>" /></a>
						<p class="pro_title"><a title="<?php echo isset($item['name'])?$item['name']:"";?>" href="<?php echo BASE_URL;?>/index.php?controller=simple&action=login&callback="><?php echo isset($item['name'])?$item['name']:"";?></a></p>
						<p class="brown">销售价<b>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></b></p>
					
					</li>
					<?php }?>
					
					
					
					
				</ul>
			</div>
		</div>
		<?php }?>

		<!--品牌列表-->
		<div class="brand box m_10">
			<div class="title2"><h2><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/brand.gif";?>" alt="品牌列表" width="155" height="36" /></h2></div>
			<div class="cont clearfix">
				<ul>
					<?php foreach(Api::run('getBrandList',6) as $key => $item){?>
					<?php $tmpId=$item['id'];?>
					<li><img src="<?php echo IUrl::creatUrl("")."".$item['logo']."";?>"  width="110" height="50"/><?php echo isset($item['name'])?$item['name']:"";?></li>
					<?php }?>
				</ul>
		  </div>
		</div>
		<!--品牌列表-->

		<!--最新评论-->
		<div class="comment box m_10">
			<div class="title2"><h2><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/front/comment.gif";?>" alt="最新评论" width="155" height="36" /></h2></div>
			<div class="cont clearfix">
				<?php foreach(Api::run('getCommentList',6) as $key => $item){?>
				<dl class="no_bg">
					<?php $tmpGoodsId=$item['goods_id'];?>
					<dt><img src="<?php echo IUrl::creatUrl("/pic/thumb/img/".$item['img']."/w/66/h/66");?>" width="66" height="66" /></dt>
					<dd><?php echo isset($item['name'])?$item['name']:"";?></dd>
					<dd><span class="grade"><i style="width:<?php echo $item['point']*14;?>px"></i></span></dd>
					<dd class="com_c"><?php echo isset($item['contents'])?$item['contents']:"";?></dd>
				</dl>
				<?php }?>
			</div>
		</div>
		<!--最新评论-->
	</div>
</div>

<script type='text/javascript'>
//dom载入完毕执行
jQuery(function()
{
	//幻灯片开启
	$('.bxslider').bxSlider({'mode':'fade','captions':true,'pager':false,'auto':true});

	//index 分类展示
	$('#index_category tr').hover(
		function(){
			$(this).addClass('current');
		},
		function(){
			$(this).removeClass('current');
		}
	);

	//email订阅 事件绑定
	var tmpObj = $('input:text[name="orderinfo"]');
	var defaultText = tmpObj.val();
	tmpObj.bind({
		focus:function(){checkInput($(this),defaultText);},
		blur :function(){checkInput($(this),defaultText);}
	});

	//显示抢购倒计时
	var cd_timer = new countdown();
	<?php if(isset($countNumsItem) && $countNumsItem){?>
	<?php foreach($countNumsItem as $key => $item){?>
		cd_timer.add(<?php echo isset($item)?$item:"";?>);
	<?php }?>
	<?php }?>

	//首页商品变色
	var colorArray = ['green','yellow','purple'];
	$('div[name="showGoods"]').each(function(i)
	{
		$(this).addClass(colorArray[i%colorArray.length]);
	});
});

//电子邮件订阅
function orderinfo()
{
	var email = $('[name="orderinfo"]').val();
	if(email == '')
	{
		alert('请填写正确的email地址');
	}
	else
	{
		$.getJSON('<?php echo IUrl::creatUrl("/site/email_registry");?>',{email:email},function(content){
			if(content.isError == false)
			{
				alert('订阅成功');
				$('[name="orderinfo"]').val('');
			}
			else
				alert(content.message);
		});
	}
}
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
