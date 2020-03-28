import smtplib

smtpUser = 'bubblehome.care@gmail.com'
smtpPass = 'TeamBubble6!'

toAdd = 'rory.dobson@yahoo.com'
fromAdd = smtpUser

subject = 'Test'
header = 'To: ' + toAdd + '\n' + 'From: ' + fromAdd + '\n' + 'Subject: ' + subject
body = 'Testing'

print header + '\n' + body

s = smtplib.SMTP('smtp.gmail.com',587)

s.ehlo()
s.starttls()
s.ehlo()

s.login(smtpUser, smtpPass)
s.sendmail(fromAdd, toAdd, header + '\n\n' + body)

s.quit()
