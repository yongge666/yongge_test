<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>单据打印</title>
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
<link rel="shortcut icon" href="favicon.ico" />
<style media="print" type="text/css">.noprint{display:none}</style>
<style media="screen,print" type="text/css">
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td,button{padding:0;margin:0;font-size:100%;}
body{font:12px/1.5 "宋体", Arial, Helvetica, sans-serif;color:#404040;background-color:#fff;text-align:center}
table{border-collapse:collapse;}
.container{width:90%;margin:20px auto}
.v_m{vertical-align: middle}
.ml_20{margin-left:20px;}
.m_10{ margin-bottom:10px;}
.f14{font-size:14px;}
.f18{font-size:18px;}
.f30{font-size:30px;}
.bold{font-weight:bold}
.gray{color:#979797}
.orange{color:#f76f10;}
table.table.topBorder{border-top:2px solid #b0b0b0;}
table.table tr{_background-image:none}
.btn_print{width:112px;height:31px;margin:20px auto;border:0;}
</style>
</head>

<body>
	<?php $query = new IQuery("expresswaybill");$query->where = "is_close = 0";$query->fields = "id,name";$printType = $query->find();?>
<div class="container">
	<table class="m_10" width="100%" cellspacing="0" cellpadding="0" border="0">
		<col />
		<tr>
			<td align="left"><img src="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/images/admin/logo.gif";?>" width="250" height="53" /></td>
		</tr>
	</table>

	<div class="container">
		<form action='<?php echo IUrl::creatUrl("/order/expresswaybill_print");?>' method='post' id='express_print'>
			<input type='hidden' name='order_id' id='order_id' value='' />
			<input type='hidden' name='express_id' id='express_id' value='' />

			<?php foreach($this->orderInfo as $key => $orderRow){?>
			<table class="table" width="100%" cellspacing="0" cellpadding="0" border="0" style='margin-top:15px'>
				<col width="300px" />
				<col />
				<tr>
					<th>收货人姓名:</th><td align='left'><?php echo isset($orderRow['accept_name'])?$orderRow['accept_name']:"";?></td>
				</tr>
				<tr>
					<th>收货地址:</th><td align='left'><?php echo isset($orderRow['province_str'])?$orderRow['province_str']:"";?> &nbsp; <?php echo isset($orderRow['city_str'])?$orderRow['city_str']:"";?> &nbsp; <?php echo isset($orderRow['area_str'])?$orderRow['area_str']:"";?> &nbsp; <?php echo isset($orderRow['address'])?$orderRow['address']:"";?></td>
				</tr>
				<tr>
					<th>联系手机:</th><td align='left'><?php echo isset($orderRow['mobile'])?$orderRow['mobile']:"";?></td>
				</tr>
				<tr>
					<th>联系电话:</th><td align='left'><?php echo isset($orderRow['telphone'])?$orderRow['telphone']:"";?></td>
				</tr>
				<tr>
					<th>邮编:</th><td align='left'><?php echo isset($orderRow['postcode'])?$orderRow['postcode']:"";?></td>
				</tr>
				<tr>
					<th>订单附言:</th><td align='left'><?php echo isset($orderRow['postscript'])?$orderRow['postscript']:"";?></td>
				</tr>
				<tr>
					<th></th>
					<td align='left'>
						<?php if($printType){?>
						<?php foreach($printType as $key => $printRow){?>
						<input type='submit' value='<?php echo isset($printRow['name'])?$printRow['name']:"";?>' onclick='$("#express_id").val("<?php echo isset($printRow['id'])?$printRow['id']:"";?>");$("#order_id").val("<?php echo isset($orderRow['id'])?$orderRow['id']:"";?>");' /> &nbsp;&nbsp;
						<?php }?>
						<?php }else{?>
						当前还没有快递单模板<a href='<?php echo IUrl::creatUrl("/order/expresswaybill_edit");?>'>点击新建</a>
						<?php }?>
					</td>
			</table>
			<?php }?>
		</form>
	</div>
</div>
</body>

</html>