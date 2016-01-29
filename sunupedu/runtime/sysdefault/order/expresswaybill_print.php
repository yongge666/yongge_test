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
	<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."plugins/expresswaybill/history/history.js";?>"></script>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."plugins/expresswaybill/print_express.js";?>"></script>
<script type="text/javascript" src="<?php echo IUrl::creatUrl("")."plugins/expresswaybill/swfobject.js";?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo IUrl::creatUrl("")."plugins/expresswaybill/history/history.css";?>" />

<script type="text/javascript">
    var swfVersionStr = "10.0.0";
    var xiSwfUrlStr = "<?php echo IUrl::creatUrl("")."plugins/expresswaybill/playerProductInstall.swf";?>";
    var flashvars = {};
    var params = {};
    params.quality = "high";
    params.bgcolor = "#ffffff";
    params.allowscriptaccess = "sameDomain";
    params.allowfullscreen = "true";

    var attributes = {};
    attributes.id = "printExpress";
    attributes.name = "printExpress";
    attributes.align = "left";

    swfobject.embedSWF(
        "<?php echo IUrl::creatUrl("")."plugins/expresswaybill/main.swf";?>", "flashContent",
        "100%", "100%",
        swfVersionStr, xiSwfUrlStr,
        flashvars, params, attributes);

	swfobject.createCSS("#flashContent", "display:block;text-align:left;");
</script>

<div style='height:<?php echo isset($this->expressRow['height'])?$this->expressRow['height']:"";?>px;'>

	<div id='flashContent'></div>

	<div>
		<input type='button' class='btn_print noprint' onclick="printObj.printStart();" value='开始打印' /> &nbsp;&nbsp;
		<input type='button' class='btn_print noprint' onclick='window.history.go(-1);' value='返回上一级' />
	</div>

</div>

<script type='text/javascript'>
	printObj = null;

	//初始化
	function init()
	{
		printObj = new printExpress();
		printObj.setModeByJS('scan');
		var elementObj = new Array(<?php echo join(',',$this->config_conver);?>);

		for(elementPro in elementObj)
		{
			printObj.createText(elementObj[elementPro]);
		}

		var backgroundPic = "<?php echo IUrl::creatUrl("")."";?><?php echo isset($this->expressRow['background'])?$this->expressRow['background']:"";?>";

		if(backgroundPic != '')
		{
			printObj.backgroundPic(backgroundPic);
		}
	}
</script>
</body>

</html>