# coding=utf-8
import MySQLdb                                               
import sys                                                   
import time            
import smtplib
import mimetypes
from email.MIMEText import MIMEText
from email.Encoders import encode_base64

                                                            
host = "127.0.0.1"                                           
user = "root"                                                
passw = "pfc++"                                       
base = "bd_registro"                                             
                                                             
tiempo = time.strftime("%Y/%m/%d %H:%M:%S", time.localtime())

db= MySQLdb.connect(host,user,passw,base)
cur = db.cursor()    
cur.execute(""" SELECT email, alertas from configuracion """)
fila = cur.fetchall()

for campo in fila: 
	email = campo[0]
	alertas = campo[1]

if (alertas==1):

	# Construimos el mensaje simple
	if (sys.argv[1]>sys.argv[2]):
		if (sys.argv[3]>sys.argv[4]):	
			mensaje = MIMEText("""Alerta: Temperatura y Humedad superadas""")
			mensaje['Subject']="Alerta de Temperatura: "+sys.argv[1] + "ºC (T. MAX: "+sys.argv[2]+"ºC ) y Humedad: "+sys.argv[3] + "% (H. MAX: "+sys.argv[4]+"% ) "
			#mensaje['Subjet']="Prueba"
		else:
			mensaje = MIMEText("""Alerta: Temperatura superada""")	
			mensaje['Subject']="Alerta de Temperatura: "+sys.argv[1] + "ºC (T. MAX: "+sys.argv[2]+"ºC ) "
	else:

		if (sys.argv[3]>sys.argv[4]):	
			mensaje = MIMEText("""Alerta: Humedad superada""")
			mensaje['Subject']="Alerta de Humedad: "+sys.argv[3] + "% (H. MAX: "+sys.argv[4]+"% ) "
		
	
	
	#mensaje = MIMEText("""Alerta: Temperatura y/o Humedad superadas""")
	mensaje['From']="registrodealertas@gmail.com"
	#mensaje['To']="jesus.lema@gmail.com"
	mensaje['To']= email
	#mensaje['Subject']="Alerta de Temperatura/Humedad"
	
	# Establecemos conexion con el servidor smtp de gmail
	mailServer = smtplib.SMTP('smtp.gmail.com',587)
	mailServer.ehlo()
	mailServer.starttls()
	mailServer.ehlo()
	mailServer.login("registrodealertas@gmail.com","pfc++pfc++")
	
	# Envio del mensaje
	mailServer.sendmail("registrodealertas@gmail.com",
					"jesus.lema@gmail.com",
					mensaje.as_string())
	
	# Cierre de la conexion
	mailServer.close()

cur.close()
db.close()
	
db= MySQLdb.connect(host,user,passw,base)
cur = db.cursor()    
resultado = cur.execute(""" INSERT INTO registro_errores (temp, temp_max, humedad, humedad_max, fecha ) VALUES (%s,%s,%s,%s,%s) """,(sys.argv[1],sys.argv[2],sys.argv[3],sys.argv[4], tiempo,))
if (resultado == 1 ):
        print 1    
        sys.exit(1)        
else:                
        print 2                
        sys.exit(1) 
cur.close()
db.close()

#db= MySQLdb.connect(host,user,passw,base)
#cur = db.cursor()    
#resultado = cur.execute(""" INSERT INTO registro (temp, humedad, fecha ) VALUES (%s,%s,%s) """,(sys.argv[1],sys.argv[3], tiempo,))
#if (resultado == 1 ):
#        print 1    
#        sys.exit(1)        
#else:                
#        print 2                
#        sys.exit(1) 
#cur.close()
#db.close()