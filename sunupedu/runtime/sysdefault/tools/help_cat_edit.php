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
			<?php $id=IReq::get('id');?>
<div class="headbar">
	<div class="position"><span>工具</span><span>></span><span>帮助管理</span><span>></span><span><?php if(isset($id)){?>编辑<?php }else{?>添加<?php }?>分类</span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<?php $tmpId = $id===null?"":"id=$id";?>
		<form action='<?php echo IUrl::creatUrl("/tools/help_cat_edit_act/".$id."");?>' method='post' name='cat'>
			<?php if($id!==null){?>
			<input type='hidden' name='id' value='<?php echo isset($id)?$id:"";?>' />
			<?php }?>
			<table class="form_table">
				<col width="150px" />
				<col />
				<tr>
					<th>名称：</th>
					<td>
						<input type='text' class='middle' name='name' value='<?php echo isset($this->cat_row['name'])?$this->cat_row['name']:"";?>' pattern='required' alt='名称不能为空' />
						<label>*分类名称（必填）</label>
					</td>
				</tr>
				<tr>
					<th>在站点下方显示：</th>
					<td>
						<label class='attr'><input type='radio' name='position_foot' value='1' <?php echo $this->cat_row['position_foot']==1?'checked':'';?> />是</label>
						<label class='attr'><input type='radio' name='position_foot' value='0' <?php echo $this->cat_row['position_foot']==0?'checked':'';?> />否</label>
					</td>
				</tr>
				<tr>
					<th>在帮助系统左侧显示：</th>
					<td>
						<label class='attr'><input type='radio' name='position_left' value='1' <?php echo $this->cat_row['position_left']==1?'checked':'';?> />是</label>
						<label class='attr'><input type='radio' name='position_left' value='0' <?php echo $this->cat_row['position_left']==0?'checked':'';?> />否</label>
					</td>
				</tr>
				<tr>
					<th>排序：</th>
					<td>
						<input type='text' class='small' name='sort' value='<?php echo isset($this->cat_row['sort'])?$this->cat_row['sort']:"";?>' pattern='^\d+$' alt='请填写一个数字' />
					</td>
				</tr>
				<tr>
					<th></th><td><button class='submit' type='submit'><span>确 定</span></button></td>
				</tr>
			</table>
		</form>
	</div>
</div>

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
