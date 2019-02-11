#!/usr/bin/python
from subprocess import Popen
import subprocess
import sys


command = sys.argv[1]
ip_id = "ip_"+command[-2:]
while True:
    try:
        p = subprocess.check_output(["screen -ls %s"%ip_id], universal_newlines=True, shell=True)
        p = p.splitlines()[1:][:-1]
        print (p)
        if len(p) > 1:
            for id in p:
                pid = id.split(".")[0].replace("\t","")
                print ("screen -R %s -X quit"%pid)
                subprocess.run(["screen -R %s -X quit"%pid],shell=True)
        else:
            print (command + ": Is alive")
            
    except subprocess.CalledProcessError:
        print (command + ": Restarting")
        subprocess.run(["screen -dmS %s sudo python3 ~/ivy/dewslandslidepms/network/network_checker.py %s" %(ip_id,command)], shell=True)
        