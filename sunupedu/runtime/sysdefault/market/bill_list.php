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
<?php $search = IReq::get('search') ? IFilter::act(IReq::get('search'),'strict') : array();?>

<div class="headbar">
	<div class="position"><span>统计</span><span>></span><span>商户数据统计</span><span>></span><span>货款结算列表</span></div>
	<div class="operating">
		<div class="search f_l">
			<form name="searchBill" action="<?php echo IUrl::creatUrl("/");?>" method="get">
				<input type='hidden' name='controller' value='market' />
				<input type='hidden' name='action' value='bill_list' />

				<span>
					申请时间
					<input type="text" name='search[apply_time>=]' value='' class="Wdate" pattern='date' onFocus="WdatePicker()" empty title='选择起始时间' /> 到
					<input type="text" name='search[apply_time<=]' value='' class="Wdate" pattern='date' onFocus="WdatePicker()" empty title='选择终止时间' />
				</span>

				<select class="auto" name="search[is_pay=]">
					<option value="" selected="selected">结算状态</option>
					<option value="0">未结算</option>
					<option value="1">已结算</option>
				</select>

				<button class="btn" type="submit"><span class="sch">搜 索</span></button>
			</form>
		</div>
	</div>

	<div class="field">
		<table class="list_table">
			<colgroup>
				<col width="180px" />
				<col width="90px" />
				<col width="155px" />
				<col width="80px" />
				<col width="155px" />
				<col />
				<col width="100px" />
			</colgroup>

			<thead>
				<tr>
					<th>订单的结算起止</th>
					<th>申请商户</th>
					<th>申请时间</th>
					<th>结算状态</th>
					<th>结算时间</th>
					<th>管理员回复</th>
					<th>操作</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<div class="content">
	<table class="list_table">
		<colgroup>
			<col width="180px" />
			<col width="90px" />
			<col width="155px" />
			<col width="80px" />
			<col width="155px" />
			<col />
			<col width="100px" />
		</colgroup>

		<tbody>
			<?php $where = 1?>
			<?php foreach($search as $key => $item){?>
			<?php if($item !== ""){?><?php $where .= " and ".$key."'".$item."'"?><?php }?>
			<?php }?>
			<?php $page= (isset($_GET['page'])&&(intval($_GET['page'])>0))?intval($_GET['page']):1;?>
			<?php $query = new IQuery("bill as b");$query->join = "left join seller as s on s.id = b.seller_id left join admin as a on b.admin_id = a.id";$query->where = "$where";$query->page = "$page";$query->fields = "b.*,s.seller_name,a.admin_name";$items = $query->find(); foreach($items as $key => $item){?>
			<tr>
				<td><?php echo isset($item['start_time'])?$item['start_time']:"";?> ~ <?php echo isset($item['end_time'])?$item['end_time']:"";?></td>
				<td><?php echo isset($item['seller_name'])?$item['seller_name']:"";?></td>
				<td><?php echo isset($item['apply_time'])?$item['apply_time']:"";?></td>
				<td>
					<?php if($item['is_pay'] == 1){?>
					<label class="green">已结算</label>
					<?php }else{?>
					<label class="orange">未结算</label>
					<?php }?>
				</td>
				<td><?php echo isset($item['pay_time'])?$item['pay_time']:"";?></td>
				<td>
					<?php if($item['pay_content']){?>
						<?php echo isset($item['admin_name'])?$item['admin_name']:"";?>：<?php echo isset($item['pay_content'])?$item['pay_content']:"";?>
					<?php }?>
				</td>
				<td>
					<a href="<?php echo IUrl::creatUrl("/market/bill_edit/id/".$item['id']."");?>">
						<img class="operator" title="回复" alt="回复" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_check.gif";?>" />
					</a>

					<?php if($item['is_pay'] == 0){?>
					<a href="javascript:delModel({link:'<?php echo IUrl::creatUrl("/market/bill_del/id/".$item['id']."");?>'})">
						<img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" title="删除" />
					</a>
					<?php }?>
				</td>
			</tr>
			<?php }?>
		</tbody>
	</table>
</div>
<?php echo $query->getPageBar();?>

<script type="text/javascript">
//表单回填
var formObj = new Form('searchBill');
<?php foreach($search as $key => $item){?>
formObj.setValue("search[<?php echo isset($key)?$key:"";?>]","<?php echo isset($item)?$item:"";?>");
<?php }?>
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
