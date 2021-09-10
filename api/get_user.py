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
if "discord_id" in form:
    query = "SELECT oculus_name, discord_id, discord_name, oculus_id , primary_ip FROM users WHERE discord_id = %s LIMIT 1"

    cnx = mysql.connector.connect(user='root', password='',
                                host='localhost',
                                database='ecranked')
    cursor = cnx.cursor(buffered=True)
    #form["oculus_name"].value
    cursor.execute(query,(form["discord_id"].value,))
    ReturnData = None
    for (oculus_name,discord_id,discord_name,oculus_id,primary_ip) in cursor:
        ReturnData = {
            "oculus_name" : oculus_name,
            "discord_id" : discord_id,
            "discord_name" : discord_name,
            "oculus_id" : oculus_id,
            "primary_ip" : primary_ip
            }
    if ReturnData is None:
        print("Content-Type: application/json;charset=utf-8\n\n")
        print("{}")

    print("Content-Type: application/json;charset=utf-8\n\n")
    print(json.dumps(ReturnData))
    cnx.commit()
    cursor.close()
    cnx.close()
    quit()   
if "oculus_name" in form:
    query = "SELECT oculus_name, discord_id, discord_name, oculus_id , primary_ip FROM users WHERE oculus_name = %s LIMIT 1"

    cnx = mysql.connector.connect(user='root', password='',
                                host='localhost',
                                database='ecranked')
    cursor = cnx.cursor(buffered=True)
    #form["oculus_name"].value
    cursor.execute(query,(form["oculus_name"].value,))
    ReturnData = None
    for (oculus_name,discord_id,discord_name,oculus_id,primary_ip) in cursor:
        ReturnData = {
            "oculus_name" : oculus_name,
            "discord_id" : discord_id,
            "discord_name" : discord_name,
            "oculus_id" : oculus_id,
            "primary_ip" : primary_ip
            }
    if ReturnData is None:
        print("Content-Type: application/json;charset=utf-8\n\n")
        print("{}")
        quit()
    print("Content-Type: application/json;charset=utf-8\n\n")
    print(json.dumps(ReturnData))
    cnx.commit()
    cursor.close()
    cnx.close()
    quit()
print("Content-Type: text/html\n\n")
print("Missing data oculus_name")
quit() 