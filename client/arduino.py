import bluetooth
import time
import sys

args = sys.argv

if(args[1]):
	mac=args[1]
else :
	mac = "00:13:04:10:09:72";

nearby_devices = bluetooth.discover_devices()
port = 1
sock = bluetooth.BluetoothSocket(bluetooth.RFCOMM)

for device_addr in nearby_devices:
	device_name = bluetooth.lookup_name(device_addr)
	if device_addr==mac:
		counter = 0
		sock.connect((device_addr,port))
		while(counter<10):
			sock.send('Hello')
			time.sleep(2)
			counter += 1
		break
sock.close()
