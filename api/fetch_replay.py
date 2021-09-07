#!python.exe
import os
import cgi

from typing import List
import mysql.connector
#print("Content-Type: text/html\n\n")

cnx = mysql.connector.connect(user='root', password='',
                              host='localhost',
                              database='ecranked')
cursor = cnx.cursor(buffered=True)
form = cgi.FieldStorage()
session_id = "8173FAAB-B81E-44DE-9A8F-5443CC93C1B7"


if "session_id" not in form:
    print('Content-Type: application/download')
    print("Status: 404 Not Found")
    quit()

session_id = form["session_id"].value



query = "SELECT replay_link FROM `ecranked`.`skims` WHERE session_id=%s"
cursor.execute(query,(session_id,))
filePath = ""
for (link,) in cursor:
    filePath = link

if filePath == "":
    print('Content-Type: application/download')
    print("Status: 200 Not Found")
    quit()


print(f'Content-Disposition: attachment; filename="{session_id}.echoreplay"')
print('')




#filePath = "E:\ECRanked\Replays\combustion\[2021-08-14 21-37-52] B475B4E6-A3A6-428D-A5F0-EC9DC5673611.echoreplay"
#file_size = os.stat(filePath)
#print("Content-Length: " + file_size.st_size)
print("test")
with open(filePath, 'r', encoding='ANSI') as f:
    #print("opened")
    data = f.read()
print(len(data))
print(data)
print(data[5])
#fclose($fp);