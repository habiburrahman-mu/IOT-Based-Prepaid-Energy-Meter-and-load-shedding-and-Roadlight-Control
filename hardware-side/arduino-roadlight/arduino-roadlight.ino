#include <SPI.h>
#include <UIPEthernet.h>

String S;
byte mac[] = {
  0xDE, 0xA3, 0xBF, 0xEF, 0xFE, 0xED
};

IPAddress ip(192, 168, 0, 12);

EthernetClient client;

char server[] = "192.168.0.113";

unsigned long lastConnectionTime = 0;             // last time you connected to the server, in milliseconds
const unsigned long postingInterval = 2L * 1000L; // delay between updates, in milliseconds

void setup() {
  //Serial.begin(9600);
  pinMode(3, OUTPUT);
  digitalWrite(3, LOW);
  Ethernet.begin(mac, ip);
  client.connect(server, 80);
}

void loop() {
  if (millis() - lastConnectionTime > postingInterval) {
    httpRequest();
  }
  while (client.connected())
  {
    String line = client.readStringUntil('\n');
    if ( line == "\r") {
      break;
    }
  }
  String line = client.readStringUntil('\n');
  if (line.startsWith("Msg:")) {
    char val = line[4];
    //Serial.println(val);
    if (val == '1') {
      //Serial.println("Road Light: Off");
      digitalWrite(3, LOW);
    }
    else if (val == '2') {
      //Serial.println("Road Light: On");
      digitalWrite(3, HIGH);
    }
  }
}
void httpRequest() {
  //client.stop();
  if (client.connect(server, 80)) {
    //Serial.println("connecting...");
    client.println("GET /bill/rlsd.php HTTP/1.1");
    client.println("Host: localhost");
    client.println("Connection: close");
    client.println();

    lastConnectionTime = millis();
  }
  else {
    //Serial.println("connection failed");
  }
}


