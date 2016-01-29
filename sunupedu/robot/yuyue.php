<html>
 <head>
<meta charset="utf-8" />
 <title>在线预约信息</title>
  <link href="./style.css" rel="stylesheet" />

 </head>
 <body>
<table width="800" border="1" align="center" cellpadding="1" cellspacing="1">
	<tr>
    <td>
   
	
<form action="./yuyueok.php" method="post" name="yuyue">
 <br><br>
预约信息：湖北省-武汉市-<br><br>
学生区域:
<select id="province" name="area" onChange="ck()" >
    <option>--请选择区域--</option>
   </select>
   <br><br>
   学生学校:
   <select id="city" name="school"> 
    <option>--请选择学校--</option>
   </select>
   <br><br>
   学生年级:
   <select id="san" name="grade">
    <option>--请选择年级--</option>

    <option>小学一年级</option>
  <option>小学二年级</option>
  <option>小学三年级</option>
  <option>小学四年级</option>
  <option>小学五年级</option>
  <option>小学六年级</option>
  <option>幼儿园中班</option>
  <option>幼儿园大班</option> 
  <option>其他年级</option>

   </select>
   
   
   <br><br>
   学生姓名:<input name="name" type="text">
   <br><br>
   家长电话:<input name="mobile" type="text">
   <br><br>
   <input type="submit" name="tijiao" value="提交" />
    <br><br>
   <input type="reset" name="chongzhi" value="重置" />

   </form>
   
    	
    </td>
  </tr>
 </table>
 </body>
 <script type="text/javascript">
 //======================================第一种方法：获取省市二级联菜单=============================
 //获取省的id
 var prame= document.getElementById("province");
 var city= document.getElementById("city");

 //创建省市数组
 var cityList=new Array();
   //创建另一个数组
  var zushu=new Array;
   cityList['江汉区'] = ['大兴第一实验小学','红领巾小学','华苑小学','振兴路小学','崇仁路小学','邬家墩小学','育红小学','美国小学','立新小学','唐家墩小学','永红幼儿园','阳光宝贝幼儿园','好孩子艺术幼儿园','天嘉幼儿园','江汉区其他小学','江汉区幼儿园'];
   cityList['东西湖区'] = ['金银湖小学','长港路小学','常青实验小学','将军路小学','将军花园小学','马池小学','万科高尔夫小学','东西湖区其他小学','东西湖区幼儿园'];
   cityList['其他区'] = ['硚口区常码头小学','江岸区育才汉口小学','其他区小学','其他区幼儿园'];
   
   
   
   
   zushu['南昌市']=['南昌县','青云谱区','莲塘镇'];
   zushu['抚州市']=['临川区','云山镇','唱凯镇'];
   for(var i in cityList){
    prame.add(new Option(i,i),null);
   }
    prame.onchange=function(){
    var prame= document.getElementById("province").value;
    var city= document.getElementById("city");
     
    city.options.length=0;
    for(var k in cityList[prame]){
       city.add(new Option(cityList[prame][k],cityList[prame][k]),null);
  }
 }
 city.onchange=function(){
   var city= document.getElementById("city").value;


  
    for(var k in zushu[city]){
       san.add(new Option(zushu[city][k]),(zushu[city][k]),null);
  }
 }
</script>
 
</html>