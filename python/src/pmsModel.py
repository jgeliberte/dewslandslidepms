import pymysql as mysqlDriver
import pandas.io.sql as psql

def connectDatabase(hostdb='local'):
    Hostdb = "localhost"
    Userdb = "root"
    Passdb = "senslope"
    Namedb = "senslopedb"
    while True:
        try:
            db = mysqlDriver.connect(host = Hostdb, user = Userdb, passwd = Passdb, db=Namedb)
            cur = db.cursor()
            cur.execute("use "+ Namedb)
            return db, cur
        except mysqlDriver.OperationalError:
            print_out('.')

def getDataFrame(query, hostdb='local'):
    try:
        db, cur = senslopedb_connect(hostdb)
        df = psql.read_sql(query, db)
        db.close()
        return df
    except KeyboardInterrupt:
        print_out("Exception detected in accessing database")

def executeQuery(query, hostdb='local'):
    db, cur = senslopedb_connect(hostdb)
    cur.execute(query)
    db.commit()
    db.close()

connectDatabase()

query = "SELECT * FROM smsinbox LIMIT 1"

print executeQuery(query)