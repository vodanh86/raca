import requests
import json
import mysql.connector
import time

while True:
    try:
        data = requests.get("https://market-api.radiocaca.com/nft-sales?pageNo=1&pageSize=100000&sortBy=fixed_price&order=asc&name=&saleType&category&tokenType", headers={'User-Agent':'Mozilla/5.0'}).json()

        mydb = mysql.connector.connect(
            host="localhost",
            user="thecup",
            password="password",
            database="raca"
        )

        mycursor = mydb.cursor()
        keep_ids = {}
        for i in data["list"]:
            keep_ids[i["id"]] = 0
        
        # store total number
        sql = """INSERT INTO `raca`.`count` (`count`) VALUES (%s);"""
        mycursor.execute(sql, (len(keep_ids.keys()),))
        
        # update value
        mycursor.execute('SELECT id FROM `raca`.`item`')
        delete_ids=[]
        for (row_id,) in mycursor:
            if row_id not in keep_ids:
                delete_ids.append(str(row_id))
        
        id_list_string = "', '".join(delete_ids)
        delete_query = "delete from `raca`.`item` where id in ('" +id_list_string+"')"
        print(delete_query)
        mycursor.execute(delete_query)
        print(delete_ids)
        mydb.commit()

        for i in data["list"]:
            if i["name"].lower() == "metamon":
                time.sleep(5)
                print("https://market-api.radiocaca.com/nft-sales/" + str(i["id"]))
                try:
                    proper = requests.get("https://market-api.radiocaca.com/nft-sales/" + str(i["id"]),headers={'User-Agent':'Mozilla/5.0'}).json()["data"]["properties"]
                except: 
                    print("error")
                    proper = {}
                    time.sleep(10)
                val = (i["count"], i["status"], i["fixed_price"], i["name"], i["sale_address"], i["start_time"], i["image_url"], i["end_time"], i["token_id"], i["highest_price"], i["id"], i["sale_type"], "", "", "", "", "", "", "", "", "", "", "")
                if proper:
                    pro = {}
                    sql = """INSERT INTO `raca`.`item`
                        (`count`,
                        `status`,
                        `fixed_price`,
                        `name`,
                        `sale_address`,
                        `start_time`,
                        `image_url`,
                        `end_time`,
                        `token_id`,
                        `highest_price`,
                        `id`,
                        `sale_type`,
                        `rarity`,
                        `luck`,
                        `stealth`,
                        `level`,
                        `healthy`,
                        `wishdom`,
                        `size`,
                        `race`,
                        `courage`,
                        `score`,
                        `rate`)
                        VALUES
                        (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
                        ON DUPLICATE KEY UPDATE
                        fixed_price = VALUES(fixed_price),
                        highest_price = VALUES(highest_price),
                        rarity = VALUES(rarity),
                        luck = VALUES(luck),
                        stealth = VALUES(stealth),
                        level = VALUES(level),
                        healthy = VALUES(healthy),
                        wishdom = VALUES(wishdom),
                        size = VALUES(size),
                        race = VALUES(race),
                        courage = VALUES(courage),
                        score = VALUES(score),
                        rate = VALUES(rate)
                        ;"""
                    for j in proper:
                        pro[j["key"].lower()] = j["value"]
                    print(i["id"])
                    val = (i["count"], i["status"], i["fixed_price"], i["name"], i["sale_address"], i["start_time"], i["image_url"], i["end_time"], i["token_id"], i["highest_price"], i["id"], i["sale_type"],
                        pro["rarity"],pro["luck"],pro["stealth"],pro["level"] if pro["level"] else 0,pro["healthy"] if pro["healthy"] else 0,pro["wisdom"] if pro["wisdom"] else 0,pro["size"] if pro["size"] else 0,pro["race"],pro["courage"],pro["score"], float(pro["score"]) * 1000/float(i["fixed_price"]))
                    print(val)
                    mycursor.execute(sql, val)

                    mydb.commit()
    except Exception as e:
        print(e)
        time.sleep(30) 




