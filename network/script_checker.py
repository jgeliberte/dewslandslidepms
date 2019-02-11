#!/usr/bin/python
import subprocess
import sys
ip_list = ["192.168.150.50", 
           "192.168.150.71", 
           "192.168.150.75", 
           "192.168.150.77", 
           "192.168.150.78", 
           "192.168.150.91", 
           "192.168.150.92", 
           "192.168.150.93",
           "www.google.com"]

while True:
    all_restarted = []
    for ip in  ip_list:
        command = ip
        ip_id = "ip_"+command[-2:]
        if ip_id == "ip_om":
            ip_id = "google"
        try:
            p = subprocess.check_output(["screen -ls %s"%ip_id], universal_newlines=True, shell=True)
            p = p.splitlines()[1:][:-1]
            if len(p) > 1:
                for id in p:
                    pid = id.split(".")[0].replace("\t","")
                    print ("screen -R %s -X quit"%pid)
                    subprocess.run(["screen -R %s -X quit"%pid],shell=True)            
        except subprocess.CalledProcessError:
            all_restarted.append(command)
            subprocess.run(["screen -dmS %s sudo python3 ~/ivy/dewslandslidepms/network/network_checker.py %s" %(ip_id,command)], shell=True)

    if all_restarted == 0:
        print ("All Restarted ip")
        print (all_restarted)
    else:
        print ("All network is alive")
        