#include <Wire.h>
#include <SPI.h>
#include <SD.h>

int meter_count = 0, count = 0, data_size = 8, reset_data=0;
bool state = 0, lastState = 0;
float kwh = 0.00;
char send_data[8];

File myFile;

void setup()
{
  pinMode(A0, INPUT);
  Serial.begin(9600);
  Wire.begin(8);
  Wire.onRequest(requestEvent);
  Wire.onReceive(Receive);
  

  if (!SD.begin(4))
  {
    Serial.println("initialization failed!");
    return;
  }
  Serial.println("initialization done.");
  readCount();
  readKWH();
}

void loop()
{
  Wire.onReceive(Receive);
  if(reset_data==1)
  {
    kwh=0;
    writeKWH();
    reset_data=0;
  }
  meter_count = analogRead(A0);
  //Serial.print("Count: ");
  //Serial.println(count);
  if (meter_count > 300)
  {
    state = 1;
    if (lastState != state)
    {
      count++;
      writeCount();
      //save to sd
    }
  }
  else
  {
    state = 0;
  }
  lastState = state;
  
  if (count == 16)
  {
    kwh = kwh + 0.01;
    writeKWH();
    count = 0;
    writeCount();
  }
}
void requestEvent() {
  dtostrf(kwh, data_size, data_size, send_data);
  Wire.write(send_data);
  Serial.println(kwh);
  Serial.println(count);
}
void Receive(){
  while(Wire.available()>0){
    String s = Wire.readString();
    reset_data = s.toInt();
    Serial.println(reset_data);
    Serial.println("Reset Done");
  }
}
void writeCount()
{
  myFile = SD.open("count.txt", O_WRITE | O_CREAT | O_TRUNC);
  if (myFile)
  {
    Serial.print("Writing to count.txt...");
    myFile.seek(0);
    myFile.print(count);
    if (count < 10)
    {
      myFile.seek(1);
      myFile.print("-");
    }
    myFile.close();
    Serial.println("done.");
  }
  else
  {
    // if the file didn't open, print an error:
    Serial.println("error opening count.txt");
  }
}
void readCount()
{
  myFile = SD.open("count.txt");
  if (myFile)
  {
    Serial.print("Read from count.txt...");
    while (myFile.available())
    {
      String a = myFile.readString();
      count = a.toInt();
    }
    myFile.close();
    Serial.println("done.");
  }
  else
  {
    // if the file didn't open, print an error:
    Serial.println("error opening count.txt");
  }
}
void writeKWH()
{
  unsigned int b = (int)kwh;
  int c = 0;
  if (b < 10)
  {
    c = 1;
  }
  else if (b < 100)
  {
    c = 2;
  }
  else if (b < 1000)
  {
    c = 3;
  }
  else if (b < 10000)
  {
    c = 4;
  }
  myFile = SD.open("kwh.txt", O_WRITE | O_CREAT | O_TRUNC);
  if (myFile)
  {
    Serial.print("Writing to kwh.txt...");
    myFile.seek(0);
    myFile.print(kwh);
    myFile.seek(c+3);
    myFile.print("-");
    myFile.close();
    Serial.println("done.");
  }
  else
  {
    // if the file didn't open, print an error:
    Serial.println("error opening kwh.txt");
  }


}
void readKWH()
{
  myFile = SD.open("kwh.txt");
  if (myFile)
  {
    Serial.print("Read from kwh.txt...");
    while (myFile.available())
    {
      String a = myFile.readString();
      kwh = a.toFloat();
    }
    myFile.close();
    Serial.println("done.");
  }
  else
  {
    // if the file didn't open, print an error:
    Serial.println("error opening kwh.txt");
  }
}


