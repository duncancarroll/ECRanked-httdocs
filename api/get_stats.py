#!python.exe
import cgi
from re import escape

from mysql.connector.errors import Error
form = cgi.FieldStorage()
from datetime import datetime
import mysql.connector
import json
import traceback

if "username" not in form:
    print("Content-Type: text/html\n\n")
    print("Status: 404 Not Found")
    quit()

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


#print("Status: 404 Not Found")
returnData = dict()
#print(playerStatData)
returnData["average_speed"] = playerStatData["total_speed"]/playerStatData["frames_speed"]
returnData["average_ping"] = playerStatData["total_ping"]/playerStatData["frames_ping"]
returnData["percent_stopped"] = 100*(playerStatData["total_stopped"]/playerStatData["frames_stopped"])
returnData["percent_upsidedown"] = 100*(playerStatData["total_upsidedown"]/playerStatData["frames_upsidedown"])
returnData["total_games"] = playerStatData["total_games_combustion"]+playerStatData["total_games_dyson"]+playerStatData["total_games_fission"]+playerStatData["total_games_surge"]
returnData["total_deaths"] = playerStatData["total_deaths"]
returnData["average_deaths"] = playerStatData["total_deaths"] / returnData["total_games"]

print(returnData)



