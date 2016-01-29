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
			<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
<div class="headbar">
	<div class="position"><span>系统</span><span>></span><span>地域管理</span><span>></span><span>地区列表</span></div>
	<div class="operating">
		<a href="javascript:;"><button class="operating_btn" type="button" onclick="addArea(0,0);"><span class="addition">添加地区</span></button></a>
	</div>
	<div class="field">
		<table class="list_table">
			<col width="780px" />
			<col width="120px" />
			<col />
			<thead>
				<tr>
					<th>名称</th>
					<th>排序</th>
					<th>操作</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<div class="content">
	<table class="list_table">
		<col width="780px" />
		<col width="120px" />
		<col />
		<tbody id="area_box"></tbody>
	</table>
</div>

<!--地域模板 开始-->
<script type='text/html' id='areaRowTemplate'>
<tr id="area_<%=item['area_id']%>" name="parent_<%=item['parent_id']%>">
	<td style="padding-left:<%if(last_parent_id === 0){%>40px;<%}else if(last_parent_id > 0){%>80px;<%}else{%>10px;<%}%>">
		<a href="javascript:toggleArea(<%=item['area_id']%>,<%=item['parent_id']%>);"><img id="ctrl_<%=item['area_id']%>" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/open.gif";?>" is_open="no" is_cache="no" /></a>
		<input type="text" value="<%=item['area_name']%>" name="area_name" class="middle" style="width:150px" onblur="updateArea(<%=item['area_id']%>,this);" />
	</td>
	<td><input type="text" value="<%=item['sort']%>" name="area_sort" class="middle" style="width:80px" onblur="updateArea(<%=item['area_id']%>,this);" /></td>
	<td>
		<a href="javascript:addArea(<%=item['area_id']%>,<%=item['parent_id']%>);"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_add.gif";?>" alt="添加" /></a>
		<a href="javascript:delArea(<%=item['area_id']%>);"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>"  alt="删除" /></a>
	</td>
</tr>
</script>
<!--地域模板 结束-->

<script type='text/javascript'>
//DOM加载完毕后
$(function()
{
	<?php $query = new IQuery("areas");$query->order = "sort asc";$query->where = "parent_id = 0";$items = $query->find();?>
	var firstData = <?php echo JSON::encode($items);?>;
	for(var item in firstData)
	{
		$('#area_box').append(template.render('areaRowTemplate',{'item':firstData[item]}));
	}
});

//切换地区
function toggleArea(area_id,last_parent_id)
{
	var is_cache = $('#ctrl_'+area_id).attr('is_cache');
	var is_open  = $('#ctrl_'+area_id).attr('is_open');

	//缓存存在
	if(is_cache == 'yes')
	{
		$('[name="parent_'+area_id+'"]').toggle();
	}
	else
	{
		$.getJSON('<?php echo IUrl::creatUrl("/block/area_child");?>',{"aid":area_id},function(jsonData){
			for(var item in jsonData)
			{
				$('#area_'+area_id).after(template.render('areaRowTemplate',{'item':jsonData[item],'last_parent_id':last_parent_id}));
			}
		});
		$('#ctrl_'+area_id).attr('is_cache','yes');
	}

	//是否已经展开
	if(is_open == 'yes')
	{
		$('#ctrl_'+area_id).attr('src','<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/open.gif";?>');
		$('#ctrl_'+area_id).attr('is_open','no');
	}
	else
	{
		$('#ctrl_'+area_id).attr('src','<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/close.gif";?>');
		$('#ctrl_'+area_id).attr('is_open','yes');
	}
}

//添加地区
function addArea(area_id,last_parent_id)
{
	art.dialog.prompt('添加新地域',function(area_name){
		if(!area_name)
		{
			alert('请填写地域名称');
			return;
		}
		$.getJSON("<?php echo IUrl::creatUrl("/system/area_update");?>",{"parent_id":area_id,"area_name":area_name},function(result){
			if(result.isSuccess == true)
			{
				if(area_id == 0)
				{
					window.location.reload();
					return;
				}

				var is_open  = $('#ctrl_'+area_id).attr('is_open');
				if(is_open == 'yes')
				{
					$('#area_'+area_id).after(template.render('areaRowTemplate',{'item':result.data,'last_parent_id':last_parent_id}));
				}
			}
		});
	});
}

//删除地区
function delArea(area_id)
{
	art.dialog.confirm('确定要删除么？',function(){
		$.getJSON('<?php echo IUrl::creatUrl("/system/area_del");?>',{'id':area_id},function(result){$('#area_'+area_id).remove();})
	});
}

//更新地域数据
function updateArea(area_id,obj)
{
	if($.trim(obj.value) == '')
	{
		alert('地域信息不能为空');
		return;
	}

	var sendData = {"area_id":area_id};
	switch(obj.name)
	{
		case "area_sort":
		{
			sendData.area_sort = obj.value;
		}
		break;

		default:
		{
			sendData.area_name = obj.value;
		}
		break;
	}
	$.getJSON('<?php echo IUrl::creatUrl("/system/area_update");?>',sendData,function(result){});
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
