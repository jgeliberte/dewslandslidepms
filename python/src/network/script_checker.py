import subprocess

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
    alive = []
    for ip in  ip_list:
        command = ip
        ip_id = "ip_"+command[-2:]
        if ip_id == "ip_om":
            ip_id = "google"

        
        p = subprocess.Popen("screen -ls %s"%ip_id, shell=True, stdout=subprocess.PIPE).stdout.read()
        p = p.splitlines()[1:][:-1]
        
        if len(p)== 0 :
            all_restarted.append(command)
            subprocess.run(["screen -dmS %s sudo python3 /var/www/html/python/src/network/network_checker.py %s" %(ip_id,command)], shell=True)
        else:
            alive.append(command)
            # if len(p) > 1:
            #      for id in p:
            #          pid = id.split(".")[0].replace("\t","")
            #          print ("screen -R %s -X quit"%pid)
            #          subprocess.run(["screen -R %s -X quit"%pid],shell=True)            
    
            
    print ("All restarted monitoring ==> "),
    print (all_restarted)
    print ("Alive ==> "),
    print (alive)

    if len(all_restarted) == 0 :
        print (" All network is alive ")
        print ("---------")
    else:
        print (" All restarted network ")
        print (all_restarted)
        print ("---------")