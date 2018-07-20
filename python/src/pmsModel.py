import pymysql as mysqlDriver
import pandas.io.sql as psql
import sys
import datetime
from pprint import pprint

def connectDatabase(hostdb='local'):
    Hostdb = "localhost"
    Userdb = "root"
    Passdb = "senslope"
    Namedb = "performance_monitoring"
    while True:
        try:
            db = mysqlDriver.connect(host = Hostdb, user = Userdb, passwd = Passdb, db=Namedb)
            cur = db.cursor()
            cur.execute("use "+ Namedb)
            print('connection success.')
            return db, cur
        except mysqlDriver.OperationalError:
            print_out('.')

def getDataFrame(query, hostdb='local'):
    try:
        db, cur = connectDatabase(hostdb)
        df = psql.read_sql(query, db)
        db.close()
        return df
    except KeyboardInterrupt:
        print_out("Exception detected in accessing database")

def executeQuery(query, hostdb='local'):
    try:
        db, cur = connectDatabase(hostdb)
        cur.execute(query)
        db.commit()
        db.close()
        status = True
    except Exception as e:
        status = False
    return status

def insertTeam(team_name, team_description):
    query = "INSERT INTO dynaslope_teams VALUES ('0','%s','%s');" %(team_name, team_description)
    result = executeQuery(query)
    return result

def insertModule(team_name, module_name, module_description):
    get_team_id_query = "SELECT * FROM dynaslope_teams WHERE team_name = '%s';" %team_name
    team_id = getDataFrame(get_team_id_query)

    query = "INSERT INTO modules VALUES ('0','%s','%s','%s');" %(team_id['team_id'].values[0], module_name, module_description)
    result = executeQuery(query)
    return result

def insertMetric(module_name, metric_name, metric_description):
    get_module_id_query = "SELECT * FROM modules WHERE module_name = '%s';" %module_name
    module_id = getDataFrame(get_module_id_query)

    query = "INSERT INTO metrics VALUES ('0','%s','%s','%s');" %(module_id['module_id'].values[0], metric_name, metric_description)
    result = executeQuery(query)
    return result

def insertAccuracy(metric_id, ts_data, report_message):
    # get_metric_id_query = ""
    # result = executeQuery(get_metric_id_query)

    now = datetime.datetime.now()
    query = "INSERT INTO accuracy VALUES ('0','%s','%s','%s','%s');" %(metric_id, now.strftime("%Y-%m-%d %H:%M"), ts_data, report_message)
    result = executeQuery(query)
    return result

def insertTimeliness(metric_id, execution_time):
    # get_metric_id_query = ""
    # result = executeQuery(get_metric_id_query)

    now = datetime.datetime.now()
    query = "INSERT INTO timeliness VALUES ('0','%s','%s','%s');" %(metric_id, now.strftime("%Y-%m-%d %H:%M"), execution_time)
    result = executeQuery(query)
    return result

def insertErrorRate(metric_id, report_message):
    get_metric_id_query = ""
    result = executeQuery(get_metric_id_query)

    now = datetime.datetime.now()
    query = "INSERT INTO error_rate VALUES ('0','%s','%s','%s');" %(metric_id, now.strftime("%Y-%m-%d %H:%M"), report_message)
    result = executeQuery(query)
    return result

def getMetric(metric_name = "", limit = "all"):
    if limit == "all":
        query = "SELECT * FROM metrics"
    else:
        query = "SELECT * FROM metrics WHERE metric_name = '%s' limit 1;" %metric_name
    result = getDataFrame(query)
    return result

def getModule(module_name = "", limit = "all"):
    if limit == "all":
        query = "SELECT * FROM modules"
    else:
        query = "SELECT * FROM modules WHERE module_name = '%s' limit 1;" %module_name
    result = getDataFrame(query)
    return result 