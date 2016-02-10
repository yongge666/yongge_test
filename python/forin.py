#_*_ coding:utf-8 _*_
age = 26;
for i in range(10):
	age = int(input('Please input your age:'));
	if age>26:
		print('Think bigger!');
	elif age==26:
		print('\033[32;1mYou are \033[42;1mright\033[0m\033[0m');#\033[32;1m绿色输出\033[0m,  \033[42;1m绿底输出\033[0m
		break;
	else:
		print('Think Bigger!');
	#输出剩余次数
	print('You still have %d shots!' %(10-i));
	