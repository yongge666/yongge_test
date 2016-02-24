G<?php
header('Content-Type:text/html;charset=utf-8');
/**
 * Created by PhpStorm.
 * User:liyong
 * Date: 2016/2/17
 * Time: 22:43
 */
//1.当前时间格式化打印
//date_timezone_set('PRC');//设置中国时区
//date_timezone_set("Etc/GMT-8");// 比林威治标准时间快8小时,是我们的北京时间
echo date('Y-m-d H:i:s');
echo '<hr/>';
//2.
//字符串转数组：
print_r(str_split("Hello Shanghai"));
echo '<hr/>';
//字符串截取：substr($str,1,10);mb_substr()和mb_strcut()，mb_substr是按字来切分字符，而mb_strcut是按字节来切分字符，一个utf8中文字符占三个字节
echo mb_substr('这样一来我的字符串就不会有乱码^_^', 0, 7, 'utf-8');//输出：这样一来我的字
echo '<hr/>';
echo mb_strcut('这样一来我的字符串就不会有乱码^_^', 0, 7, 'utf-8');//输出：这样一
echo '<hr/>';
//分隔成数组：
print_r(explode(' ',"Hello Shanghai"));
echo '<hr/>';
//字符串替换：
echo str_replace("world","Shanghai","Hello world!");
echo '<hr/>';
//正则替换
echo preg_replace('/\s\s+/', ' ','foo   o');//剥离空白字符
echo '<hr/>';
//数组转字符串：
print_r(implode(array('a'=>'aaa','b'=>'bbb')));
echo '<hr/>';
//3.字符串查找strpos,strrpos
$str = '/web/a/b/index.html';
$index = strrpos($str,'/');
//截取网址文件部分
echo substr($str,$index+1);//包含索引位置到结尾部分
echo basename($str);//取文件名

echo '<hr/>';
//截取网址路径部分
echo substr($str,0,$index);
echo dirname($str);//取路径名
echo '<hr/>';
//日期反转
$date = '18/02/2016';
echo preg_replace('/(\d+)\/(\d+)\/(\d+)/','$3/$2/$1',$date);
echo '<hr/>';
//写一个函数，尽可能高校的从一个url里提取文件扩展名
$url = 'http://www.test.com.cn/abc/dsg/del.inc.php';
$path = pathinfo($url);
//var_dump(parse_url($url));
echo $path['extension'];// ["basename"]=> string(11) "del.inc.php
echo '<hr/>';
//复杂情况
$url1 = 'http://www.test.com.cn/abc/dsg/del.inc.php?id=6';
$arr = parse_url($url1);
$path1=$arr['path'];
$arr2 = pathinfo($path1);
//print_r($arr2);
echo $arr2['extension'];

echo '<hr/>';


echo '<hr/>';

/**
 * sql语句
 * 1.从login表中选出name字段包含admin字段的前十条结果
 * select * from login where name like '%admin%' limit 10 order by id;
 * 2通配符：
 * 我们使用like和not like加上一个带通配符的字符串就可以了。共有两个通配符”_”(单个字符)和”&”（多个字符）
select concat(first_namem,' ‘,last_name) as name,
where last_name like ‘W%'; //找到以Ｗ或w开头的人
where last_name like ‘％W%'; //找到名字里面Ｗ或w开头的人
 * 3.使用扩展正则
 *SELECT * FROM `sunup_user` where username REGEXP 'test[0-9]+';
 * “.”匹配任何单个的字符。
一个字符类“[...]”匹配在方括号内的任何字符。例如，“[abc]”匹配“a”、“b”或“c”。为了命名字符的一个范围，使用一个“-”。“[a-z]” 匹配任何小写字母，而“[0-9]”匹配任何数字。
“ * ”匹配零个或多个在它前面的东西。例如，“x*”匹配任何数量的“x”字符，“[0-9]*”匹配的任何数量的数字，而“.*”匹配任何数量的任何东西。
正则表达式是区分大小写的，但是如果你希望，你能使用一个字符类匹配两种写法。例如，“[aA]”匹配小写或大写的“a”而“[a-zA-Z]”匹配两种写法的任何字母。
如果它出现在被测试值的任何地方，模式就匹配(只要他们匹配整个值，SQL模式匹配)。
为了定位一个模式以便它必须匹配被测试值的开始或结尾，在模式开始处使用“^”或在模式的结尾用“$”。
为了说明扩展正则表达式如何工作，上面所示的LIKE查询在下面使用REGEXP重写：

为了找出以“b”开头的名字，使用“^”匹配名字的开始并且“[bB]”匹配小写或大写的“b”：
mysql> SELECT * FROM pet WHERE name REGEXP "^[bB]";
 * 4.变量：
 * 变量的命名规格是：@name, 赋值语法是 @name:=value ( pascal?) 使用起来也简单：
select @birth:=birth from president
where last_name ='adsltiger'; //执行完成后我们就就会有一个@birth变量可用
用一下试试：
select concat(first_namem,' ‘,last_name) as name from president
where birth<@birth order by birth; //看看那些人比我大！

 */
/**
1.对象间的赋值默认是引用传值，指向同一个内存空间；只有指向同意内存地址的两个对象才相等；
1.只要在实例化后在类外改变了属性和方法，不管在类内还是类外调用都是改变后的值；
2.当构造方法__construct()有参数时，在实例化时在对象里传参；
3.__destruct()释放程序资源，（unset操作，关闭文件，数据库）当类执行完成后自动运行；析构函数不能传参；当unset和给对象重新赋值时都会触发；当程序运行完后php会自动销毁变量和对象，释放内存。故实例了几个对象最后就会执行几次__destruct();子类会继承父类的构造方法，若子类也有定义，则会被覆盖；
4.__get($param);当对象调用不存在的属性时自动调用；作用：实现私有属性在类外访问（在__get()内部给返回值）；
5.__set($param,$val);给私有属性赋值时不会报错，但调用赋值的属性时得用__get();作用：对私有属性赋值；
6.PHP不允许调用不存在的属性但允许给类中不存在的属性赋值，而不会报错
7.__isset(isset调用的属性名);当给一个属性isset()判断时自动调用此方法；
8.__unset(属性名)当给一个属性使用unset时，自动调用；
9.__call(不存在的方法名，调用不存在的方法时的所有参数（array）)：调用不存在的方法是执行；作用：实现私有方法的外部调用；
call_user_func_array(array(),)
10.__toString();将对象可以以字符串方式输出；
11.__autoload($classname);当实例化一个不存在的类时，程序自动调用该方法；作用：避免类的重复加载；
12.静态属性static，属于整个类，而非某个对象。访问方式类名：：$属性名，还可以用parent:$属性名;子类继承过来的属性和方法用$this和$parent都可以访问，但$this优先从子类开始寻找。
还可用self:$属性名; 静态属性不能重写；
13.（1）静态属性存在于类空间，普通属性存在于每个对象中。类声明完毕即存在，不依赖于对象，不实例化也可以访问。不依赖于对象（内存中只有一份）。静态方法中不能含有非静态属性；（2）还可以不用实例化。直接使用类名::方法名（属性名）来调用；（3）在类中静态方法访问静态属性，使用类名::静态属性名即可调用类中的静态属性。
（4）在当前类中如果要访问静态成员可以使用self::关键字进行访问。

14.类常量定义 const name="liyong";访问方式：类名::name;只能在类的内部访问；
const不能在条件语句中定义常量；const采用一个普通的常量名称，define可以采用表达式作为名称。
const 总是大小写敏感，然而define()可以通过第三个参数来定义大小写不敏感的常量
使用const简单易读，它本身是一个语言结构，而define是一个方法，用const定义在编译时比define快很多。
15.对象直接相互赋值是引用传递，而想要值传递用clon（）方法；在类中定义__coln魔术方法；
16.抽象类不能被实例化，用来规范开发者定义方法的名称；抽象方法不能有方法体；抽象方法必须要在子类中实现（重写/覆盖）；抽象类中可以存在非抽象方法，但必须有抽象方法；
17.接口只能声明抽象类和常量；同样不能实例化，只能实现implements，不叫继承；子类必须实现接口的全部方法；一个类可以实现多个接口；作用：用来规范开发，命名规范
接口设计原则：尽量避免臃肿，一个接口完成一件事，把共有的常量方法单独封成接口；
18.对象串行化serialize()//对象转字符串
19.设计模式：单件模式（单例模式Singleton），工厂方法模式(Factory Method)，抽象工厂模式(Factory Abstract) 适配器模式(),观察者模式，命令模式，策略模式
20.对象的回收机制：
 **/

class Human{
    public $name='张三';
    public $gender=NULL;

    public function __destruct() {
        echo '发了';
    }
}

$a= new Human();
$b=$c=$d=$a;
echo $a->name,'<br />';
echo $b->name,'<br />';

$b->name='李四';
echo $a->name,'<br />';
echo $b->name,'<br />';
//对象的相互赋值是引用传递，即$a,$b,$c,$d都指向同一个对象所以都会变成李四；

unset($a);//注意这里的unset对对象是无效的,因为还有$b,$c,$d指向这块内存空间，只有当他们全部unset后才会触发析构函数；
//unset($b);unset($c);unset($d);
echo '<hr />';
//-----------------------兄弟连面向对象-------------------------------

/**
 *     面向对象基础
 *声明：[修饰类的关键字]class 类名{
 * 成员(成员属性：变量；成员方法：函数) }
 *命名：类名.class.php,方便自动加载
 *变量和函数名驼峰式命名，类名首字母大写；
 *$对象引用=new 类名;
 *变量成员的调用不用$
 *构造方法就是对象创建完成后第一个调用的方法；
 *php4中和类名相同的就是构造方法;
 *php5中，构造方法使用魔术方法__construct();
 *每个魔术方法都在不同时刻为了完成某一个功能自动调用的方法
 *__destruct();用于关闭资源，做一些清理工作。
 *例如类内调用的__get(),__set(),__isset(),__unset(),__clone(),__call(),__sleep(),__weakup(),__toString()

 *类外调用,唯一一个__autoload();


 *一.封装：就是把对象的成员（属性和方法）结合成一个独立的相同单位，并尽可能隐藏对象的内部细节
 *封装可提高安全性
 *封装使用private（只能在对象内部用$this访问
 *1.方法的封装主要用于内部的一个主方法借助其他若干小方法工作，这些小方法没有单独存在的意义，就可以用private把这些小方法封装起来
 *2.属性的封装，只要变量在多个方法中都用到就将该变量声明为成员属性。封装属性为了不让属性值在实例化后随意读取和更改。类内访问不受影响。封装后可以通过调用共有方法传参来改值，可以在public方法中限制值的范围。可通过方法的return来读取私有属性。
 *3.如果要设置和取值的属性很多可用魔术方法__set和__get来操作。
 *4__get获取成员属性的值时自动调用，必须有一个参数__get($proname)，为传进来的属性名，实例化后获取哪个私有属性就会把哪个私有属性传进来，__get方法内使用$this->$proname;来获取（ps:$proname只是一个参数，并不是成员属性，故调用时加上$）,经过方法就可以判断传进来的成员属性是哪一个，从而写程序来控制。
 *5__set为成员属性设置值时自动调用，有两个参数__set($proName,$proValue),__set方法内使用$this->$proName=$proValue;来设置值。
 *6__isset($proName)查看私有属性是否存在时自动调用,方法内加上 return isset($this->$proName),禁止判断是否设置可通过判断传进来的属性名return false;即可
 *7__unset($proName)直接删除对象中私有属性时调用,方法中加上unset($this->$proName);
 *
 *二.继承
1.父类：基类；    子类：派生类
 *开放性，可扩充性，增加代码的重用性，提高可维护性
 *如果两个或两个以上类中有公用的部分，那么公用的部分就可以作为父类；
 *继承就是在父类的基础上“扩展”父类的功能；
 *C++多继承，同一个类可以有多个父类；
PHP属于但继承，同一个类只能继承一个父类；
但一个类都可以有多个子类；
 *2.子类声明用extends关键字,格式：class 子类名 extends 父类名｛
｝，子类不能继承私有方法
 *3.成员属性一般先声明，加关键字private，protected，public再用__construct设置值，这样即使是私有属性子类也可以用;
 *protected类内和子类可用，类外不能用；
 *4.子类重载父类的方法；重载即方法名相同但参数类型不同。强类型语言可通过指定参数类型实现。PHP中子类方法名与父类相同则会覆盖父类同名方法，还可以扩展此方法；
 *在覆盖父类方法的子类中调用父类方法使用父类名::方法名();即对象->成员；类::成员；
 *5.借助父类初始化:parent:: __construct(属性1，属性2，属性3,........);
 *6.注意：子类只能放大权限不能缩小权限，例如父类为public子类必须为public，父类为protected，则子类可为protected或public。
 *
 *三.多态
 *多态：  多态是面向对象的三大特性之一
 *
“多态”是面向对象设计的重要特性，它展现了动态绑
定（dynamic binding）的功能，也称为“同名异
式”（Polymorphism）。多态的功能可让软件在开发和维护
时，达到充分的延伸性（extension）。事实上，多态最直接
的定义就是让具有继承关系的不同类对象，可以对相同名称
的成员函数调用，产生不同的反应效果。
例如：
interface Test｛
fuanction aaa();
fuanction bbb();
｝
class one implements Test{
function aaa(){
echo "aaaaaaaaaaaaa";
}
function bbb(){
echo "bbbbbbbbbbbbbbb";
}
}

class Tow implements Test{
function aaa(){
echo "11111111111111111";
}
function bbb(){
echo "2222222222222222222";
}


}
$a=new Two;
$b=new one;
$a->aaa();
$b->aaa();
 *
 *1抽象类是一种特殊的类，接口是一种特殊的抽象类，多态就是要用到抽象类和接口
 *抽象类和接口的作用一样，功能有所不同
 *抽象方法：若一个类中的方法没有方法体，而直接使用;结束的就是抽象类。方法体就是方法中的{},例如：function test();
 *若一个方法是抽象方法，就必须使用abstract关键字修饰，
 * 抽象类：若类中存在抽象方法，则该类就是抽象类；
 *抽象类也需要abstract关键字修饰，其特殊性就在于它有抽象方法；
 *抽象类不能实例化对象，类内的成员也不能直接被访问。
 *要想使用一个抽象类就必须用一个类去继承抽象类，子类不能再是抽象类，子类可重写抽象类的方法，给抽象方法加上方法体即可实例化子类。
 *子类必须实现抽象类中抽象方法，即子类必须有抽象类的方法名。其本质就是定义一些规范让子类按这些规范去实现自己的功能。
 *目的：将自己写的程序块加入到 原来写好的程序中去；
 *2.接口是为了解决PHP不能多继承，若使用抽象类则继承抽象类的子类就不能再继承其他类。若既想实现一些规范又想继承其他的类就要使用接口。
 *3.接口与抽象类的对比：
 *（1作用相同，都不能创建对象，都需要子类去实现
 *（2接口的声明不一样，
 *（3 接口被实现的方式不一样 ，interface 接口名{  }
 *（4接口的所有方法必须是抽象方法，但不需要abstract修饰
 *（5接口 的成员属性只能声明常量，用const HOST="localhost";常量可通过  类名::常量  直接访问
 *
 *（6接口中的成员访问权限都必须是public，抽象类中最低的访问权限是protected，
 *（7子类实现接口用implements关键字 ，接口之间的继承还是使用extends；
 *可以使用抽象类去实现接口中的部分方法
 *如果想让子类可以创建对象，则必须实现接口中的全部抽象方法
 *
 *    可以定义一个接品口去继承另一个接品口
 *
 *    一个类可以去实现多个接口（按多个规范去开发子类）, 使用逗号分隔多个接口名称
 *
 *    一个类可以在继承一类的同时，去实现一个或多个接口(先继承，再实现)
 *例如：class Man extends Person implements Woker,Students，Teachers{   }
 *    使用implements的两个目的
 *    	1. 可以实现多个接口 ，而extends词只能继承一个父类
 *    	2. 没有使用extends词，可以去继承一个类， 所以两个可以同时使用
 ** 1   class 类名{
 *
 *    }//普通类
 *
 * 2   abstract class 类名 {
 *
 *    }//抽象类
 *
 *   声明方式
 *
 * 3  interface 接口名{
 *
 *   } //接口
 *
 *
 *
 *
 *
 *四.PHP中常用的关键字和魔术方法
 *1.final不能修饰成员属性，只能修饰类和方法；
使用final修饰的方法不能被继承和重写（覆盖）
 *2.static可以修饰成员属性和方法，不能修饰类
static修饰的成员属性可以被同一类的所有对象共享；
静态数据存在内存中的数据段（初始化静态段）；
静态数据是在类第一次加载时分配到内存中的，以后直接在内存中调用
 *注意：静态成员直接使用类名去访问，不用创建对象，访问格式 类名::静态成员，例如Parent::go();这种格式还用于覆盖父类方法的子类中调用父类方法使用父类名::方法名()
 *若在类中使用静态成员可用self代表本类（$this代表本对象），例如self::go();
 *静态的成员方法不能访问非静态的成员，因为非静态的成员就必须用对象来访问，$this就表示调用它的对象，而静态成员不用对象来去调用，$this就不能代表哪个对象
 *若确定一个方法不使用非静态的成员则可将这个方法声明为静态方法（不用创建对象直接通过类名就可以访问）；
 *3.const只能修饰成员属性，用于在类中声明常量，与define功能相同，访问方式和静态成员相同。
类内使用seif::常量  类外 类名::方法
 *常量一定要在声明时给初值，存储与数据段
 *__call（$methodName,$arg1,$arg2....） 调用系统中不存在的方法时自动调用，用于处理调用不存在方法时的错误提示。
 *__toString()｛return "wwwwwwwwwww";｝直接输出对象引用时调用
 *__clone()可以没参数。与原对象各占一个内存空间，若是把对象引用赋值给一个变量，则这个变量和原对象指向同一个内存地址；
 *其作用与构造方法类似，用于给克隆方法初始化。其中的$this指的是克隆出来的副本的对象,$that代表原本对象；
 *用法：$p=new Person;  $p1=clone $p;
 *4__autoload($className){include './'.$className.'class.php';}唯一一个不在类中添加的方法；用于在类外部自动加载类,只要用到外部类名就会被自动加载
 *5__sleep()，序列化时自动调用的方法；可以将一个对象部分串行化。只要这个方法中返回一个数组，数组中有几个成员属性就序列化几个成员属性，若不加这个方法则所有成员都被序列化了，
例如function __sleep(){
return array(name,age);//将成员属性name和age序列化
}
 *其本质就是规定属性中需要序列化的成员属性

 *
 *对象串行化，将一个对象转化成一个二进制串存储于内存中；
 *用于将对象长时间存储于数据库或文件中，或将对象在多个PHP文件中传输时；
 *例如：$p=new Person();
$str=serialize($p);//将对象转化成二进制串
file_put_contents("p.txt",$str)；//写入文件

$str2=file_get_contents("p.txt");
$pp=unserialize($str2)//反序列化.得到的$pp与原对象$p相同；


 *6__wakeup()是在反序列化时自动调用的方法，为序列化后的对象初始化（有对象诞生就要初始化）；
 *
 *
 *
 *
 *
 *
 *

 *
 *
 *
 *
 */
class Person{
    var $name;
    var $age;
    var $sex;
    function say() {
        echo"说话";
        echo $this->name='888';
    }

    function run() {
        echo "跑";
    }


}
$p1=new Person;
$p2=new Person;
$p1->say();
echo $p1->name='李勇';
echo $p2->age;
    