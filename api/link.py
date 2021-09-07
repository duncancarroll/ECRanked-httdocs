#!python.exe
print("Content-Type: text/html\n\n")
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
    print("Not authorized")
    quit()
if "discord_name" not in form:
    print("Missing data discord_name")
    quit()
if "discord_id" not in form:
    print("Missing data discord_id")
    quit()
if "oculus_name" not in form:
    print("Missing data oculus_name")
    quit()

discord_name = form["discord_name"].value
discord_id = form["discord_id"].value
oculus_name = form["oculus_name"].value

query = ("UPDATE ecranked.users "
"SET discord_id = %s, discord_name = %s "
"WHERE oculus_name = %s;")
cnx = mysql.connector.connect(user='root', password='',
                              host='localhost',
                              database='ecranked')
cursor = cnx.cursor(buffered=True)

cursor.execute(query,(discord_id,discord_name,oculus_name))

cnx.commit()
cursor.close()
cnx.close()