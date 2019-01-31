#!/usr/bin/python
from subprocess import Popen
import sys

filename = sys.argv[1]
command = sys.argv[2]
while True:
    print("\nStarting " + filename)
    p = Popen("python " + filename + " " + command, shell=True)
    p.wait()