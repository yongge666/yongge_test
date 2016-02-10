#_*_ coding:utf-8_*_
#实现模拟登陆，三次用户名错误锁定账户
import sys
retray_limit = 3;
retray_count = 0;
account_file = 'file/accounts.txt';
lock_file = 'file/accounts_lock.txt';
while retray_count<retray_limit:
    username = input('Please input your username:');
    lock_check = open(lock_file);#输入用户名后检查此用户是否已被lock
    for line in lock_check.readlines():
        line=line.split();#将每行用空格隔开
        if username ==line[0]:
            sys.exit('\033[31;1mUsername %s has been locked!\033[0m'%username);#若账户被锁定直接退出
    password = input('\033[32;1mPlease input your password:\033[0m');
    #打开帐号文件
    open_account_file = open(account_file,'r');
    match_flag = False;
    for line in open_account_file.readlines():
        #print(line.strip('\n').split())  ['lee', '123']
        user,passwd = line.strip('\n').split();#去掉每行多余换行符并用空格隔开分别赋值给user和passwd；
        if username == user and password == passwd:
            print('Hello',username);
            match_flag = True;
            break;#注意此处只跳出了for循环而没跳出while，所以需要match_flag判断
    open_account_file.close();
    #如果上面用户名和密码不匹配则retray_count+1后继续循环
    if match_flag == False:
        print('password no');
        retray_count +=1;
    else:
        print('Welcome login in OldBoy learning Sysytem!');
        sys.exit();
else:
    print('Your account has been locked!');
    lock_file_open = open(lock_file,'a');
    lock_file_open.write(username+'\n');
    lock_file_open.close();
    
    
        
        
        
    
