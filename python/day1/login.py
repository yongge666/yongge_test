#!usr/bin/env python 
#_*_ coding: utf-8 _*_
import sys
retry_limit = 3
retry_count = 0
account_file = 'accounts.txt'
lock_file = 'account_lock.txt'

while retry_count < retry_limit: #只要重试不超过3次就不断循环
    
    username = input('\033[32;1mUsername:\033[0m')
    lock_check = open(lock_file)  #当用户输入用户名后，打开LOCK 文件 以检查是否此用户已经LOCK了

    for line in lock_check.readlines(): #循环LOCK文件 
        line = line.split()
        if username == line[0]:
            sys.exit('\033[31;1mUser %s is locked!\033[0m' % username ) #如果LOCK了就直接退出
            
    password = input('\033[32;1mPassword:\033[0m')
    
    f = open(account_file,'r') #打开帐号文件 
    match_flag = False   # 默认为Flase,如果用户match 上了，就设置为 True 
    for line in f.readlines(): 
        user,passwd = line.strip('\n').split() #去掉每行多余的\n并把这一行按空格分成两列，分别赋值为user,passwd两个变量
        if username == user and  password == passwd:  #判断用户名和密码是否都相等
            print ('Match!', username)
            match_flag = True #相等就把循环外的match_flag变量改为了True
            break  #然后就不用继续循环了，直接 跳出，因为已经match上了
    f.close()
    if match_flag == False: #如果match_flag还为False,代表上面的循环中跟本就没有match上用户名和密码，所以需要继续循环
        print ('User unmatched!')
        retry_count +=1
    else: 
        print ("Welcome login OldBoy Learning system!")

else:
    print ('Your account is locked!')
    f = open(lock_file,'a')
    f.write(username)
    f.close()
        
        
        
    
