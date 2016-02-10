# _*_ coding:utf-8 _*_
f=open('file/a.txt','a+');
print(f);
account_file = 'file/accounts.txt';
open_account_file = open(account_file,'rb');
print(open_account_file);
for line in open_account_file.readlines():
	print(line)