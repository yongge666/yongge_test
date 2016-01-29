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
			<div class="headbar">
	<div class="position"><span>商品</span><span>></span><span>商品管理</span><span>></span><span>商品回收站</span></div>
	<div class="operating">
		<a href="javascript:void(0);"><button class="operating_btn" onclick="window.location='<?php echo IUrl::creatUrl("/goods/goods_list");?>'" type="button"><span class="return">返回列表</span></button></a>
		<a href="javascript:void(0);"><button class="operating_btn" onclick="selectAll('id[]')" type="button"><span class="sel_all">全选</span></button></a>
		<a href="javascript:void(0);"><button class="operating_btn" onclick="goods_recycle_del()" type="button"><span class="delete">彻底删除</span></button></a>
		<a href="javascript:void(0);"><button class="operating_btn" onclick="goods_recycle_restore()" type="button"><span class="recover">还原</span></button></a>
	</div>

	<div class="field">
		<table class="list_table">
			<col width="40px" />
			<col />
			<col width="100px" />
			<col width="70px" />
			<col width="70px" />
			<col width="70px" />
			<col width="80px" />
			<col width="70px" />
			<col width="70px" />
			<col width="70px" />
			<thead>
				<tr>
					<th>选择</th>
					<th>商品名称</th>
					<th>分类</th>
					<th>销售价</th>
					<th>库存</th>
					<th>上架</th>
					<th>品牌</th>
					<th>重量</th>
					<th>排序</th>
					<th>操作</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<form action="" method="post" name="orderForm">
	<div class="content">
		<table class="list_table">
			<col width="40px" />
			<col />
			<col width="100px" />
			<col width="70px" />
			<col width="70px" />
			<col width="70px" />
			<col width="80px" />
			<col width="70px" />
			<col width="70px" />
			<col width="70px" />
			<tbody>
				<?php $page=IReq::get('page') ? IFilter::act(IReq::get('page'),'int') : 1?>
				<?php $goodsHandle = new IQuery("goods as go");$goodsHandle->join = "left join brand as b on go.brand_id = b.id";$goodsHandle->where = "go.is_del = 1";$goodsHandle->fields = "go.*,b.name as brand_name";$goodsHandle->order = "go.sort asc,go.id desc";$goodsHandle->page = "$page";$items = $goodsHandle->find(); foreach($items as $key => $item){?>
				<tr>
					<td><input name="id[]" type="checkbox" value="<?php echo isset($item['id'])?$item['id']:"";?>" /></td>
					<td><a href="<?php echo IUrl::creatUrl("/site/products/id/".$item['id']."");?>" target="_blank" title="<?php echo isset($item['name'])?$item['name']:"";?>"><?php echo isset($item['name'])?$item['name']:"";?></a></td>
					<td>
					<?php $catName = array()?>
					<?php $query = new IQuery("category_extend as ce");$query->join = "left join category as cd on cd.id = ce.category_id";$query->fields = "cd.name";$query->where = "goods_id = $item[id]";$items = $query->find(); foreach($items as $key => $catData){?>
						<?php $catName[] = $catData['name']?>
					<?php }?>
					<?php echo join(',',$catName);?>
					</td>
					<td><?php echo isset($item['sell_price'])?$item['sell_price']:"";?></td>
					<td><?php echo isset($item['store_nums'])?$item['store_nums']:"";?></td>
					<td><?php echo $item['is_del']==0?'是':'否';?></td>
					<td><?php echo isset($item['brand_name'])?$item['brand_name']:"";?></td>
					<td><?php echo isset($item['weight'])?$item['weight']:"";?></td>
					<td><?php echo isset($item['sort'])?$item['sort']:"";?></td>
					<td>
						<a href="<?php echo IUrl::creatUrl("/goods/goods_edit/id/".$item['id']."");?>"><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_edit.gif";?>" alt="编辑" /></a>
						<a href="javascript:void(0)" onclick="delModel({link:'<?php echo IUrl::creatUrl("/goods/goods_del/id/".$item['id']."");?>'})" ><img class="operator" src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/icon_del.gif";?>" alt="删除" /></a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</form>
<?php echo $goodsHandle->getPageBar();?>

<script type="text/javascript">
function goods_recycle_del()
{
	$("form[name='orderForm']").attr('action','<?php echo IUrl::creatUrl("/goods/goods_recycle_del");?>');
	confirm('确定要彻底删除所选中的信息吗？','formSubmit(\'orderForm\')');
}

function goods_recycle_restore()
{
	var flag = 0;
	$('input:checkbox[name="id[]"]:checked').each(
		function(i)
		{
			flag = 1;
		}
	);
	if(flag == 0 )
	{
		alert('请选择要还原的数据');
		return false;
	}
	$("form[name='orderForm']").attr('action','<?php echo IUrl::creatUrl("/goods/goods_recycle_restore");?>');
	confirm('确定要还原删除所选中的信息吗？','formSubmit(\'orderForm\')');
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
