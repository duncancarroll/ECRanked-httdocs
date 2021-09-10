import time
import sys
import os
import configparser
from pathlib import Path
config = configparser.ConfigParser()
d = Path(__file__).resolve().parents[1]
print(d)
config.read(f"{d}\config.ini")
api_key = config.get('config','api_key')


if sys.argv[1] != api_key:
    quit()

from shutil import copyfile
os.remove(sys.argv[2])
