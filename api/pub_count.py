#!python.exe
# print("Content-Type: text/html\n\n")

# print("Not authorized")
import cgi
from re import escape
from mysql.connector.errors import Error
form = cgi.FieldStorage()
from datetime import datetime
import mysql.connector
import json
import traceback

import configparser
from pathlib import Path
config = configparser.ConfigParser()
d = Path(__file__).resolve().parents[1]
print(d)
config.read(f"{d}\config.ini")
api_key = config.get('config','api_key')


# if "key" not in form or form["key"].value != api_key:
#     print("Content-Type: text/html\n\n")
#     print("Not authorized")
#     quit()


query = (
"SELECT oculus_name, discord_id, discord_name, oculus_id,("
"	SELECT COUNT(player_ids) as 'total' "
"	FROM `ecranked`.`skims` "
"	WHERE player_ids LIKE CONCAT('%',oculus_id,'%')"
") as 'total_games'"
"FROM users"
)


cnx = mysql.connector.connect(user='root', password='',
                              host='localhost',
                              database='ecranked')
cursor = cnx.cursor(buffered=True)

cursor.execute(query)
ReturnData = dict()
for (oculus_name,discord_id,discord_name,oculus_id,total_games) in cursor:
    ReturnData[str(oculus_id)] = {
        "oculus_name" : oculus_name,
        "discord_id" : discord_id,
        "discord_name" : discord_name,
        "oculus_id" : oculus_id,
        "total_games" : total_games
        }
print("Content-Type: application/json;charset=utf-8\n\n")
print(json.dumps(ReturnData))
cnx.commit()
cursor.close()
cnx.close()