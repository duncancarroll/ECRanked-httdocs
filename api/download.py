#!python.exe
import os
import cgi
form = cgi.FieldStorage()

import mysql.connector
from mysql.connector import Error

def create_connection(host_name, user_name, user_password):
    connection = None
    try:
        connection = mysql.connector.connect(
            host=host_name,
            user=user_name,
            passwd=user_password
        )
        print("Connection to MySQL DB successful")
    except Error as e:
        print(f"The error '{e}' occurred")

    return connection

connection = create_connection("localhost", "root", "")

filePath = "Testing.txt"
file_size = os.stat(filePath)







print('Content-Type: application/download')
print('Content-Disposition: attachment; filename="Testing.txt"')
print('')

#print("Content-Length: " + file_size.st_size)

with open(filePath, "r") as f:
       
    print(f.read())
#fclose($fp);