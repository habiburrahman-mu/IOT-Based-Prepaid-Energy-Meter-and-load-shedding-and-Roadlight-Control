#include <Wire.h>
#include <UIPEthernet.h>

String user_id = "000001", password = "123456";
float kwh = 0;
char val = '0';
unsigned long previousMillis = 0;
unsigned long previousMillis_cnct_get = 0;
unsigned long previousMillis_cnct_send = 0;
unsigned long currentMillis ;
unsigned long currentMillis_cnct_get;
unsigned long currentMillis_cnct_send;
const int interval = 2000;
const int interval_cnct_get = 10000;
const int interval_cnct_send = 7000;

byte mac[] =
{
  0xDE, 0xAD, 0xBE, 0xFF, 0xFE, 0xDD
};

IPAddress ip(192, 168, 0, 10);
char server[] = "192.168.0.113";
EthernetClient client;

void setup() {
  Wire.begin();
  pinMode(7, OUTPUT);
  Ethernet.begin(mac, ip);
  Serial.begin(9600);
  client.connect(server, 80);
}
void loop()
{
  currentMillis_cnct_get = millis();
  if (currentMillis_cnct_get - previousMillis_cnct_get >= interval_cnct_get)
  {
    Serial.println("Get Connecting....");
    if (client.connected())
    {
      client.println("GET /bill/senddata.php HTTP/1.1");
      client.println("Host: 192.168.0.113");
      //client.println("Connection: close");
      client.println();

      client.print("GET /bill/getdata.php?");
      client.print("user=");
      client.print(user_id);
      client.print("&");
      client.print("pass=");
      client.print(password);
      client.print("&");
      client.print("kwh=");
      Serial.println(kwh);
      client.print(kwh);
      Serial.println("Data Sent");
      client.println(" HTTP/1.1");
      client.println("Host: 192.168.0.113");
      client.println();

      previousMillis_cnct_get = millis();
      while (client.connected())
      {
        String line = client.readStringUntil('\n');
        if ( line == "\r") {
          Serial.println("Collected Data");
          break;
        }
      }
      String line = client.readStringUntil('\n');

      if (line.startsWith("000001Msg:"))
      {
        val = line[10];
        Serial.println(val);
      }
    }
    else
    {
      Serial.println("Connection failed");
      client.connect(server, 80);
      Serial.println("Connection Done Again");
      
      Serial.println();
      previousMillis_cnct_get = millis();
    }
    if (val == '1')
    {
      Serial.println("Light On");
      Serial.println();
      digitalWrite(7, HIGH);
    }
    else if (val == '0')
    {
      Serial.println("Light Off");
      Serial.println();
      digitalWrite(7, LOW);
    }
  }
  currentMillis = millis();
  if (currentMillis - previousMillis >= interval)
  {
    previousMillis = currentMillis;
    Wire.requestFrom(8, 8);
    while (Wire.available())
    {
      String s = Wire.readString();
      kwh = s.toFloat();
      Serial.println(kwh);
    }
  }


}
