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

if "key" not in form or form["key"].value != api_key:
    print("Content-Type: text/html\n\n")
    print("Not authorized")
    quit() 
if "oculus_name" not in form:
    print("Content-Type: text/html\n\n")
    print("Missing data oculus_name")
    quit()

query = "SELECT oculus_name, discord_id, discord_name, oculus_id , primary_ip FROM users WHERE oculus_name = %s LIMIT 1"

cnx = mysql.connector.connect(user='root', password='',
                              host='localhost',
                              database='ecranked')
cursor = cnx.cursor(buffered=True)
#form["oculus_name"].value
cursor.execute(query,(form["oculus_name"].value,))
ReturnData = dict()
for (oculus_name,discord_id,discord_name,oculus_id,primary_ip) in cursor:
    ReturnData = {
        "oculus_name" : oculus_name,
        "discord_id" : discord_id,
        "discord_name" : discord_name,
        "oculus_id" : oculus_id,
        "primary_ip" : primary_ip
        }
print("Content-Type: application/json;charset=utf-8\n\n")
print(json.dumps(ReturnData))
cnx.commit()
cursor.close()
cnx.close()