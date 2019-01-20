#include <SPI.h>
#include <UIPEthernet.h>

String S;
byte mac[] = {
  0xDE, 0xA2, 0xBE, 0xEF, 0xFE, 0xED
};

IPAddress ip(192, 168, 0, 11);

EthernetClient client;

char server[] = "192.168.0.113";

unsigned long lastConnectionTime = 0;             // last time you connected to the server, in milliseconds
const unsigned long postingInterval = 2L * 1000L; // delay between updates, in milliseconds

void setup() {
  //Serial.begin(9600);
  pinMode(3, OUTPUT);
  pinMode(4, OUTPUT);
  pinMode(5, OUTPUT);
  pinMode(6, OUTPUT);
  digitalWrite(3, LOW);
  digitalWrite(4, LOW);
  digitalWrite(5, LOW);
  digitalWrite(6, LOW);
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
      //Serial.println("Load Shedding in Area 1");
      digitalWrite(3, LOW);
      digitalWrite(4, HIGH);
      digitalWrite(5, HIGH);
      digitalWrite(6, HIGH);
    }
    else if (val == '2') {
      //Serial.println("Load Shedding in Area 2");
      digitalWrite(3, HIGH);
      digitalWrite(4, LOW);
      digitalWrite(5, HIGH);
      digitalWrite(6, HIGH);
    }
    else if (val == '3') {
      //Serial.println("Load Shedding in Area 3");
      digitalWrite(3, HIGH);
      digitalWrite(4, HIGH);
      digitalWrite(5, LOW);
      digitalWrite(6, HIGH);
    }
    else if (val == '4') {
      //Serial.println("Load Shedding in Area 4");
      digitalWrite(3, HIGH);
      digitalWrite(4, HIGH);
      digitalWrite(5, HIGH);
      digitalWrite(6, LOW);
    }
    else if (val == '5') {
      //Serial.println("All Supply on");
      digitalWrite(3, HIGH);
      digitalWrite(4, HIGH);
      digitalWrite(5, HIGH);
      digitalWrite(6, HIGH);
    }
    else if (val == '6') {
      //Serial.println("All Supply off");
      digitalWrite(3, LOW);
      digitalWrite(4, LOW);
      digitalWrite(5, LOW);
      digitalWrite(6, LOW);
    }
  }
}
void httpRequest() {
  //client.stop();
  if (client.connect(server, 80)) {
    //Serial.println("connecting...");
    client.println("GET /bill/lssd.php HTTP/1.1");
    client.println("Host: localhost");
    client.println("Connection: close");
    client.println();

    lastConnectionTime = millis();
  }
  else {
    //Serial.println("connection failed");
  }
}


