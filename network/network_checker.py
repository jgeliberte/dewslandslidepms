import sys
import pings
import MySQLdb
from datetime import datetime


def date_diff_in_Seconds(dt2, dt1):
  timedelta = dt2 - dt1
  return timedelta.days * 24 * 3600 + timedelta.seconds * 1000


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
    

def QueryProcess(ip_info, ts_info):
    timestamp = '{0:%Y-%m-%d %H:%M:%S}'.format(datetime.now())
    ip_address = str(ip_info["output"]["ip"])
    from_ts = str(ts_info["from_timestamp"])
    to_ts = str(ts_info["to_timestamp"])
    diff_ts = str(ts_info["diff_timestamp"])
    report_message = (ip_address + ": Down from " + from_ts + " to " + to_ts +
                    "with a " + diff_ts + "ms")
    input_responces = str("'42,'" + timestamp + "','" + report_message 
                          + "',0,0'" )
    
    query =  ("INSERT IGNORE INTO performance_monitoring.error_logs "+
              "(`metric_it`, `ts_recieved`, `report_message`, `reference_id, "+
              "`reference_table`) VALUES ('%s)"% input_responces)
    return query


def ProcessInfo(time_array,ip_info):
    total_ts = date_diff_in_Seconds(time_array[-1], time_array[0])
    ts_info = ({'from_timestamp':time_array[0], 'to_timestamp':time_array[-1], 
                                'diff_timestamp':total_ts})
    print ("total time from " + str(time_array[-1]) +" to "
             + str(time_array[0]) +" = "+ str(total_ts) )
    
    query = QueryProcess(ip_info, ts_info)
    DbWrite(query)



def NetworkChecker(ip_add, number=1):
    p = pings.Ping(quiet=True)
    response = p.ping(ip_add, times=number)
    network_status = response.is_reached()
    output = {"status":network_status, "ip":ip_add}
    message = response.messages[1].find("ICMP")
    if message == -1:
       return {"output":output, "mesage":response.messages}
    

if __name__ == '__main__':
    ip_add = sys.argv[1]
    ip_down = []
    ip_up = []    
    while True:
        timestamp = datetime.now()

        ip_info= NetworkChecker(ip_add)
        if ip_info["output"]["status"] == False:
            ip_down.append(timestamp)
            downtime = date_diff_in_Seconds(ip_down[-1],ip_down[0])
            print ("Down from " + str(ip_down[0]) +" to "
                   + str(timestamp) +" = "+ str(downtime) )
            ip_up.clear()
            
        else:
            ip_up.append(timestamp)
            if len(ip_down) != 0:
                print("DownTime")
                ProcessInfo(ip_down,ip_info)
                
            up_time = date_diff_in_Seconds(ip_up[-1],ip_up[0])
            print ("Uptime from " + str(ip_up[0]) +" to "
                   + str(ip_up[-1]) +" = "+ str(up_time))
            ip_down.clear()
        
       
            