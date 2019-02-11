#!/bin/bash  
echo "This is a shell script for PMS network monitoring"  
screen -dmS script_listner sudo python3 ~/ivy/dewslandslidepms/network/script_checker.py
screen -dmS script_listner sudo python3 ~/ivy/dewslandslidepms/network/network_checker.py  192.168.150.76