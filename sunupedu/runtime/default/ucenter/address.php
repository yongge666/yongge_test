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
		﻿<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL;?>/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<script type='text/javascript' src='<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/artTemplate/area_select.js";?>'></script>
<div class="main f_r">
    <div class='tabs'>
		<div class="uc_title m_10 tabs_menu">
			<label class="current node"><span>地址管理</span></label>
			<label class="node" onclick='form_empty()' style="display: none"><span>添加地址</span></label>
		</div>
	    <div class='tabs_content'>
	        <div id="address_list" class="form_content m_10 node">
	            <div class="uc_title2 m_10"><strong>已保存的有效地址</strong></div>
	            <table class="list_table" width="100%" cellpadding="0" cellspacing="0">
	                <col width="120px" />
	                <col width="120px" />
	                <col width="120px" />
	                <col width="120px" />
	                <col width="120px" />
	                <col />
	                <thead>
	                	<tr>
	                		<th>收货人</th>
	                		<th>所在地区</th>
	                		<th>街道地址</th>
	                		<th>电话/手机</th>
	                		<th>邮编</th>
	                		<th>操作</th>
	                	</tr>
	                </thead>
	                <tbody>
	                <?php foreach($this->address as $key => $item){?>
	                    <tr <?php if($key%2==1){?>class='even'<?php }?>>
	                        <td><?php echo isset($item['accept_name'])?$item['accept_name']:"";?></td>
	                        <td><?php echo isset($this->areas[$item['province']])?$this->areas[$item['province']]:"";?><?php echo isset($this->areas[$item['city']])?$this->areas[$item['city']]:"";?><?php echo isset($this->areas[$item['area']])?$this->areas[$item['area']]:"";?><?php echo isset($this->areas[$item['school']])?$this->areas[$item['school']]:"";?></td>
	                        <td><?php echo isset($item['grade'])?$item['grade']:"";?></td>
	                        <td><?php echo isset($item['class'])?$item['class']:"";?></td>
	                        <td><?php echo isset($item['zip'])?$item['zip']:"";?></td>
	                        <td>
	                        	<a class="blue" href='javascript:void(0)' onclick='form_back(<?php echo JSON::encode($item);?>)'>修改</a>|
	                        	<a class="blue" href="javascript:void(0)" onclick="delModel({link:'<?php echo IUrl::creatUrl("/ucenter/address_del/id/".$item['id']."");?>'});">删除</a>|
	                        	<?php if($item['default']==1){?>
	                        	<a class="red2" href="<?php echo IUrl::creatUrl("/ucenter/address_default/id/".$item['id']."/default/0");?>">取消默认</a>
	                        	<?php }else{?>
	                        	<a class="blue" href="<?php echo IUrl::creatUrl("/ucenter/address_default/id/".$item['id']."/default/1");?>">设为默认</a>
	                        	<?php }?>
	                        </td>
	                    </tr>
	                <?php }?>
	                </tbody>
	            </table>
	        </div>
	    </div>
    </div>

	<!--表单修改-->
	<div class="orange_box" id='address_form' style="display: none">
		<form action='<?php echo IUrl::creatUrl("/ucenter/address_edit");?>' method='post' name='form'>
			<input name='id' type='hidden' value='' />
			<table class="form_table" width="100%" cellpadding="0" cellspacing="0">
				<col width="50px" />
				<col />
				<caption>收货地址</caption>

                                 <tr>
                                  <td>学生姓名</td>
 <td>XX省</td>
 <td>XX市</td>
 <td>XX区</td>
 <td>学校</td>
 <td>XX年级</td>
 <td>班级</td>
 <td>手机号</td>
                                 </tr>



				<tr>
					
					<td><input name='accept_name' class="normal" pattern='required' alt='收货人不能为空' type="text" /></td>

            <td> <select  style="width:70px" name="province" child="city,area,school" onchange="areaChangeCallback(this);"></select></td>
						<td> <select  style="width:70px" name="city" child="area,school" parent="province" onchange="areaChangeCallback(this);"></select></td>
						<td> <select  style="width:70px" name="area" child="school" parent="city"   onchange="areaChangeCallback(this);"></select></td>
						<td> <select  style="width:100px" name="school" parent="area" pattern="required"></select></td>

					                
                           

<td>
<select name='grade'>
<option value="" selected="selected">选择年级</option>
<option value='小学一年级'>小学一年级</option>
<option value='小学二年级'>小学二年级</option>
<option value='小学三年级'>小学三年级</option>
<option value='小学四年级'>小学四年级</option>
<option value='小学五年级'>小学五年级</option>
<option value='小学六年级'>小学六年级</option>
<option value='初中七年级'>初中七年级</option>
<option value='初中八年级'>初中八年级</option>
<option value='初中九年级'>初中九年级</option>
<option value='高中一年级'>高中一年级</option>
<option value='高中二年级'>高中二年级</option>
<option value='高中三年级'>高中三年级</option>
</select>
</td>


<td>
<select name='class'>
<option value="" selected="selected">班级</option>
<option value='1班'>1班</option>
<option value='2班'>2班</option>
<option value='3班'>3班</option>
<option value='4班'>4班</option>
<option value='5班'>5班</option>
<option value='6班'>6班</option>
<option value='7班'>7班</option>
<option value='8班'>8班</option>
<option value='9班'>9班</option>
<option value='10班'>10班</option>
<option value='11班'>11班</option>
<option value='12班'>12班</option>
<option value='13班'>13班</option>
<option value='14班'>14班</option>
<option value='15班'>15班</option>
<option value='16班'>16班</option>
<option value='17班'>17班</option>
<option value='18班'>18班</option>
<option value='19班'>19班</option>
<option value='20班'>20班</option>
<option value='21班'>21班</option>
<option value='22班'>22班</option>
<option value='23班'>23班</option>
<option value='24班'>24班</option>
<option value='25班'>25班</option>
<option value='26班'>26班</option>
<option value='27班'>27班</option>
<option value='28班'>28班</option>
<option value='29班'>29班</option>
<option value='30班'>30班</option>
<option value='31班'>31班</option>
<option value='32班'>32班</option>
<option value='33班'>33班</option>
<option value='34班'>34班</option>
<option value='35班'>35班</option>
<option value='36班'>36班</option>
<option value='37班'>37班</option>
<option value='38班'>38班</option>
<option value='39班'>39班</option>
<option value='40班'>40班</option>

</select>
</td>



<td><input name='mobile' class="small" pattern='mobi' empty alt='手机号码格式不正确' type="text" /></td>
</tr>				
			
				<tr>
					
					<td>设为默认</td><td> <label><input name='default' type='checkbox' value='1'></label></td>
				</tr>
				<tr>
				
					
						<td><label class="btn"><input type="submit" value="保存" /></label></td>
                                                 <td> </td>

						<td><label class="btn"><input type="reset" value="取消" /></label></td>
					
				</tr>
			</table>
		</form>
	</div>
</div>

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
