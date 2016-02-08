#_*_ coding:utf-8 _*_
#在Python 3.2.3中  input和raw_input 整合了，没有了raw_input
name = input('Please input your name:');
age = input('Please input your age:');
job = input('Please input your job:');
salary = input('Please input your salary:');
#格式化输出：
print('''
Personal Infomation of %s
	name:%s
	age:%s
	job:%s
	salary:%s
----------------------------
'''%(name,name,age,job,salary));