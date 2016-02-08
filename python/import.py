#coding=utf-8
#-*- coding=utf-8 -*-
import os   #导入系统模块
#os.system('df');
#os.system('dir');
#os.system('pwd');
#保存输出结果
#pwd = os.popen('pwd').read();
import subprocess  #python3已经移除commands模块
res = subprocess.getstatusoutput('pwd');
print(res);


import sys;
#其他导入模块方式
#1.from sys import argv
#print(argv);
#2.from sys import *(不建议使用)
#3.模块别名：
import multiprocessing as multi

# for value in sys.argv:
	# print value;
print(sys.argv);