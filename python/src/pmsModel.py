import pymysql as mysqlDriver
import pandas.io.sql as psql

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
        return df.to_json()
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