import sys, os, pysftp
filepath="device.json"
#os.system('cd /var/www/pysftp/www-data/')
def write_file(tmp):
  file = open(tmp, 'w')
  file.write('{\n')
#  file.write('\t"device": "'+sys.argv[1]+'",\n')
  file.write('\t"device": 7357,\n')
#  file.write('\t"state": "'+sys.argv[2]+'"\n')
  file.write('\t"state": 0\n')
  file.write('}\n')
  file.close()

write_file(filepath)
#os.system('cat device.json | sshpass -p pi ssh pi@bubble-hub "cat > /home/pi/notify/device.json" &')
