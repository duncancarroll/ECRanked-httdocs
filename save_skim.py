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
config = configparser.ConfigParser()
config.read('config.ini')
api_key = config.get('config','api_key')
print(form)
if "key" not in form or form["key"].value != api_key:
    print("Not authorized")
    quit()

print("print 16")
cnx = mysql.connector.connect(user='root', password='',
                              host='localhost',
                              database='ecranked')
cursor = cnx.cursor(buffered=True)
print("print 21")


def GetUserData(userID,userName):
    query = f"SELECT * FROM `ecranked`.`users` WHERE oculus_id={userID}"
    cursor.execute(query)

    user = None
    for userData in cursor:
        user = userData
    if user == None:
        query = (f"INSERT INTO `ecranked`.`users` (`oculus_id`, `oculus_name`) VALUES ({userID},'{userName}');")
        cursor.execute(query)
        query = (f"INSERT INTO `ecranked`.`stats` (`oculus_id`) VALUES ({userID});")
        cursor.execute(query)
        cnx.commit()


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
    query = (f'SELECT {UserKeysStr} FROM  `ecranked`.`stats` WHERE oculus_id={userID}')

    cursor.execute(query)

    for row in cursor:
        userStatData = {
            key: row[i] for i, key in enumerate(
            UserKeys
            )
        }

    return userStatData

def SaveStatData(userID,StatData):
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
    ]


    SetString = []
    for userKey in UserKeys:
        SetString.append(f"`{userKey}` = {StatData[userKey]}")

    SetString.append(f"`loadout` = '{StatData['loadout']}'")

    SetStringFull = ' ,'.join(SetString)
    query = (f"UPDATE `ecranked`.`stats` SET {SetStringFull} WHERE (`oculus_id` = {userID})")
    print(query)
    cursor.execute(query)


print("print 103")


# roundSkimPath = f"E:\ECRanked\Skims\combustion\[2021-08-14 21-37-52] B475B4E6-A3A6-428D-A5F0-EC9DC5673611.ecrs"
# jsondata = json.load(open(roundSkimPath))
# SessionID = "7F34913E-6170-4CDE-806B-B0EBFE7E6080"
# replayLink = f"E:\ECRanked\Replays\combustion\[2021-08-14 21-37-52] B475B4E6-A3A6-428D-A5F0-EC9DC5673611.echoreplay"

# playerIDS = []

# for playerName,playerData in jsondata["players"].items():
#     playerIDS.append(str(playerData["userid"]))
# jsondata["session_id"] = SessionID
# jsondata["replay_link"] = replayLink

# playerIDSStr = ",".join(playerIDS)
# Formdata = {
#     "key": 
#     "data" : json.dumps(jsondata)
#     }
# data =jsondata




data   = json.loads(form["data"].value)
print("print 129")

sessionID   = data["session_id"]
print("print 132")


startTime   =  datetime.strptime(data["start_time"].replace("/","-").split(".")[0],"%Y-%m-%d %H:%M:%S") #
FormatedStartTime = datetime.strftime(startTime,"%Y-%m-%d %H-%M-%S")
print("print 136")

totalFrames = data["frames"]
mapName     = data["map"]
replayLink  = data["replay_link"]

playerIDs   = []

print("print 143")

for playername, playerData in data["players"].items():
    if playerData["team"] == 2:
        continue
    print(f"print 146 {playername}")
    playerID = playerData["userid"]
    
    playerStatData =  GetUserData(playerID,playername)
    SkimStatPlayerData = playerData["stats"]

    playerStatData["total_deaths"] += SkimStatPlayerData["total_deaths"]
    playerStatData["total_ping"] += SkimStatPlayerData["total_ping"]
    playerStatData["frames_ping"] += 0 if SkimStatPlayerData["total_ping"] == 0 else SkimStatPlayerData["total_frames"]
    
    print(f"print 156 {playername}")
    playerStatData["total_games_combustion"] += 1 if mapName == "combustion" else 0
    playerStatData["total_games_dyson"] += 1 if mapName == "dyson" else 0
    playerStatData["total_games_fission"] += 1 if mapName == "fission" else 0
    playerStatData["total_games_surge"] += 1 if mapName == "surge" else 0
    playerStatData["total_upsidedown"] += SkimStatPlayerData["total_upsidedown"]
    playerStatData["frames_upsidedown"]+= SkimStatPlayerData["frames_upsidedown"]
    playerStatData["total_stopped"] += SkimStatPlayerData["total_stopped"]
    playerStatData["frames_stopped"] += SkimStatPlayerData["frames_stopped"]
    playerStatData["total_speed"] += SkimStatPlayerData["total_speed"]
    playerStatData["frames_speed"] += SkimStatPlayerData["frames_speed"]
    playerStatData["frames_speed"] += SkimStatPlayerData["frames_speed"]


    playerStatData["frames_loadout"] += SkimStatPlayerData["frames_loadout"]
    savedLoadoutData = json.loads(playerStatData["loadout"])
    print(savedLoadoutData)

    skimLoadoutData = SkimStatPlayerData["loadout"]
    print(json.dumps(skimLoadoutData))

    for key,value in skimLoadoutData.items():
        if key not in savedLoadoutData:
            savedLoadoutData[key] = 0
        savedLoadoutData[key] += value
    playerStatData["loadout"] = json.dumps(savedLoadoutData)

    print(f"print 167 {playername}")


    # UserKeys = [
    #     "total_deaths","total_games_combustion",
    #     "total_games_dyson","total_games_fission",
    #     "total_games_surge","total_ping",
    #     "frames_upsidedown","total_stopped",
    #     "frames_stopped"
    #   ]

    SaveStatData(playerID,playerStatData)



    playerIDs.append(str(playerData["userid"]))


    playerIDsStr = ",".join(playerIDs) 

print(f"print 187")






print(f"print 194")

query = ("INSERT INTO `ecranked`.`skims`"
    "(`session_id`, `start_time`, `frames`, `map`, `player_ids`, `replay_link`)"
    " VALUES (%s, %s, %s, %s, %s, %s)"
    )
cursor.execute(query,(sessionID,startTime,totalFrames,mapName,playerIDsStr,replayLink))
print("finished")
cnx.commit()
cursor.close()
cnx.close()



