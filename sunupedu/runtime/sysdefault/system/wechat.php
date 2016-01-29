<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>后台管理</title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
	<meta name="robots" content="noindex,nofollow">
	<link rel="shortcut icon" href="favicon.ico" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/skins/default.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/form/form.js"></script>
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/validate.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/autovalidate/style.css" />
	<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/common.js";?>"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/admin.js";?>"></script>
	<script type='text/javascript' src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/menu.js";?>"></script>
</head>
<body>
	<div class="container">
		<div id="header">
			<div class="logo">
				<a href="<?php echo IUrl::creatUrl("/system/default");?>"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/logo.gif";?>" width="303" height="43" /></a>
			</div>
			<div id="menu">
				<ul name="menu">
				</ul>
			</div>
			<p><a href="<?php echo IUrl::creatUrl("/systemadmin/logout");?>">退出管理</a> <a href="<?php echo IUrl::creatUrl("/system/admin_repwd");?>">修改密码</a> <a href="<?php echo IUrl::creatUrl("/system/default");?>">后台首页</a> <a href="<?php echo IUrl::creatUrl("");?>" target='_blank'>商城首页</a> <span>您好 <label class='bold'><?php echo isset($this->admin['admin_name'])?$this->admin['admin_name']:"";?></label>，当前身份 <label class='bold'><?php echo isset($this->admin['admin_role_name'])?$this->admin['admin_role_name']:"";?></label></span></p>
		</div>
		<div id="info_bar">
			<label class="navindex"><a href="<?php echo IUrl::creatUrl("/system/navigation");?>">快速导航管理</a></label>
			<span class="nav_sec">
			<?php $adminId = $this->admin['admin_id']?>
			<?php $query = new IQuery("quick_naviga");$query->where = "admin_id = $adminId and is_del = 0";$items = $query->find(); foreach($items as $key => $item){?>
			<a href="<?php echo isset($item['url'])?$item['url']:"";?>" class="selected"><?php echo isset($item['naviga_name'])?$item['naviga_name']:"";?></a>
			<?php }?>
			</span>
		</div>

		<div id="admin_left">
			<ul class="submenu"></ul>
			<div id="copyright"></div>
		</div>

		<div id="admin_right">
			<?php $siteConfigObj = new Config("site_config");$site_config = $siteConfigObj->getInfo();?>

<div class="headbar">
	<div class="position"><span>系统</span><span>></span><span>第三方平台</span><span>></span><span>微信平台</span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<form action="#" method="post" name="wechat">
			<table class="form_table">
				<colgroup>
					<col width="150px" />
					<col />
				</colgroup>
				<tr>
					<th>微商城帮助：</th>
					<td>
						<a href='http://www.aircheng.com' target='_blank'>不知道如何配置？</a>
					</td>
				</tr>

				<tr>
					<th>URL(服务器地址)：</th>
					<td>
						<span class="orange"><?php echo IUrl::getHost();?><?php echo IUrl::creatUrl("/block/wechat");?></span>
						<label>复制到<微信公众平台后台-开发者中心>URL（服务器地址）</label>
					</td>
				</tr>
				<tr>
					<th>Token(令牌)：</th>
					<td>
						<input type='text' class='normal' name='wechat_Token' pattern='required' alt='公众号Token必须填写'  />
						<label>把填写Token(令牌)复制到<微信公众平台后台-开发者中心>的Token中，必须保持两边一致</label>
					</td>
				</tr>
				<tr>
					<th>AppID：</th>
					<td>
						<input type='text' class='normal' name='wechat_AppID' pattern='required' alt='AppID必须填写' />
						<label>登录到<微信公众平台后台-开发者中心>可以获得</label>
					</td>
				</tr>
				<tr>
					<th>AppSecret：</th>
					<td>
						<input type='text' class='normal' name='wechat_AppSecret' pattern='required' alt='AppSecret必须填写' />
						<label>登录到<微信公众平台后台-开发者中心>可以获得</label>
					</td>
				</tr>
				<tr>
					<th>公众平台菜单：</th>
					<td>
						<textarea id='menuData' style='width:60%;height:200px;'></textarea>
						<p><label>菜单的JSON配置，可以登录<微信公众平台后台-自定义菜单> 进行设置<a href='http://mp.weixin.qq.com/wiki/13/43de8269be54a0a6f64413e4dfa94f39.html' target='_blank'>如何配置</a></label></p>
					</td>
				</tr>

				<tr><td></td><td><button class="submit" type="button" onclick="submitConfig();"><span>保 存</span></button></td></tr>
			</table>
		</form>
	</div>
</div>

<script type='text/javascript'>
jQuery(function()
{
	var formobj = new Form('wechat');
	formobj.init(<?php echo JSON::encode($site_config);?>);

	//获取菜单信息
	$.getJSON('<?php echo IUrl::creatUrl("/system/wechat_getmenu");?>',function(json)
	{
		if(json.result == 'success')
		{
			$('#menuData').val(json.data);
		}
		else
		{
			alert(json.msg);
		}
	});
});

//ajax提交信息
function submitConfig()
{
	var wechat_Token     = $('[name="wechat_Token"]').val();
	var wechat_AppID     = $('[name="wechat_AppID"]').val();
	var wechat_AppSecret = $('[name="wechat_AppSecret"]').val();

	$.post("<?php echo IUrl::creatUrl("/system/save_conf");?>",{"wechat_Token":wechat_Token,"wechat_AppID":wechat_AppID,"wechat_AppSecret":wechat_AppSecret},function(content)
	{
		saveMenu();
	});
}

//保存菜单
function saveMenu()
{
	var menuData = $('#menuData').val();
	if(!menuData)
	{
		alert('保存成功');
		return;
	}

	$.post("<?php echo IUrl::creatUrl("/system/wechat_setmenu");?>",{"menuData":menuData},function(json)
	{
		if(json.result == 'success')
		{
			alert('菜单修改成功');
		}
		else
		{
			alert(json.msg);
		}
	},'json');
}
</script>
		</div>
	</div>

	<script type='text/javascript'>
		//DOM加载完毕执行
		$(function(){
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

			//后台菜单创建
			<?php $menu = new Menu();?>
			var data = <?php echo $menu->submenu();?>;
			var current = '<?php echo $menu->current;?>';
			var url='<?php echo IUrl::creatUrl("/");?>';
			initMenu(data,current,url);
		});
	</script>
</body>
</html>
