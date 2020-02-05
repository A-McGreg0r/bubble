import pysftp, sys, os
host="raspberrypi"
User="pi"
file="state.json"
#python toggle.py DEVICE_ID{VARCHAR} STATE{BOOLEAN} 
#str(sys.argv[1])
  
def write_file(tmp):
  file = open(tmp, 'w')
  file.write('{\n')
  file.write('\t"device_id": "'+str(sys.argv[1])+'",\n')
  file.write('\t"state": "'+str(sys.argv[2])+'"\n')
  file.write('}\n')
  file.close() 

def sftp(host, User, file):
    with pysftp.Connection(host, username=User, private_key="~/.ssh/server") as sftp:
        with sftp.cd('json'):
            sftp.put(file)

write_file(file)
sftp(host, User, file)
