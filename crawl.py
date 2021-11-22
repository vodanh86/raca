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
        db_ids = {}
        
        for i in data["list"]:
            keep_ids[i["id"]] = 0
        
        # store total number
        sql = """INSERT INTO `raca`.`count` (`count`) VALUES (%s);"""
        mycursor.execute(sql, (len(keep_ids.keys()),))
        mydb.commit()
        
        # update value
        mycursor.execute('SELECT id FROM `raca`.`item`')
        delete_ids=[]
        for (row_id,) in mycursor:
            db_ids[row_id] = 0
            if row_id not in keep_ids:
                delete_ids.append(str(row_id))
            
        #delete old data
        id_list_string = "', '".join(delete_ids)
        delete_query = "delete from `raca`.`item` where id in ('" +id_list_string+"')"
        mycursor.execute(delete_query)
        print(delete_ids)
        mydb.commit()

        # insert new data
        inser_sql = """INSERT INTO `raca`.`item`
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
            `sale_type`)
            VALUES
            (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"""
            
        # update new data
        update_sql = """UPDATE `raca`.`item`
            SET `fixed_price` = %s,
            `highest_price` = %s
            WHERE
            `id` = %s;"""
        insert_data = []
        update_data = []
        for i in data["list"]:
            if i["name"].lower() == "metamon":
                if i["id"] in db_ids:
                    update_data.append((i["fixed_price"], i["highest_price"], i["id"]))
                else:
                    insert_data.append((i["count"], i["status"], i["fixed_price"], i["name"], i["sale_address"], i["start_time"], i["image_url"], i["end_time"], i["token_id"], i["highest_price"], i["id"], i["sale_type"]))
        mycursor.executemany(inser_sql, insert_data)
        mycursor.executemany(update_sql, update_data)
        mydb.commit()
    except Exception as e:
        print(e)
        time.sleep(30) 




