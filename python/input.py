#_*_ coding:utf-8 _*_
#在Python 3.2.3中  input和raw_input 整合了，没有了raw_input
name = input('Please input your name:');
age = int(input('Please input your age:'));
job = input('Please input your job:');
salary = input('Please input your salary:');

if age>40:#满足第一个条件就不会往下执行
	msg='You are too old';
elif age>30:
	msg = 'you still have a few years to hook up some girls';
else:
	msg = 'You are still young,go hook up some girls';
#格式化输出：
print('''
Personal Infomation of %s
	name:%s
	age:%d
	job:%s
	salary:%s
	mag:%s
----------------------------
'''%(name,name,age,job,salary,msg));
print(type(age));