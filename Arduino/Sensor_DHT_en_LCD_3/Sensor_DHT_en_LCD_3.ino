#include "dht.h"
#include <LiquidCrystal.h>
#include <Bridge.h>
#include <Process.h>


#define DHTPIN 6
#define DHTTYPE DHT11 
#define LED 7
#define LED_ERROR 8
#define BUZZER 9

DHT dht(DHTPIN, DHTTYPE);
LiquidCrystal lcd(12, 11, 5, 4, 3, 2);



Process date;

void setup()
{
  Serial.begin(9600);
  lcd.begin(16, 2);
  dht.begin();
  pinMode(LED, OUTPUT);
  pinMode(LED_ERROR, OUTPUT);
  pinMode(BUZZER, OUTPUT);
  Bridge.begin(); // Iniciamos todos los procesos de Bridge

  /*---Inicio del proceso para obtener el tiempo ---*/
  if (!date.running())
  {
    date.begin("date");
    date.addParameter("+%T");
    date.run();
  }
  /*--- FIN del proceso para obtener el tiempo ---*/
  
  digitalWrite(LED, HIGH);   // Encendemos el LED verde para indicar que está funcionando
  beep(50);
  mensajeBienvenida(); //Muestra el mensaje de bienvenida en el LCD
  Serial.println("Procesos iniciados.");
  Serial.println("Listo para leer");
  beep(50);
  beep(50);
  beep(50);    
}


void loop() 
{
  int T_MAX;
  int H_MAX;
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  if (isnan(t) || isnan(h)) 
  {
    Serial.println("Failed to read from DHT");
    beep(200); 
    digitalWrite(LED_ERROR, HIGH);   // Encendemos el LED rojo indicando que la lectura ha fallado
    delay(1000);
    beep(200); 
    digitalWrite(LED_ERROR, LOW);    // Apagamos el LED rojo e iniciamos una nueva lectura
    delay(1000);
    beep(200); 
  }
  else
  {
    digitalWrite(LED, LOW);    // apagamos el LED verde para indicar que hemos hecho una lectura
    delay(500);
    digitalWrite(LED, HIGH);   // volvemos a encender el LED 
    MostrarDatosLCD(t,h);
    RegistroTyH(t,h); 
    MostrarDatosLCD(t,h);
    T_MAX = TemperaturaMaxima();
    H_MAX = HumedadMaxima();
    
    if (t>T_MAX || h>H_MAX)
    {
      digitalWrite(LED_ERROR, HIGH);    
      beep(200); 
      delay(500);
      beep(200); 
      delay(500);
      beep(200);
      beep(200); 
      delay(500);
      beep(200); 
      delay(500);
      
      Error_T_H(t,T_MAX,h,H_MAX);
      
      //Esperamos Intervalo - Calculo de tiempo gastado
      delay(1000);  
    }    
    else
    {
      digitalWrite(LED_ERROR, LOW);
      //Esperamos Intervalo - Calculo de tiempo gastado
      delay(1000);               // wait for a second  
    }
  }
}



/* --------- Este es el mesaje de bienvenida que se muestra en el LCD Display, con la hora ---*/
void mensajeBienvenida(){
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("TyH Logger");
  lcd.setCursor(0, 1);
  lcd.print("Bienvenido");
  delay(8000);
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Los procesos se ");
  lcd.setCursor(0, 1);
  lcd.print("estan iniciando");
  delay(20000);
  lcd.clear();
}


/* --------- Mensaje que muestra en el LCD Display la Temperatura y la Humedad ---*/
void MostrarDatosLCD(int t,int h){
    lcd.setCursor(0,0);
    lcd.print("Temperatura=");
    lcd.print(t);
    lcd.print((char)223);
    lcd.print("C");
    lcd.setCursor(0,1);
    lcd.print("Humedad=");
    lcd.print(h);
    lcd.print("% ");
}

/*----- Con esta funcion obetenmos un String con el tiempo del Arduino YUN -----*/
String tiempo(){
  Process date;
  date.begin("date");
  date.addParameter("+%T");
  date.run();
  if (date.available()) {
    String timeString = date.readString();    
    return timeString;
  }
 date.close(); 
}


/*---------- esta es la funcion que envia los datos para guardar en la Base del Arduino en la tabla de ControlUsuarios -----*/
void RegistroTyH(float T, float H)
{
  Process registroTyH;
  registroTyH.begin("python");
  registroTyH.addParameter("/mnt/sda1/www/py/grabar.py");
  
  char buffer[10];
  String tem = dtostrf(T, 5, 2, buffer);
  String temp = (tem);
  String hum = dtostrf(H, 5, 2, buffer);
  String humedad = (hum);
  
  registroTyH.addParameter(temp);
  registroTyH.addParameter(humedad);
  //argv[1] Temperatura, argv[2] Humedad
  registroTyH.run();
  if (registroTyH.available())
  {
    String resultado = registroTyH.readString(); // respuesta
    lcd.clear();
    lcd.setCursor(0, 0);
    Serial.println("Se ha guardado");
    lcd.print("Se ha guardado");
    lcd.setCursor(0, 1);
    lcd.print("correctamente ");
    delay(1000);
    lcd.clear();
  }
  else
  {
    Serial.println("Fallo al grabar en la BD");
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Error al grabar");
    lcd.setCursor(0, 1);
    lcd.print("en la BD");    
    delay(1000);
    lcd.clear();
  }
}  

void Error_T_H(int T,int T_MAX,int H,int H_MAX)
{
  Process errorT_H;
  errorT_H.begin("python");
  errorT_H.addParameter("/mnt/sda1/www/py/errorT_H.py");
  
  char buffer[10];
  String temp = dtostrf(T, 5, 2, buffer);
  String t = (temp);
  String hum = dtostrf(H, 5, 2, buffer);
  String h = (hum);
  String tmax = dtostrf(T_MAX, 5, 2, buffer);
  String t_max = (tmax);
  String hmax = dtostrf(H_MAX, 5, 2, buffer);
  String h_max = (hmax);
  
  errorT_H.addParameter(t);
  errorT_H.addParameter(t_max);
  errorT_H.addParameter(h);
  errorT_H.addParameter(h_max);
  //argv[1] Temperatura, argv[2] Temperatura_maxima , argv[3] Humedad, argv[4] Humedad_maxima
  errorT_H.run();
  
  String resultado = errorT_H.readString(); // respuesta
  if (resultado.toInt() == 1)
  {  
    lcd.clear();
    lcd.setCursor(0, 0);
    Serial.println("Alerta de T_MAX/H_MAX grabada en BD");
    lcd.print("Alerta grabada");
    lcd.setCursor(0, 1);
    lcd.print("correctamente ");
    delay(1000);
    lcd.clear();
  }
  else
  {
    Serial.println("Fallo al grabar alerta en la BD");
    lcd.clear();
    lcd.setCursor(0, 0);
    lcd.print("Error al grabar");
    lcd.setCursor(0, 1);
    lcd.print("alerta en la BD");    
    delay(1000);
    lcd.clear();
  }
  
}

/*---------- Devuelve la Temperatura Máxima definida en la configuracion -----*/
int TemperaturaMaxima()
{
  Process T_Max;
  T_Max.begin("python");
  T_Max.addParameter("/mnt/sda1/www/py/t_max.py");
  T_Max.addParameter("&2>1"); // pipe error output to stdout
  T_Max.run();  
  String T_MAX = T_Max.readString(); // respuesta
  return T_MAX.toInt();
}  


/*---------- Devuelve la Humedad Máxima definida en la configuracion -----*/
int HumedadMaxima()
{
  Process H_Max;
  H_Max.begin("python");
  H_Max.addParameter("/mnt/sda1/www/py/h_max.py");
  H_Max.run();
  String H_MAX = H_Max.readString(); // respuesta
  return H_MAX.toInt();
}





/*FUNCION PARA EMITIR PITIDO POR EL BUZZER*/
void beep(unsigned char delayms){
  analogWrite(9, 20);      // Almost any value can be used except 0 and 255
                           // experiment to get the best tone
  delay(delayms);          // wait for a delayms ms
  analogWrite(9, 0);       // 0 turns it off
  delay(delayms);          // wait for a delayms ms   
}  
/*---------------------------------------------------------------------------------------------------------------------------------*/

