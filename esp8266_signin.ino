#include <ESP8266WiFi.h>
#include <Arduino.h>
#include <ArduinoJson.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include <SPI.h>
#include <RFID.h>

#define SS_PIN D2
#define RST_PIN D1

RFID rfid(SS_PIN, RST_PIN);

String payload;
int status_c;
int serNum0;
int serNum1;
int serNum2;
int serNum3;
int serNum4;

int buzzPin = D4;

const char* ssid     = "NRTECH_TV";
const char* password = "12345678";

const char* host = "202.29.239.19";  //ใส่ IP หรือ Host ของเครื่อง Database ก็ได้

void setup() {
  pinMode(buzzPin,OUTPUT);
  SPI.begin();
  rfid.init();
  Serial.begin(9600);
  delay(10);
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");  
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());

  while (!Serial); 
  delay(100);
}

void loop() {
  digitalWrite(buzzPin,LOW);
  delayMicroseconds(50);
  // recive();
  delayMicroseconds(50);
  // Serial.println(status_c);
  if (rfid.isCard()) {
    if (rfid.readCardSerial()) {
      rfid_read();
      send();
      digitalWrite(buzzPin,HIGH);
      delay(200);
      digitalWrite(buzzPin,LOW);
      delay(200);
      digitalWrite(buzzPin,HIGH);
    }
  }
  
}
void send(){
  // Send an HTTP POST request depending on timerDelay
    //Check WiFi connection statusr
    if(WiFi.status()== WL_CONNECTED){
      WiFiClient client;
      HTTPClient http;
      String serverName = "http://202.29.239.19/signin_rfid/register_stdinfo.php";
      String serverPath = serverName + "?serNum0=" + serNum0 + "&serNum1=" + serNum1 + "&serNum2=" + serNum2 + "&serNum3=" + serNum3 + "&serNum4=" + serNum4;
      
      // Your Domain name with URL path or IP address with path
      http.begin(client, serverPath.c_str());
  
      // If you need Node-RED/server authentication, insert user and password below
      //http.setAuthorization("REPLACE_WITH_SERVER_USERNAME", "REPLACE_WITH_SERVER_PASSWORD");
        
      // Send HTTP GET request
      int httpResponseCode = http.GET();
      
      // if (httpResponseCode>0) {
      //   Serial.print("HTTP Response code: ");
      //   Serial.println(httpResponseCode);
      //   String payload = http.getString();
      //   Serial.println(payload);
      // }
      // else {
      //   Serial.print("Error code: ");
      //   Serial.println(httpResponseCode);
      // }
      // Free resources
      http.end();
    }
    else {
      Serial.println("WiFi Disconnected");
    }

}
void recive(){
    if(WiFi.status()== WL_CONNECTED){
      WiFiClient client;
      HTTPClient http;
      String serverName = "http://10.251.83.142/signin_rfid/check_rfid.php";
      String serverPath = serverName;
      
      http.begin(client, serverPath.c_str());
  
      int httpResponseCode = http.GET();
      
      if (httpResponseCode>0) {
        Serial.print("HTTP Response code: ");
        Serial.println(httpResponseCode);
        payload = http.getString();
      }
      else {
        Serial.print("Error code: ");
        Serial.println(httpResponseCode);
      }
        DynamicJsonDocument doc(1024);
        deserializeJson(doc, payload);

        String status = doc["status"];
        status_c = status.toInt();

      http.end();
    }
    else {
      Serial.println("WiFi Disconnected");
    }
}
void rfid_read(){

      if (rfid.serNum[0] != serNum0 || rfid.serNum[1] != serNum1 || rfid.serNum[2] != serNum2 || rfid.serNum[3] != serNum3 || rfid.serNum[4] != serNum4) {
        /* With a new cardnumber, show it. */
        Serial.println(" ");
        Serial.println("Card found");
        serNum0 = rfid.serNum[0];
        serNum1 = rfid.serNum[1];
        serNum2 = rfid.serNum[2];
        serNum3 = rfid.serNum[3];
        serNum4 = rfid.serNum[4];

        Serial.println("Cardnumber:");
        Serial.print("Dec: ");
        Serial.print(rfid.serNum[0], DEC);
        Serial.print(", ");
        Serial.print(rfid.serNum[1], DEC);
        Serial.print(", ");
        Serial.print(rfid.serNum[2], DEC);
        Serial.print(", ");
        Serial.print(rfid.serNum[3], DEC);
        Serial.print(", ");
        Serial.print(rfid.serNum[4], DEC);
        Serial.println(" ");

        Serial.print("Hex: ");
        Serial.print(rfid.serNum[0], HEX);
        Serial.print(", ");
        Serial.print(rfid.serNum[1], HEX);
        Serial.print(", ");
        Serial.print(rfid.serNum[2], HEX);
        Serial.print(", ");
        Serial.print(rfid.serNum[3], HEX);
        Serial.print(", ");
        Serial.print(rfid.serNum[4], HEX);
        Serial.println(" ");
        //buzzer
        analogWrite(3, 20);
        delay(500);
        analogWrite(3, 0);
      } else {
        /* If we have the same ID, just write a dot. */
        Serial.print(".");
      }
    
  
  rfid.halt();
}
