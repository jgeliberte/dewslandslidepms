#!/bin/bash  
echo "This is a shell script for PMS network monitoring"  
screen -dmS script_listner sudo python3 /var/www/html/python/src/network/script_checker.py
screen -dmS ip_76 sudo python3 /var/www/html/python/src/network/network_checker.py  192.168.150.76
screen -dmS ip_50 sudo python3 /var/www/html/python/src/network/network_checker.py  192.168.150.50
screen -dmS ip_71 sudo python3 /var/www/html/python/src/network/network_checker.py  192.168.150.71
screen -dmS ip_75 sudo python3 /var/www/html/python/src/network/network_checker.py  192.168.150.75
screen -dmS ip_77 sudo python3 /var/www/html/python/src/network/network_checker.py  192.168.150.77
screen -dmS ip_78 sudo python3 /var/www/html/python/src/network/network_checker.py  192.168.150.78
screen -dmS ip_91 sudo python3 /var/www/html/python/src/network/network_checker.py  192.168.150.91
screen -dmS ip_92 sudo python3 /var/www/html/python/src/network/network_checker.py  192.168.150.92
screen -dmS ip_93 sudo python3 /var/www/html/python/src/network/network_checker.py  192.168.150.93
screen -dmS google sudo python3 /var/www/html/python/src/network/network_checker.py  www.google.com