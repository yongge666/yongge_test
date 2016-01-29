<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品列表</title>
<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/skins/default.css" />
</head>
<body>
<div class="pop_win" style="width:690px;height:550px;overflow-y:scroll">
	<div class="content">
		<table class="border_table" style="width:100%">
			<colgroup>
				<col width="150px" />
				<col />
				<col width="90px" />
				<col width="70px" />
			</colgroup>
			<tbody>
				<?php if($this->data){?>
				<?php foreach($this->data as $key => $item){?>
				<tr>
					<td>
						<label class='attr'>
							<input type='<?php echo ($this->type == null) ? 'checkbox' : $this->type;?>' name='id[]' value="<?php echo isset($item['goods_id'])?$item['goods_id']:"";?>" data='<?php echo JSON::encode($item);?>' />
							<?php echo isset($item['goods_no'])?$item['goods_no']:"";?>
						</label>
					</td>
					<td class="t_l">
						<?php echo isset($item['name'])?$item['name']:"";?>
						<?php if(isset($item['spec_array']) && $item['spec_array']){?>
						<p>
							<?php foreach(JSON::decode($item['spec_array']) as $key => $spec){?>
								<?php echo isset($spec['name'])?$spec['name']:"";?>：
								<?php if($spec['type'] == 1){?>
									<?php echo isset($spec['value'])?$spec['value']:"";?>
								<?php }else{?>
									<img src="<?php echo IUrl::creatUrl("")."".$spec['value']."";?>" width="15px" height="15px" class="spec_photo" />
								<?php }?>
							<?php }?>
						</p>
						<?php }?>
					</td>
					<td>￥<?php echo isset($item['sell_price'])?$item['sell_price']:"";?></td>
					<td><img src="<?php echo IUrl::creatUrl("")."".$item['img']."";?>" width="40px" class="img_border" /></td>
				</tr>
				<?php }?>
				<?php }else{?>
				<tr>
					<td colspan="4">对不起，没有找到相关商品</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>