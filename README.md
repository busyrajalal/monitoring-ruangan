# 🌐 Sistem Monitoring Ruangan Real-time (IoT)

Proyek ini adalah sistem monitoring kualitas udara dan cuaca ruangan secara real-time menggunakan mikrokontroler **ESP8266**, sensor **DHT11**, dan **MQ135** yang terintegrasi penuh ke web server berbasis **CodeIgniter 4** menggunakan visualisasi grafik interaktif **Chart.js**.

---

## 🛠️ Langkah-Langkah Instalasi & Konfigurasi Sistem

Ikuti panduan berikut secara berurutan untuk menjalankan proyek dari sisi hardware hingga website:

### 1. 🔌 Konfigurasi Hardware (ESP8266 / Arduino IDE)
Sebelum mengunggah kode program ke NodeMCU ESP8266, buka file program di folder `monitoring-ruang/` menggunakan aplikasi Arduino IDE, lalu sesuaikan konfigurasi jaringan dan server berikut:

*   **Koneksi Wi-Fi:** Cari baris kode berikut dan sesuaikan dengan SSID serta password Wi-Fi di lokasi Anda agar alat bisa terhubung ke internet:
    ```cpp
    const char* ssid = "NAMA_WIFI_ANDA";
    const char* password = "PASSWORD_WIFI_ANDA";
    ```
*   **Target Pengiriman URL API:** Cari fungsi pengiriman data HTTP Request (`HTTPClient`) dan sesuaikan alamat IP Laptop/Server lokal Anda yang menjalankan CodeIgniter 4:
    ```cpp
    // Sesuaikan IP Address Laptop Anda dan pastikan jalurnya mengarah ke api/update
    String serverPath = "http://192.168.1.X:8080/api/update?"; 
    serverPath += "suhu=" + String(suhu);
    serverPath += "&kelembaban=" + String(kelembaban);
    // ... parameter sensor lainnya ...
    ```

### 2. 🗄️ Import Database MySQL
*   Buka browser Anda dan akses kontrol panel database lokal di alamat: `http://localhost/phpmyadmin/`.
*   Buat database baru dengan nama bebas (contoh: `db_sensor` atau `dhtmq`).
*   Masuk ke database baru tersebut, pilih menu **Import** di bagian atas.
*   Klik *Choose File* dan pilih file database **`dhtmq.sql`** yang ada di folder utama proyek ini.
*   Gulir ke bawah dan klik tombol **Import / Go**. Pastikan semua tabel (`sensor`) berhasil terbuat.

### 3. 🌐 Konfigurasi Website CodeIgniter 4 (`.env`)
Buka folder source code website `monitoring-ruangan/` menggunakan text editor (VS Code / Notepad++), lalu lakukan konfigurasi berkas lingkungan:

*   Jika berkas masih bernama `env`, ubah namanya terlebih dahulu menjadi **`.env`** (tambahkan tanda titik di depannya).
*   Buka file `.env` tersebut, cari bagian konfigurasi **App URL** dan sesuaikan dengan alamat IP lokal komputer Anda saat ini:
    ```env
    app.baseURL = 'http://192.168.1.X:8080/'
    ```
*   Gulir ke bawah ke bagian **Database**, lalu sesuaikan nama database, username, serta password MySQL Anda:
    ```env
    database.default.hostname = 'localhost'
    database.default.database = 'dhtmq'  # Sesuaikan dengan nama DB yang di-import tadi
    database.default.username = 'root'
    database.default.password = ''      # Kosongkan jika menggunakan bawaan XAMPP
    database.default.DBDriver = 'MySQLi'
    ```

---

## 🚀 Cara Menjalankan Aplikasi Web
1. Buka aplikasi **Terminal / Command Prompt / Git Bash** dan arahkan ke dalam folder `monitoring-ruangan/`.
2. Jalankan server lokal CodeIgniter 4 dengan mengetik perintah:
   ```bash
   php spark serve --host 192.168.1.X
   ```
   *(Ganti `192.168.1.X` dengan IP laptop Anda saat ini agar website bisa diakses bersamaan oleh ESP8266 dalam satu jaringan Wi-Fi).*
3. Buka browser Anda dan akses halaman utama dashboard di alamat: `http://192.168.1.X:8080/dashboard`.
