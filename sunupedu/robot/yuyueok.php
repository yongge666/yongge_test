<html>
 <head>
<meta charset="utf-8" />
 <title>已成功提交预约信息</title>
  <link href="./style.css" rel="stylesheet" />

 </head>
 <body>
<?php
//本程序用于接收来自HTML页面的表单数据，并输出每个字段
//echo "用户的输入如下所示：<BR>";
//echo "学生姓名：".$_POST['name']."<BR>";
//echo "区：".$_POST['area']."<BR>";
//echo "学校：".$_POST['school']."<BR>";
//echo "年级：".$_POST['grade']."<BR>";



require_once("conn.php");//引用数据库链接文件
$name   = $_POST['name'];
$area   = $_POST['area'];
$school = $_POST['school'];
$grade  = $_POST['grade'];
$mobile = $_POST['mobile'];
$submittime  =date('c');


$sql = "insert into student(name,area,school,grade,mobile,submittime) values ('$name','$area','$school','$grade','$mobile','$submittime')";
mysql_query($sql);//借SQL语句插入数据
mysql_close();//关闭MySQL连接
echo "您已经成功提交预约信息，预约时间定在每周六上午9:30,稍后我们会与您再次确认具体试听时间。您可以返回预约首页或关闭页面-->";

?>

<a href="./index.php">返回预约首页</a>
</body>
</html>