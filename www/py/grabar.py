import MySQLdb                                               
import sys                                                   
import time                                                  




                                                             
host = "127.0.0.1"                                           
user = "root"                                                
passw = "pfc++"                                       
base = "bd_registro"                                             
                                                             
                                                             
tiempo = time.strftime("%Y/%m/%d %H:%M:%S", time.localtime())


db= MySQLdb.connect(host,user,passw,base)
cur = db.cursor()    
resultado = cur.execute(""" INSERT INTO registro (temp, humedad, fecha ) VALUES (%s,%s,%s) """,(sys.argv[1],sys.argv[2], tiempo,))
if (resultado == 1 ):
        print 1    
        sys.exit(1)        
else:                
        print 2                
        sys.exit(1) 
cur.close()
db.close()