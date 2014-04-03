# Pi Meter

Monitoring an electricity meter with the Raspberry Pi.

The electricity meter has an LED which pulses once every time a watt of electricity is used.

### Meter type:

![Meter image](meter.png)

### Circuit diagram:

![Circuit Diagram](Meter2Pi.png)

## Summary

A log file (upCountDelta.txt) is used to store the system uptime (up), an integer (count) and the interval since the last pulse (interval).

Each time a pulse is detected, the current system uptime and the log file are read. We can then find the time interval since the last pulse and update the log file with current uptime, incremented count, and latest interval.

The log file can now be used to find the current meter reading (count/1000 + originalReading) and the hourly cost.
