import requests
import json
import mysql.connector
import time

mydb = mysql.connector.connect(
    host="localhost",
    user="thecup",
    password="password",
    database="raca"
)

mycursor = mydb.cursor()

while True:
    mycursor.execute('SELECT * FROM `raca`.`item` ORDER BY `score` LIMIT 1')
    for row in mycursor:
        try:
            print("https://market-api.radiocaca.com/nft-sales/" + str(row[9]))
            proper = requests.get("https://market-api.radiocaca.com/nft-sales/" + str(row[9]), headers={'User-Agent':'Mozilla/5.0'}).json()["data"]["properties"]
            if proper:
                sql = """UPDATE `raca`.`item` SET
                            `rarity` = %s,
                            `luck` = %s,
                            `stealth` = %s,
                            `level` = %s,
                            `healthy` = %s,
                            `wishdom` = %s,
                            `size` = %s,
                            `race` = %s,
                            `courage` = %s,
                            `score` = %s,
                            `rate` = %s
                        WHERE
                            `id` = %s;"""
                pro = {}
                for j in proper:
                    pro[j["key"].lower()] = j["value"]
                print((pro["rarity"], pro["luck"], pro["stealth"], pro["level"] if pro["level"] else 0, pro["healthy"] if pro["healthy"] else 0, pro["wisdom"] if pro["wisdom"] else 0, pro["size"] if pro["size"] else 0, pro["race"],pro["courage"], pro["score"], float(pro["score"]) * 1000/float(row[21]), row[9]))
                mycursor.execute(sql, (pro["rarity"], pro["luck"], pro["stealth"], pro["level"] if pro["level"] else 0, pro["healthy"] if pro["healthy"] else 0, pro["wisdom"] if pro["wisdom"] else 0, pro["size"] if pro["size"] else 0, pro["race"],pro["courage"], pro["score"], float(pro["score"]) * 1000/float(row[21]), row[9]))
                mydb.commit()
        except Exception as e:
            print(e)
    time.sleep(10)