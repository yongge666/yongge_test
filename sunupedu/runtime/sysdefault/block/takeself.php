<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="<?php echo IUrl::creatUrl("")."views/".$this->theme."/skin/".$this->skin."/css/admin.css";?>" />
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-1.11.3.min.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/jquery/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/artDialog.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/plugins/iframeTools.js"></script><link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/runtime/_systemjs/artdialog/skins/default.css" />
<script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate.js"></script><script type="text/javascript" charset="UTF-8" src="<?php echo BASE_URL; ?>/runtime/_systemjs/artTemplate/artTemplate-plugin.js"></script>
</head>

<body style="width:550px;min-height:160px;">
	<div class="pop_win">
		<table class="form_table" width="95%" cellspacing="0" cellpadding="0" border="0">
			<colgroup>
				<col width="90px" />
				<col />
			</colgroup>

			<thead>
				<tr>
					<td class="t_r">自提点选择：</td>
					<td>
						<select name="province" onchange="getData('province');">
							<option value="">请选择省份</option>
							<?php $query = new IQuery("takeself as ts");$query->join = "left join areas as a on a.area_id = ts.province";$query->fields = "a.*";$query->order = "ts.sort asc";$query->group = "ts.province";$items = $query->find(); foreach($items as $key => $item){?>
							<option value="<?php echo isset($item['area_id'])?$item['area_id']:"";?>"><?php echo isset($item['area_name'])?$item['area_name']:"";?></option>
							<?php }?>
						</select>

						<select name="city" onchange="getData('city');">
							<option value="">请选择城市</option>
						</select>

						<select name="area" onchange="getData('area');">
							<option value="">请选择区域</option>
						</select>

						<select name="place" onchange="getData('place');">
							<option value="">请选择自提点</option>
						</select>
					</td>
				</tr>
			</thead>

			<tbody id="takeselfBox"></tbody>

			<!--自提点模板-->
			<script type="text/html" id="takeselfRowTemplate">
			<tr>
				<td></td>

				<td>
					<label>
						<input type='radio' value='<%=jsonToString(item)%>' name='takeselfItem' checked='checked' />

						<%=item['address']%>

						<%if(item['phone']){%>
						，电话：<%=item['phone']%>
						<%}%>

						<%if(item['mobile']){%>
						，手机：<%=item['mobile']%>
						<%}%>
					</label>
				</td>
			</tr>
			</script>
		</table>
	</div>
</body>

<script type='text/javascript'>
//获取数据
function getData(typeVal)
{
	var selectedVal = $('[name="'+typeVal+'"] option:selected').val();
	$.getJSON("<?php echo IUrl::creatUrl("/block/getTakeselfList");?>",{"id":selectedVal,"type":typeVal},function(jsonData)
	{
		switch(typeVal)
		{
			case "province":
			{
				$('[name="city"] option:gt(0)').remove();
				for(var index in jsonData)
				{
					var item = jsonData[index];
					$('[name="city"]').append('<option value="'+item['city']+'">'+item['city_str']+'</option>');
				}
			}
			break;

			case "city":
			{
				$('[name="area"] option:gt(0)').remove();
				for(var index in jsonData)
				{
					var item = jsonData[index];
					$('[name="area"]').append('<option value="'+item['area']+'">'+item['area_str']+'</option>');
				}
			}
			break;

			case "area":
			{
				$('[name="place"] option:gt(0)').remove();
				for(var index in jsonData)
				{
					var item = jsonData[index];
					$('[name="place"]').append('<option value="'+item['id']+'">'+item['name']+'</option>');
				}
			}
			break;

			case "place":
			{
				$('#takeselfBox').empty();
				for(var index in jsonData)
				{
					var item = jsonData[index];
					var takeselfHtml = template.render('takeselfRowTemplate',{"item":item});
					$('#takeselfBox').append(takeselfHtml);
				}
			}
			break;
		}
	});
}
</script>
</html>