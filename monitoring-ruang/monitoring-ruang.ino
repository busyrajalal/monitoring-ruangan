#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <DHT.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

// ===== DHT11 =====
#define DHTPIN D4
#define DHTTYPE DHT11
DHT dht(DHTPIN, DHTTYPE);

// ===== WIFI =====
const char* ssid     = "BnR";
const char* password = "perkututmanggung";
const char* host     = "192.168.1.229";

// ===== LCD =====
LiquidCrystal_I2C lcd(0x27, 16, 2);

// ===== SENSOR GAS & BUZZER =====
#define GAS_PIN A0
#define BUZZER_PIN D5

// ===== AMBANG BATAS (THRESHOLD) =====
const int AMBANG_RAW_GAS = 400;   // Aktif jika nilai mentah > 400
const float AMBANG_ASAP  = 150.0; // Aktif jika kadar asap > 150 PPM
const float AMBANG_SUHU  = 40.0;  // Aktif jika suhu > 40.0 °C
const float LEMBAB_MIN   = 60.0;  // Aktif jika kelembapan di bawah 60%
const float LEMBAB_MAX   = 90.0;  // Aktif jika kelembapan di atas 90%

WiFiClient client;

void setup() {
  Serial.begin(115200);
  dht.begin();67
  
  lcd.init();
  lcd.backlight();

  // Inisialisasi Buzzer
  pinMode(BUZZER_PIN, OUTPUT);
  digitalWrite(BUZZER_PIN, LOW);

  // KONEK WIFI
  WiFi.begin(ssid, password);
  lcd.setCursor(0,0);
  lcd.print("SAMBUNG WIFI...");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("WIFI TERHUBUNG");
  delay(2000);
  lcd.clear();
}

void loop() {
  float suhu = dht.readTemperature();
  float hum  = dht.readHumidity();
  int gas    = analogRead(GAS_PIN);

  // Proteksi nilai gas 0 untuk menghindari error pembagian matematika
  int gas_calc = (gas < 1) ? 1 : gas; 

  // KALKULASI RUMUS KURVA MQ-135 (Pendekatan Nilai PPM)
  float rs_ro = (1023.0 / (float)gas_calc) - 1.0;
  if(rs_ro < 0.1) rs_ro = 0.1; // Batasi agar tidak infinity

  // Rumus eksponensial berdasarkan datasheet MQ-135
  float ppm_co2     = 110.47 * pow(rs_ro, -2.862);
  float ppm_amonia  = 102.20 * pow(rs_ro, -2.473);
  float ppm_benzena = 44.95 * pow(rs_ro, -3.424);
  float ppm_alkohol = 77.26 * pow(rs_ro, -3.180);
  float ppm_asap    = 159.60 * pow(rs_ro, -3.407);

  // ===== Cek Error Sensor DHT =====
  if (isnan(suhu) || isnan(hum)) {
    lcd.clear();
    lcd.setCursor(0,0);
    lcd.print("SENSOR ERROR!");
    lcd.setCursor(0,1);
    lcd.print("CEK DHT11");
    delay(2000);
    return;
  }

  // LOGIKA AMBANG BATAS MULTI-SENSOR & KONTROL BUZZER

  // Buzzer aktif jika: gas tinggi ATAU asap tinggi ATAU suhu > 40°C ATAU kelembapan < 60% ATAU kelembapan > 90%
  if (gas > AMBANG_RAW_GAS || ppm_asap > AMBANG_ASAP || suhu > AMBANG_SUHU || hum < LEMBAB_MIN || hum > LEMBAB_MAX) {
    digitalWrite(BUZZER_PIN, HIGH); // Buzzer Menyala
  } else {
    digitalWrite(BUZZER_PIN, LOW);  // Buzzer Mati
  }

  // TAMPILAN LCD BAHASA INDONESIA (BERGANTIAN)
  
  //  Suhu & Kelembapan Udara
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Suhu  : " + String(suhu, 1) + (char)223 + "C");
  lcd.setCursor(0,1);
  lcd.print("Lembab: " + String(hum, 0) + " %");
  delay(2000);

  //  CO2 (Karbon Dioksida) & Amonia
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("CO2  : " + String(ppm_co2, 1) + " PPM");
  lcd.setCursor(0,1);
  lcd.print("NH3  : " + String(ppm_amonia, 1) + " PPM");
  delay(2000);

  //  Benzena & Alkohol
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Benz   : " + String(ppm_benzena, 1) + " PPM");
  lcd.setCursor(0,1);
  lcd.print("Alkohol: " + String(ppm_alkohol, 1) + " PPM");
  delay(2000);

  // Asap & Nilai Mentah Analog Sensor
  lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("Asap : " + String(ppm_asap, 1) + " PPM");
  lcd.setCursor(0,1);
  lcd.print("Data Mentah:" + String(gas));
  delay(2000);

  // KIRIM DATA KE WEB SERVER (CODEIGNITER 4)
  HTTPClient http;

  // Menyusun URL GET dengan menambahkan semua parameter data baru
  String Link = "http://" + String(host) + "/monitoring-ruangan/terima-data/" 
              + String(suhu, 1) + "/" 
              + String(hum, 0) + "/" 
              + String(gas) + "/" 
              + String(ppm_co2, 1) + "/" 
              + String(ppm_amonia, 1) + "/" 
              + String(ppm_benzena, 1) + "/" 
              + String(ppm_alkohol, 1) + "/" 
              + String(ppm_asap, 1);

  http.begin(client, Link);
  int httpCode = http.GET();

  Serial.println(Link);
  Serial.print("HTTP Code: ");
  Serial.println(httpCode);

  http.end();
}
