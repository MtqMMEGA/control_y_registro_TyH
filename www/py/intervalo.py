import MySQLdb                                               
import sys                                                   
import time                                                  
                                               
host = "127.0.0.1"                                           
user = "root"                                                
passw = "pfc++"                                       
base = "bd_registro"                                             

db= MySQLdb.connect(host,user,passw,base)
cur = db.cursor()    
cur.execute(""" SELECT intervalo from configuracion where id=1 """)
resultado = cur.fetchall()
for campo in resultado:
	t_max = campo[0]
	print t_max
	db.close()
	sys.exit(1)  