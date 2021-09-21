#!python.exe
import cgi
from re import escape

from mysql.connector.errors import Error
form = cgi.FieldStorage()
from datetime import datetime
import mysql.connector
import json
import traceback
import requests
if "username" not in form:
    print("Content-Type: text/html\n\n")
    print("Status: 404 Not Found")
    quit()

import configparser
from pathlib import Path
config = configparser.ConfigParser()
d = Path(__file__).resolve().parents[1]
print(d)
config.read(f"{d}\config.ini")
bot_token = config.get('config','bot_token')

username = form["username"].value
#print(form)
#print(form["key"].value)
# if "key" not in form or form["key"].value != :
#     print("Not authorized")
#     quit()


cnx = mysql.connector.connect(user='root', password='',
                              host='localhost',
                              database='ecranked')
cursor = cnx.cursor(buffered=True)


def GetUserData(_username):
    query = "SELECT oculus_id FROM `ecranked`.`users` WHERE oculus_name=%s"
    cursor.execute(query,(_username,))

    user = None
    for (userData,) in cursor:
        user = userData
    if user == None:
        return None

    UserKeys = [
        "oculus_id",
        "total_deaths",
        "total_ping",
        "frames_ping",
        "total_games_combustion",
        "total_games_dyson",
        "total_games_fission",
        "total_games_surge",
        "total_upsidedown",
        "frames_upsidedown",
        "total_stopped",
        "frames_stopped",
        "total_speed",
        "frames_speed",
        "frames_loadout",
        "loadout",
    ]

    

    UserKeysStr = ' ,'.join(UserKeys)
    query = (f'SELECT {UserKeysStr} FROM  `ecranked`.`stats` WHERE oculus_id={user}')
    #  total_deaths,total_games_combustion,
    #   total_games_dyson,total_games_fission,
    #   total_games_surge,total_ping,
    #   frames_upsidedown,total_stopped,
    #   frames_stopped
    #print(query)

    cursor.execute(query)

    for row in cursor:
        userStatData = {
            key: row[i] for i, key in enumerate(
            UserKeys
            )
        }

        #print(userStatData)

    query = "SELECT discord_id FROM `ecranked`.`users` WHERE oculus_name=%s"
    cursor.execute(query,(_username,))
    userStatData["discord_id"] = None
    for (userData,) in cursor:
        userStatData["discord_id"] = userData

        #print(userStatData)


    query = "SELECT about_string FROM `ecranked`.`users` WHERE oculus_name=%s"
    cursor.execute(query,(_username,))
    userStatData["about_string"] = None
    for (userData,) in cursor:
        userStatData["about_string"] = userData

    query = "SELECT session_id,start_time FROM ecranked.skims WHERE `player_ids` LIKE CONCAT('%',%s,'%') ORDER BY `start_time` DESC LIMIT 10"
    cursor.execute(query,(user,))
    userStatData["recent_games"] = []
    for (session_id,start_time) in cursor:
        userStatData["recent_games"].append({"session_id":session_id,"start_time":datetime.strftime(start_time)})
    return userStatData






playerIDs   = []

playerStatData =  GetUserData(username)
cursor.close()
if playerStatData is None:
    print("Content-Type: text/html")
    print("Status: 404 Not Found\n")
    print("There is no user with that username")
    quit()


print("Content-Type: application/json;charset=utf-8\n")
try:
    #print("Status: 404 Not Found")
    returnData = dict()
    #print(playerStatData)
    returnData["about_string"] = playerStatData["about_string"]

    returnData["average_speed"]      = round(playerStatData["total_speed"]/playerStatData["frames_speed"],4)
    returnData["average_ping"]       = round(playerStatData["total_ping"]/playerStatData["frames_ping"],3)
    returnData["percent_stopped"]    = round(playerStatData["total_stopped"]/playerStatData["frames_stopped"],6)
    returnData["percent_upsidedown"] = round(playerStatData["total_upsidedown"]/playerStatData["frames_upsidedown"],6)
    returnData["total_games"]        = playerStatData["total_games_combustion"]+playerStatData["total_games_dyson"]+playerStatData["total_games_fission"]+playerStatData["total_games_surge"]
    returnData["total_deaths"]       = playerStatData["total_deaths"]
    returnData["average_deaths"]     = round(playerStatData["total_deaths"] / returnData["total_games"],4)
    returnData["discord_name"] = None
    returnData["discord_pfp"] = None
    returnData["average_deaths"]     = round(playerStatData["total_deaths"] / returnData["total_games"],4)

    loadoutData = json.loads(playerStatData["loadout"])
    returnLoadout = dict()
    topLoadout = dict()
    framesLoadout =  playerStatData["frames_loadout"]
    if playerStatData["frames_loadout"] != 0:
       
        for key, value in loadoutData.items():
            returnLoadout[key] = round(value/framesLoadout,6)

        topLoadout = sorted(returnLoadout.items(), key=lambda item: item[1],reverse=True)
        returnData["loadout"] = returnLoadout
        returnData["top_loadout"] = topLoadout




    else:
        returnData["loadout"] = None
    if playerStatData['discord_id'] != None:
        headerData = {
            "User-Agent":"EchoCombatRanked/2.15 ECRanked.com/2.4",
            "Authorization":f"Bot {bot_token}",
        }
        try:
            responce = requests.get(f"https://discord.com/api/users/{playerStatData['discord_id']}",headers = headerData)
            discord_data = responce.json()
            returnData["discord_name"] = discord_data["username"]
            returnData["discord_pfp"] = f"https://cdn.discordapp.com/avatars/{playerStatData['discord_id']}/{discord_data['avatar']}.png";
        except Exception as e:
            error = e
    
    

        #print(userStatData)

    returnData["recent_games"] = playerStatData["recent_games"]


    returnDataStr =  json.dumps(returnData).replace(": None",": null")
    print(returnDataStr)
except Exception as e:
    print( {"error":e})




