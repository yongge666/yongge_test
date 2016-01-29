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
			<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/my97date/wdatepicker.js"></script>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/javascript/event.js";?>"></script>

<div class="headbar">
	<div class="position"><span>工具</span><span>></span><span>广告管理</span><span>></span><span><?php if(isset($this->adRow['id'])){?>编辑<?php }else{?>添加<?php }?>广告</span></div>
</div>
<div class="content_box">
	<div class="content form_content">
		<form action='<?php echo IUrl::creatUrl("/tools/ad_edit_act");?>' method='post' name='ad' enctype='multipart/form-data'>
			<input type='hidden' name='id' value='' />
			<input type='hidden' name='content' value='<?php if($this->adRow['type'] <= 2){?><?php echo isset($this->adRow['content'])?$this->adRow['content']:"";?><?php }?>' />
			<table class="form_table">
				<col width="150px" />
				<col />
				<tr>
					<th>名称：</th>
					<td>
						<input type='text' class='normal' name='name' pattern='required' alt="填写名称" />
						<label>*广告名称（必填）</label>
					</td>
				</tr>
				<tr>
					<th>广告展示类型：</th>
					<td>
						<label class='attr'><input type='radio' name='type' value='1' checked=checked />图片</label>
						<label class='attr'><input type='radio' name='type' value='2' />flash</label>
						<label class='attr'><input type='radio' name='type' value='3' />文字</label>
						<label class='attr'><input type='radio' name='type' value='4' />代码</label>

						<div id='ad_box'>
							<div style='display:none'>
								<input type="file" name="img" class="file" /><br />
							</div>

							<div style='display:none'>
								<input type="file" name="flash" class="file" /><br />
							</div>

							<div style='display:none'>
								<input type="text" class="normal" name="text" value="" />
							</div>

							<div style='display:none'>
								<textarea class='textarea' name='code'><?php if($this->adRow['type'] == 4){?><?php echo isset($this->adRow['content'])?$this->adRow['content']:"";?><?php }?></textarea>
							</div>
						</div>

					</td>
				</tr>
				<tr>
					<th>广告位：</th>
					<td>
						<select name='position_id' class='normal' pattern='required' alt='广告位不能为空'>
							<option value=''>请选择</option>
							<?php $query = new IQuery("ad_position");$items = $query->find(); foreach($items as $key => $item){?>
							<option value='<?php echo isset($item['id'])?$item['id']:"";?>'><?php echo isset($item['name'])?$item['name']:"";?></option>
							<?php }?>
						</select>
						<label>*在选择的广告位置内进行展示（必选）</label>
					</td>
				</tr>
				<tr>
					<th>链接地址：</th>
					<td>
						<input type='text' class='normal' name='link' empty pattern='url' alt='请填写正确URL地址' />
						<label>点击广告后页面链接的URL地址，为空则不跳转</label>
					</td>
				</tr>
				<tr>
					<th>排序：</th>
					<td>
						<input type='text' class='small' name='order' pattern='^\d+$' alt='填写正确的数字' />
						<label>数字越小，排列越靠前</label>
					</td>
				</tr>

				<tr>
					<th>开始和结束时间：</th>
					<td>
						<input type='text' class='Wdate' onfocus='WdatePicker()' onblur="FireEvent(this,'onchange');" name='start_time' pattern='date' /> ～
						<input type='text' class='Wdate' onfocus='WdatePicker()' onblur="FireEvent(this,'onchange');" name='end_time' pattern='date' />
						<label>*广告展示的开始时间和结束时间（必选）</label>
					</td>
				</tr>
				<tr>
					<th>描述：</th>
					<td><textarea class='textarea' name='description' alt='请填写文章内容'><?php echo isset($this->adRow['description'])?$this->adRow['description']:"";?></textarea></td>
				</tr>
				<tr>
					<th>绑定商品分类：</th>
					<td>
						<select name="goods_cat_id" class="auto">
							<option value="0">无绑定</option>
							<?php $query = new IQuery("category");$query->order = "sort asc";$items = $query->find(); foreach($items as $key => $item){?>
							<option value="<?php echo isset($item['id'])?$item['id']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></option>
							<?php }?>
						</select>
						<label> 可选项，与商品分类做关联，与商品分类绑定在一起，动态的展示 </label>
					</td>
				</tr>
				<tr>
					<th></th><td><button class='submit' type='submit'><span>确 定</span></button></td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script type='text/javascript'>
//单选按钮点击绑定
$('input:radio[name="type"]').each(
	function(i)
	{
		$(this).click
		(
			function(){showType(i);}
		);
	}
);

//广告type 控件的show,hide切换
function showType(indexVal)
{
	$('#ad_box>div').hide();
	$('#ad_box>div:eq('+indexVal+')').show();
}

//预定义type数据
function defaultShowType()
{
	var checkedVal  = "<?php echo isset($this->adRow['type'])?$this->adRow['type']:"";?>";

	<?php if($this->adRow['type'] != 4){?>
		var checkedData = "<?php echo IFilter::addSlash($this->adRow['content']);?>";
		var typeHTML    = '';

		//如果有数据
		if(checkedData)
		{
			switch(checkedVal)
			{
				case "1":
				var typeHTML = '<img src="<?php echo IUrl::creatUrl("")."";?>'+checkedData+'" width="150px" />';
				$('#ad_box>div:eq('+(checkedVal-1)+')').html($('#ad_box>div:eq('+(checkedVal-1)+')').html()+typeHTML);
				break;

				case "2":
				var typeHTML = '<embed src="<?php echo IUrl::creatUrl("")."";?>'+checkedData+'" width="150px" type="application/x-shockwave-flash"></embed>';
				$('#ad_box>div:eq('+(checkedVal-1)+')').html($('#ad_box>div:eq('+(checkedVal-1)+')').html()+typeHTML);
				break;

				case "3":
				$('#ad_box>div:eq('+(checkedVal-1)+') input:text[name="text"]').val(checkedData);
				break;
			}
			showType(checkedVal-1);
		}

		//如果无数据
		else
		{
			showType(0);
		}
	<?php }else{?>
		showType(checkedVal-1);
	<?php }?>
}

//表单回显
defaultShowType();
var FromObj = new Form('ad');
FromObj.init(<?php echo JSON::encode($this->adRow);?>);
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
