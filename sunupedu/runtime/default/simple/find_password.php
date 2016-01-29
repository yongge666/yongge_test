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
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/skins/default.css" />
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
	<div class="wrap_box">
		<h3 class="notice">忘记密码</h3>
		<p class="tips">欢迎来到我们的网站，如果忘记密码，请填写下面表单来重新获取密码</p>
		<div class="box">
		<form action="<?php echo IUrl::creatUrl("/simple/find_password_email");?>" method="post" id="mailWay">
			<table class="form_table">
				<colgroup>
					<col width="300px" />
					<col />
				</colgroup>

				<tr><th>用户名：</th><td><input name="username" class="gray" type="text" pattern="required" alt="请输入正确的用户名" /></td></tr>
				<tr><th>邮箱：</th><td><input name="email" class="gray" type="text" pattern="email" alt="请输入正确的邮件地址" /></td></tr>
				<tr>
					<td></td>
					<td><input class="submit" type="submit" value="找回密码" /></td>
				</tr>
				<tr><td></td><td><a href="javascript:changeTab()" class="link">手机短信重置密码</a></td></tr>
			</table>
		</form>

		<form action="<?php echo IUrl::creatUrl("/simple/find_password_mobile");?>" method="post" id="mobileWay" style="display:none">
			<table class="form_table">
				<colgroup>
					<col width="300px" />
					<col />
				</colgroup>

				<tr><th>用户名：</th><td><input name="username" class="gray" type="text" pattern="required" alt="请输入正确的用户名" /></td></tr>
				<tr><th>手机号：</th><td><input name="mobile" class="gray" type="text" pattern="mobi" alt="请输入正确的手机号码" /><a href="javascript:sendMessage();" class="link">发送手机验证码</a></td></tr>
				<tr><th>手机验证码：</th><td><input name="mobile_code" class="gray" type="text" pattern="required" alt="请输入短信息中验证码" /></td></tr>
				<tr>
					<td></td>
					<td><input class="submit" type="submit" value="找回密码" /></td>
				</tr>
				<tr><td></td><td><a href="javascript:changeTab()" class="link">电子邮件重置密码</a></td></tr>
			</table>
		</form>
		</div>
	</div>
</div>

<script language="javascript">
//短信和邮箱切换
function changeTab()
{
	$('#mailWay').toggle();
	$('#mobileWay').toggle();
}

//发送短信码
function sendMessage()
{
	var username = $('#mobileWay [name="username"]').val();
	var mobile   = $('#mobileWay [name="mobile"]').val();
	$.get("<?php echo IUrl::creatUrl("/simple/send_message_mobile");?>",{"username":username,"mobile":mobile},function(content){
		if(content == 'success')
		{
			alert('发送成功，请查看您的手机');
		}
		else
		{
			alert(content);
			return;
		}
	});
}
</script>

		<?php echo IFilter::stripSlash($siteConfig->site_footer_code);?>
	</div>
</body>
</html>
