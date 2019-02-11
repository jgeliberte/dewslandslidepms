#!/bin/bash  
echo "This is a shell script for PMS network monitoring"  
screen -dmS checker_50 sudo python3 ~/ivy/dewslandslidepms/network/script_checker.py  192.168.150.50
screen -dmS checker_71 sudo python3 ~/ivy/dewslandslidepms/network/script_checker.py  192.168.150.71
screen -dmS checker_75 sudo python3 ~/ivy/dewslandslidepms/network/script_checker.py  192.168.150.75 
screen -dmS checker_77 sudo python3 ~/ivy/dewslandslidepms/network/script_checker.py  192.168.150.77
screen -dmS checker_78 sudo python3 ~/ivy/dewslandslidepms/network/script_checker.py  192.168.150.78
screen -dmS checker_91 sudo python3 ~/ivy/dewslandslidepms/network/script_checker.py  192.168.150.91
screen -dmS checker_92 sudo python3 ~/ivy/dewslandslidepms/network/script_checker.py  192.168.150.92
screen -dmS checker_93 sudo python3 ~/ivy/dewslandslidepms/network/script_checker.py  192.168.150.93
screen -dmS checker_google sudo python3 ~/ivy/dewslandslidepms/network/script_checker.py  www.google.com

