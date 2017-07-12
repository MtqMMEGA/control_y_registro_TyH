#include "dht.h"
#include <LiquidCrystal.h>
#define DHTPIN 6
#define DHTTYPE DHT11 
#define LED 7
#define LED_ERROR 8
DHT dht(DHTPIN, DHTTYPE);
LiquidCrystal lcd(12, 11, 5, 4, 3, 2);


void setup() {
Serial.begin(9600);
lcd.begin(16, 2);
dht.begin();
pinMode(LED, OUTPUT);
pinMode(LED_ERROR, OUTPUT);
}

void loop() {
float h = dht.readHumidity();
float t = dht.readTemperature();
if (isnan(t) || isnan(h)) {
  Serial.println("Failed to read from DHT");
  }
else {
  lcd.setCursor(0,0);
  lcd.print("Temp=");
  lcd.print(t);
  lcd.print("oC");
  lcd.setCursor(0,1);
  lcd.print("Humedad=");
  lcd.print(h);
  lcd.print("% ");
  delay(500);
  digitalWrite(LED, HIGH);   // turn the LED on (HIGH is the voltage level)
  digitalWrite(LED_ERROR, HIGH);   // turn the LED on (HIGH is the voltage level)
  delay(1000);               // wait for a second
  digitalWrite(LED, LOW);    // turn the LED off by making the voltage LOW
  digitalWrite(LED_ERROR, LOW);    // turn the LED off by making the voltage LOW
  delay(1000);               // wait for a second
 }
}
