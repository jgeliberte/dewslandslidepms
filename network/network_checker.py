import sys
import pings
import MySQLdb
from datetime import datetime


def DbConnect():
    try:
        db = MySQLdb.connect("192.168.150.76", "root", 
                "senslope", "performance_monitoring")
        cur = db.cursor()
        return db, cur
    
    except(MySQLdb.Error, MySQLdb.Warning) as Error:
        print (Error)
        print ("Error trying to connect by MySQLdb")

    
def DbWrite(query):
    ret_val = None
    db, cur = DbConnect()
    
    try:
        a = cur.execute(query)
        db.commit()
        try:
            a = cur.fetchall()
            ret_val = a
            
        except ValueError:
            ret_val = None
            print (ValueError)
    except MySQLdb.OperationalError:
        print ("MySQLdb.OperationalError on ")
    except (MySQLdb.Error, MySQLdb.Warning) as e:
        print (">> MySQL Error or warning: ")
        print (e, "from")
    except KeyError:
        print ("KeyError on ")
    finally:
        db.close()
        return ret_val
    

def QueryProcess(data):
    timestamp = '{0:%Y-%m-%d %H:%M:%S}'.format(datetime.now())
    ip_address = str(data["ip"])
    status = str(data["status"])
    rtt_min = str(data["response"]["min_rtt"])
    rtt_max = str(data["response"]["max_rtt"])
    rtt_avg = str(data["response"]["avg_rtt"])
    input_responces = str(ip_address +"','" + timestamp + "','" + status + 
                      "','"+ rtt_min + "','" + rtt_max + "','" + rtt_avg + "'" )
    
    query =  ("INSERT IGNORE INTO performance_monitoring.network_logs "+
              "(`ip_address`, `timestamp`, `status`, `rtt_max`, "+
              "`rrt_min`, `rrt_avg`) VALUES ('%s)"% input_responces)
    return query


def NetworkChecker(ip_add, number=30000):
    p = pings.Ping(quiet=False)
    response = p.ping(ip_add, times=number)
    network_response = response.to_dict()
    network_status = response.is_reached()
    output = {"response":network_response, "status":network_status, 'ip':ip_add}
    query = QueryProcess(output)
    message = response.messages[1].find("ICMP")
    if message == -1:
       DbWrite(query)
       return response.messages
    

if __name__ == '__main__':
    ip_add = sys.argv[1]
#    number = sys.argv[2]
    
    while True:
        print (NetworkChecker(ip_add))
    