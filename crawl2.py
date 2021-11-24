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
skip_ids = [1058078]
while True:
    format_strings = ','.join(['%s'] * len(skip_ids))
    mycursor.execute('SELECT * FROM `raca`.`item` WHERE `id` NOT IN (%s) ORDER BY `score`, `fixed_price` LIMIT 1' % format_strings, tuple(skip_ids))
    for row in mycursor:
        if row[9] in skip_ids:
            continue
        try:
            print(i)
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
            else:
                skip_ids.append(row[9])
                print("skip: ")
                print(skip_ids)
        except Exception as e:
            print(e)
    time.sleep(10)