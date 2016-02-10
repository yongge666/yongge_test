#usr/bin/env python
#_*_ coding:utf-8 _*_
print_num = input('Which loop do you want print?');
count=0;
while count<1000:
	#print('loop',count);
	if int(print_num) == count:#注意类型
		print("There you got the number:",count);
		choice = input('Do you want to continue?y/n');
		if choice =='n':
			break;
	count+=1;
	#print(count);
else:
	print('loop',count);