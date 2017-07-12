#include "dht.h"
#include <LiquidCrystal.h>
#include <Bridge.h>
#include <Process.h>


#define DHTPIN 6
#define DHTTYPE DHT11 
#define LED 7
#define LED_ERROR 8
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
  Bridge.begin(); // Iniciamos todos los procesos de Bridge

  /*---Inicio del proceso para obtener el tiempo ---*/
  if (!date.running())
  {
    date.begin("date");
    date.addParameter("+%T");
    date.run();
  }
  /*--- FIN del proceso para obtener el tiempo ---*/
  
  mensajeBienvenida(); //Muestra el mensaje de bienvenida en el LCD
  
  Serial.println("Procesos iniciados.");
  Serial.println("Listo para leer");
  
  digitalWrite(LED, HIGH);   // Encendemos el LED verde para indicar que está funcionando
}


void loop() 
{
  float h = dht.readHumidity();
  float t = dht.readTemperature();
  if (isnan(t) || isnan(h)) 
  {
    Serial.println("Failed to read from DHT");
    digitalWrite(LED_ERROR, HIGH);   // Encendemos el LED rojo indicando que la lectura ha fallado
    delay(1000);
    digitalWrite(LED_ERROR, LOW);    // Apagamos el LED rojo e iniciamos una nueva lectura
  }
  else
  {
    digitalWrite(LED, LOW);    // apagamos el LED verde para indicar que hemos hecho una lectura
    delay(500);
    digitalWrite(LED, HIGH);   // volvemos a encender el LED 
    lcd.setCursor(0,0);
    lcd.print("Temp=");
    lcd.print(t);
    lcd.print("oC");
    lcd.setCursor(0,1);
    lcd.print("Humedad=");
    lcd.print(h);
    lcd.print("% ");
    RegistroTyH(t,h); 
    lcd.setCursor(0,0);
    lcd.print("Temp=");
    lcd.print(t);
    lcd.print("oC");
    lcd.setCursor(0,1);
    lcd.print("Humedad=");
    lcd.print(h);
    lcd.print("% ");

    delay(1000);               // wait for a second
  }
}



/* --------- Este es el mesaje de bienvenida que se muestra en el LCD Display, con la hora ---*/
void mensajeBienvenida(){
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Bienvenido");
  lcd.setCursor(0, 1);
  lcd.print("Son las:");
  lcd.print(tiempo());
  delay(8000);
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("Los procesos ya ");
  lcd.setCursor(0, 1);
  lcd.print("estan preparados");
  delay(8000);
  lcd.clear();
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

/*---------------------------------------------------------------------------------------------------------------------------------*/

