#!usr/bin/env python 
#_*_ coding: utf-8 _*_
import sys
retry_limit = 3
retry_count = 0
account_file = 'accounts.txt'
lock_file = 'account_lock.txt'

while retry_count < retry_limit: #ֻҪ���Բ�����3�ξͲ���ѭ��
    
    username = input('\033[32;1mUsername:\033[0m')
    lock_check = open(lock_file)  #���û������û����󣬴�LOCK �ļ� �Լ���Ƿ���û��Ѿ�LOCK��

    for line in lock_check.readlines(): #ѭ��LOCK�ļ� 
        line = line.split()
        if username == line[0]:
            sys.exit('\033[31;1mUser %s is locked!\033[0m' % username ) #���LOCK�˾�ֱ���˳�
            
    password = input('\033[32;1mPassword:\033[0m')
    
    f = open(account_file,'r') #���ʺ��ļ� 
    match_flag = False   # Ĭ��ΪFlase,����û�match ���ˣ�������Ϊ True 
    for line in f.readlines(): 
        user,passwd = line.strip('\n').split() #ȥ��ÿ�ж����\n������һ�а��ո�ֳ����У��ֱ�ֵΪuser,passwd��������
        if username == user and  password == passwd:  #�ж��û����������Ƿ����
            print ('Match!', username)
            match_flag = True #��ȾͰ�ѭ�����match_flag������Ϊ��True
            break  #Ȼ��Ͳ��ü���ѭ���ˣ�ֱ�� ��������Ϊ�Ѿ�match����
    f.close()
    if match_flag == False: #���match_flag��ΪFalse,���������ѭ���и�����û��match���û��������룬������Ҫ����ѭ��
        print ('User unmatched!')
        retry_count +=1
    else: 
        print ("Welcome login OldBoy Learning system!")

else:
    print ('Your account is locked!')
    f = open(lock_file,'a')
    f.write(username)
    f.close()
        
        
        
    
