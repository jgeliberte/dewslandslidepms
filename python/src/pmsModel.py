import pymysql as mysqlDriver
import pandas.io.sql as psql
import sys
import datetime
from var_dump import var_dump

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

def insertModule(team_id, module_name, module_description):
    query = "INSERT INTO modules VALUES ('0','%s','%s','%s');" %(team_id, module_name, module_description)
    result = executeQuery(query)
    return result

def insertMetric(module_id, metric_name, metric_description):
    query = "INSERT INTO metrics VALUES ('0','%s','%s','%s');" %(module_id, metric_name, metric_description)
    result = executeQuery(query)
    return result

def insertAccuracy(metric_id, ts_data, report_message):
    now = datetime.datetime.now()
    query = "INSERT INTO accuracy VALUES ('0','%s','%s','%s','%s');" %(metric_id, now.strftime("%Y-%m-%d %H:%M"), ts_data, report_message)
    result = executeQuery(query)
    return result

def insertTimeliness(metric_id, execution_time):
    now = datetime.datetime.now()
    query = "INSERT INTO timeliness VALUES ('0','%s','%s','%s');" %(metric_id, now.strftime("%Y-%m-%d %H:%M"), execution_time)
    result = executeQuery(query)
    return result

def insertErrorRate(metric_id, report_message):
    now = datetime.datetime.now()
    query = "INSERT INTO error_rate VALUES ('0','%s','%s','%s');" %(metric_id, now.strftime("%Y-%m-%d %H:%M"), report_message)
    result = executeQuery(query)
    return result

def getMetric(metric_name = "", limit = "all"):
    if limit == "all":
        query = "SELECT * FROM metrics"
    else:
        query = "SELECT * FROM metrics WHERE name = '%s' limit 1;" %metric_name
    result = getDataFrame(query)
    return result

def getModule(module_name = "", limit = "all"):
    if limit == "all":
        query = "SELECT * FROM modules"
    else:
        query = "SELECT * FROM modules WHERE name = '%s' limit 1;" %module_name
    result = getDataFrame(query)
    return result 

def getTeam(team_name = "", limit = "all"):
    if limit == "all":
        query = "SELECT * FROM dynaslope_teams"
    else:
        query = "SELECT * FROM dynaslope_teams WHERE name = '%s' limit 1;" %team_name
    result = getDataFrame(query)
    return result

def getAccuracy(report_id, limit):
    if limit == "all":
        query = "SELECT * FROM accuracy"
    else:
        query = "SELECT * FROM accuracy WHERE report_id = '%s' limit 1;" %report_id
    result = getDataFrame(query)
    return result

def getErrorRate(report_id, limit):
    if limit == "all":
        query = "SELECT * FROM error_rate"
    else:
        query = "SELECT * FROM error_rate WHERE report_id = '%s' limit 1;" %report_id
    result = getDataFrame(query)
    return result

def getTimeliness(report_id, limit):
    if limit == "all":
        query = "SELECT * FROM timeliness"
    else:
        query = "SELECT * FROM timeliness WHERE report_id = '%s' limit 1;" %report_id
    result = getDataFrame(query)
    return result

def updateMetric(metric_id, module_id, metric_name, description):
    query = "UPDATE metrics SET module_id = '%s', name = '%s', description = '%s' WHERE metric_id = '%s'" %(module_id, metric_name, description, metric_id)
    result = executeQuery(query)
    return result

def updateModule(module_id, team_id, module_name, description):
    query = "UPDATE modules SET team_id = '%s', name = '%s', description = '%s' WHERE module_id = '%s'" %(team_id, module_name, description, module_id)
    result = executeQuery(query)
    return result

def updateDynaslopeTeam(team_id, team_name, description):
    query = "UPDATE dynaslope_teams SET name = '%s', description = '%s' WHERE team_id = '%s'" %(team_name, description, team_id)
    result = executeQuery(query)
    return result