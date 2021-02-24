

// Bibliotecas
#define fonte D2
#define led D5
#define ldr A0
#include <ESP8266WiFi.h>
#include <ESP8266SMTPClient.h>
#include <WiFiUdp.h>
#include <TimeLib.h>
const char* host = "192.168.27.20"; // ip da máquina 
int est_sensor = 0;  // variaveis do banco de dados
int luz = 0;
const char* est_luz = "Faltou%20Luz"; // variaveis do banco de dados
const char* est_luz2 = "Luz%20Voltou";  // variaveis do banco de dados

// Wi-Fi0
const char* ssid        =  // nome wifi 
const char* password    =  // senha wifi

// Parametros para o envio
const char* smtp_server = "smtp.gmail.com";
const int   smtp_port   = 465 ;
const char* smtp_user   = //seuemail@gmail.com
const char* smtp_pass   = //sua senha

// Instancias
SMTPClient smtp;

time_t timeNTP() {
  // Obtem data/hora do Servidor NTP
  if (WiFi.status() != WL_CONNECTED) {
    return 0;
  }
  const char  NTP_SERVER[]    = "pool.ntp.br";
  const byte  NTP_PACKET_SIZE = 48;
  const int   UDP_LOCALPORT   = 2390;
  byte        ntp[NTP_PACKET_SIZE];
  memset(ntp, 0, NTP_PACKET_SIZE);
  ntp[ 0] = 0b11100011;
  ntp[ 1] = 0;
  ntp[ 2] = 6;
  ntp[ 3] = 0xEC;
  ntp[12] = 49;
  ntp[13] = 0x4E;
  ntp[14] = 49;
  ntp[15] = 52;
  WiFiUDP udp;
  udp.begin(UDP_LOCALPORT);
  udp.beginPacket(NTP_SERVER, 123);
  udp.write(ntp, NTP_PACKET_SIZE);
  udp.endPacket();
  delay(1000);
  unsigned long l;
  if (udp.parsePacket()) {
    udp.read(ntp, NTP_PACKET_SIZE);
    l = word(ntp[40], ntp[41]) << 16 | word(ntp[42], ntp[43]);
    l -= 2208988800UL;
    Serial.println("Data/Hora atualizada");
  } else {
    l = 0;
    Serial.println("Falha obtendo Data/Hora");
  }
  return l;
}

String dateTimeRFC2822(time_t t) {
  // Retorna time_t como Date/Time conforme RFC2822
  String s = String(day(t))         + ' ' +
             monthShortStr(month()) + ' ' +
             String(year(t))        + ' ';
  if (hour(t) < 10) {
    s += '0';
  }
  s += String(hour(t)) + ':';
  if (minute(t) < 10) {
    s += '0';
  }
  s += String(minute(t)) + ':';
  if (second(t) < 10) {
    s += '0';
  }
  s += String(second(t)) + " +0000";
  return s;
}

void setup() {
  pinMode(fonte, OUTPUT); // declaração de variveis como saida
  pinMode(led, OUTPUT); // declaração de variveis como saida
  pinMode(ldr, INPUT); // declaração de variveis como entrada
  Serial.begin(115200);
  delay(10);


  Serial.println();
  Serial.println();
  Serial.print("Conectando a "); // conexao wifi 
  Serial.println(ssid);
  digitalWrite(led, HIGH);

  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi conectado");
  Serial.println("Endereço IP: ");
  Serial.println(WiFi.localIP());

  // Define NTP
  setSyncProvider(timeNTP);
  setSyncInterval(60 * 60 * 3); // 60s x 60m x 3h

}

void loop() {
  est_sensor = digitalRead(fonte);  // ler estado variavel fonte
  int luz = analogRead(A0); // declara como inteiro variavel luz e ler o seu valor analogico
  luz = map(luz, 0, 1024, 0, 255); // mapeia os seus valores analogicos de 1024 para 255
  Serial.println(luz);
  delay(500);
  if (est_sensor == 1 && luz > 200) { // lógica simples
    Serial.println("LUZ ACESSA");
    delay(500);
  } else if (est_sensor == 0 ) {
    Serial.println("A LUZ CAIU");
    Serial.println(luz);
    digitalWrite(led, LOW);
    envia();
    conecta();
    delay(10000);
  } if (est_sensor == 0 && luz < 200) {
    return loop();
  } else if (luz < 200) {
    Serial.println("A LUZ VOLTOU");
    envia2();
    conecta2();
    delay(6000);
  } if (est_sensor == 1 && luz < 200) {
    delay(6000);
    return setup();

  } else if (est_sensor == 0) {

  } // final lógica
}


void envia() { // função para envio de e-mail queda energia

  // Envia E-Mail
  smtp.begin(smtp_server, smtp_port);

  // Cabecalhos adicionais
  smtp.addHeader("Content-Type", "text/html; charset=UTF-8");
  smtp.addHeader("Content-Transfer-Encoding", "8bit");
  smtp.addHeader("Date", dateTimeRFC2822(now()));
  smtp.setMailer("ESP8266");

  // Autentica usuario
  smtp.setAuthorization(smtp_user, smtp_pass);

  // Dados ds Mensagem
  String from     = //seuemail@gmail.com
  String to       = //emaildestinario@gmail.com
  String message  = "<h1>Faltou luz</h1>"; // mensagem
  String subject  = "ALERTA";

  // Envia E-Mail
  int result = smtp.sendMessage(from.c_str(),
                                message.c_str(),
                                message.length(),
                                to.c_str(),
                                subject.c_str());

  // Exibe resultado
  Serial.printf("Resultado: %i %s %s\n", result, smtp.getErrorMessage(),
                smtp.errorToString(result).c_str());

  // Encerra
  smtp.end();
  smtp.disconnect();
  Serial.println("Concluído.");

}
 
void conecta() { //função conectar com banco de dados queda energia


  Serial.print("Conectando com ");
  Serial.println(host);

  // Use WiFiClient class to create TCP connections
  WiFiClient client;
  const int httpPort = 85;
  if (!client.connect(host, httpPort)) {
    Serial.println("Falha na conexao");
    return;
  }

  // We now create a URI for the request
  String url = "/fortecalerta/salvar2.php?";
  url += "est_sensor=";
  url +=   est_sensor;
  url += "&est_luz=";
  url +=  est_luz;
  Serial.print("Requesting URL: ");
  Serial.println(url);

  // This will send the request to the server
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" +
               "Connection: close\r\n\r\n");
  unsigned long timeout = millis();
  while (client.available() == 0) {
    if (millis() - timeout > 5000) {
      Serial.println(">>> Client Timeout !");
      client.stop();
      return;
    }
  }

  // Read all the lines of the reply from server and print them to Serial
  while (client.available()) {
    String line = client.readStringUntil('\r');
    //Serial.print(line);

    if (line.indexOf("salvo_com_sucesso") != -1) {
      Serial.println();
      Serial.println("Foi salvo com sucesso!");
    } else if (line.indexOf("erro_ao_salvar") != -1) {
      Serial.println();
      Serial.println("Ocorreu um erro");

    }

  }
  Serial.println();
  Serial.println("conexao fechada");

  delay(5000);
}
void envia2() { // função para envio de e-mail2 de retorno de energia

  // Envia E-Mail
  smtp.begin(smtp_server, smtp_port);

  // Cabecalhos adicionais
  smtp.addHeader("Content-Type", "text/html; charset=UTF-8");
  smtp.addHeader("Content-Transfer-Encoding", "8bit");
  smtp.addHeader("Date", dateTimeRFC2822(now()));
  smtp.setMailer("ESP8266");

  // Autentica usuario
  smtp.setAuthorization(smtp_user, smtp_pass);

  // Dados ds Mensagem
  String from     = //seuemail@gmail.com
  String to       = //emaildestianrio@gmail.com
  String message  = "<h1>A Luz Voltou</h1>";
  String subject  = "ALERTA";

  // Envia E-Mail
  int result = smtp.sendMessage(from.c_str(),
                                message.c_str(),
                                message.length(),
                                to.c_str(),
                                subject.c_str());

  // Exibe resultado
  Serial.printf("Resultado: %i %s %s\n", result, smtp.getErrorMessage(),
                smtp.errorToString(result).c_str());

  // Encerra
  smtp.end();
  smtp.disconnect();
  Serial.println("Concluído.");


}

void conecta2() {//função conectar com banco de dados 2 para retorno de energia


  Serial.print("Conectando com ");
  Serial.println(host);

  // Use WiFiClient class to create TCP connections
  WiFiClient client;
  const int httpPort = 85; // porta http 
  if (!client.connect(host, httpPort)) {
    Serial.println("Falha na conexao");
    return;
  }

  // We now create a URI for the request
  String url = "/fortecalerta/salvar3.php?";
  url += "luz=";
  url +=   luz;
  url += "&est_luz2=";
  url +=  est_luz2;
  Serial.print("Requesting URL: ");
  Serial.println(url);

  // This will send the request to the server
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" +
               "Connection: close\r\n\r\n");
  unsigned long timeout = millis();
  while (client.available() == 0) {
    if (millis() - timeout > 5000) {
      Serial.println(">>> Client Timeout !");
      client.stop();
      return;
    }
  }

  // Read all the lines of the reply from server and print them to Serial
  while (client.available()) {
    String line = client.readStringUntil('\r');
    //Serial.print(line);

    if (line.indexOf("salvo_com_sucesso") != -1) {
      Serial.println();
      Serial.println("Foi salvo com sucesso!");
    } else if (line.indexOf("erro_ao_salvar") != -1) {
      Serial.println();
      Serial.println("Ocorreu um erro");

    }

  }
  Serial.println();
  Serial.println("conexao fechada");

  delay(5000);
}
