# 🌐 Sistem Monitoring Ruangan Real-time (IoT)

Proyek ini adalah sistem monitoring kualitas udara dan cuaca ruangan secara real-time menggunakan mikrokontroler **ESP8266**, sensor **DHT11**, dan **MQ135** yang terintegrasi penuh ke web server berbasis **CodeIgniter 4** menggunakan visualisasi grafik interaktif **Chart.js**.

---

## 🛠️ Langkah-Langkah Instalasi & Konfigurasi Sistem

Ikuti panduan berikut secara berurutan untuk menjalankan proyek dari sisi hardware hingga website:

### 1. 📦 Instalasi Dependensi Website (Composer)
Sebelum melakukan konfigurasi pada website, pastikan semua library dan core framework CodeIgniter 4 terinstal dengan lengkap:
* Buka terminal (Command Prompt / Power Shell / Git Bash).
* Masuk ke dalam direktori folder website proyek Anda:
  ```bash
  cd path/to/folder/monitoring-ruangan
  ```
* Jalankan perintah berikut untuk menggunduh `vendor`:
```bash
composer install
```
* Tunggu hingga proses selesai. Langkah ini wajib dilakukan agar web server tidak mengalami error *Class not found*.

### 2.🔌 Konfigurasi Hardware (ESP8266 / Arduino IDE)
Sebelum mengunggah kode program ke NodeMCU ESP8266, buka file program di folder `monitoring-ruang/` menggunakan aplikasi Arduino IDE, lalu sesuaikan konfigurasi jaringan dan server berikut:

*   **Koneksi Wi-Fi:** Cari baris kode berikut dan sesuaikan dengan SSID serta password Wi-Fi di lokasi Anda agar alat bisa terhubung ke internet:
    ```cpp
    const char* ssid     = "Nama WiFi";
    const char* password = "Password";
    const char* host     = "IP Kalian";
    ```
*   **Target Pengiriman URL API:** Cari fungsi pengiriman data HTTP Request (`HTTPClient`) dan sesuaikan alamat IP Laptop/Server lokal Anda yang menjalankan CodeIgniter 4:
    ```cpp
      String Link = "http://" + String(host) + "/monitoring-ruangan/terima-data/" 
                  + String(suhu, 1) + "/" 
                  + String(hum, 0) + "/" 
                  + String(gas) + "/" 
                  + String(ppm_co2, 1) + "/" 
                  + String(ppm_amonia, 1) + "/" 
                  + String(ppm_benzena, 1) + "/" 
                  + String(ppm_alkohol, 1) + "/" 
                  + String(ppm_asap, 1);
    ```

### 3. 🗄️ Import Database MySQL
*   Buka browser Anda dan akses kontrol panel database lokal di alamat: `http://localhost/phpmyadmin/`.
*   Buat database baru dengan nama bebas (contoh: `db_sensor` atau `dhtmq`).
*   Masuk ke database baru tersebut, pilih menu **Import** di bagian atas.
*   Klik *Choose File* dan pilih file database **`dhtmq.sql`** yang ada di folder utama proyek ini.
*   Gulir ke bawah dan klik tombol **Import / Go**. Pastikan semua tabel (`sensor`) berhasil terbuat.

### 4. 🌐 Konfigurasi Website CodeIgniter 4 (`.env`)
Buka folder source code website `monitoring-ruangan/` menggunakan text editor (VS Code / Notepad++), lalu lakukan konfigurasi berkas lingkungan:

*   Jika berkas masih bernama `env`, ubah namanya terlebih dahulu menjadi **`.env`** (tambahkan tanda titik di depannya).
*   Buka file `.env` tersebut, cari bagian konfigurasi **App URL** dan sesuaikan dengan alamat IP lokal komputer Anda saat ini:
    ```env
    //Contoh IP :
    app.baseURL = 'http://192.168.1.229/monitoring-ruangan/'
    ```
*   Gulir ke bawah ke bagian **Database**, lalu sesuaikan nama database, username, serta password MySQL Anda:
    ```env
    database.default.hostname = 'localhost'
    database.default.database = 'dhtmq'  # Sesuaikan dengan nama DB yang di-import tadi
    database.default.username = 'root'
    database.default.password = ''     
    database.default.DBDriver = 'MySQLi'
    ```

---
