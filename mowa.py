import requests
import json
import mysql.connector
import time
from datetime import datetime

mydb = mysql.connector.connect(
    host="localhost",
    user="thecup",
    password="password",
    database="raca"
)
mycursor = mydb.cursor()
    
def getMowa(mydb, mycursor):
    mowa = []
    for i in range(20):
        data = requests.get("https://api.moniwar.io/shop/items?type=&owner=&sort_by=&keyword=&page=" + str(i), headers={'User-Agent':'Mozilla/5.0'}).json()
        if data["data"]:
            mowa = mowa + data["data"]
    keep_ids = {}
    db_ids = {}
    
    for i in mowa:
        keep_ids[i["id"]] = 0
    
    # update value
    mycursor.execute('SELECT id FROM `raca`.`mowa`')
    delete_ids=[]
    for (row_id,) in mycursor:
        db_ids[row_id] = 0
        if row_id not in keep_ids:
            delete_ids.append(str(row_id))
        
    #delete old data
    delete_query = "delete from `raca`.`mowa`"
    mycursor.execute(delete_query)
    mydb.commit()

    # insert new data
    inser_sql = """INSERT INTO `raca`.`mowa`
        (`mowa_id`,
        `token_id`,
        `nft_id`,
        `name`,
        `icon`,
        `price`,
        `type`,
        `level`,
        `start`,
        `skill_level`)
        VALUES
        (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"""
        
    insert_data = []
    for i in mowa:
        print(i)
        insert_data.append((i["id"], i["token_id"], i["nft_id"], i["name"], i["icon"], i["price"], i["type"], i["level"], i["star"], i["skill_level"]))
    mycursor.executemany(inser_sql, insert_data)
    mydb.commit()
    
while True:
    try:
        getMowa(mydb, mycursor)
        time.sleep(30) 
    except Exception as e:
        print(e)
        time.sleep(30) 




