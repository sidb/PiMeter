#!/usr/bin/python

import RPi.GPIO as GPIO
import time
import subprocess
import smbus
bus = smbus.SMBus(0)
from datetime import timedelta

meterIps = [12]

def _setup():
  GPIO.setmode(GPIO.BOARD)
  for meterIp in meterIps:
    GPIO.setup(meterIp, GPIO.IN, GPIO.PUD_UP)

def _storeUpCountDelta():
  with open('/proc/uptime', 'r') as f:
    up = float(f.readline().split()[0])
  with open('/home/pi/inetpub/upCountDelta.txt', 'a+') as f:
    f.seek(0)
    arrLine1 = f.readline().split()
    if len(arrLine1) > 1:
      delta = up - float(arrLine1[0])
      count = 1 + int(arrLine1[1])
      f.seek(0)
      f.truncate()
      f.write ('{} {} {:.2f} //up count interval'.format(up, count, delta))

if __name__ == "__main__":
  _setup()
  while 1:
    val = GPIO.input(meterIps[0])
    if val:
      state = 1
    else:
      if state == 1:
        _storeUpCountDelta()
      state = 0
    time.sleep(0.001)
