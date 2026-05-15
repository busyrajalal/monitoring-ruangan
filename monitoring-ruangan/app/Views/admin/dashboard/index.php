<?= $this->extend('admin/layout/template');?>

<?= $this->section('content');?>

  <div class="pagetitle">
    <h1>Dashboard Monitoring Ruangan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('dashboard');?>">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">

      <!-- LEFT COLUMNS -->
      <div class="col-lg-8">
        <div class="row">

          <!-- KARTU 1: SUHU & KELEMBABAN -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title">Suhu &amp; Kelembaban</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary-light">
                    <i class="bi bi-thermometer-half text-primary" style="font-size: 2rem;"></i>
                  </div>
                  <div class="ps-3">
                    <h6 id="dash-suhu">0 °C</h6>
                    <span id="dash-kelembaban" class="text-muted small pt-2 ps-1">Humi: 0%</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- KARTU 2: KUALITAS UDARA (GAS GLOBAL) -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
              <div class="card-body">
                <h5 class="card-title">Gas Global</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-light">
                    <i class="bi bi-wind text-success" style="font-size: 2rem;"></i>
                  </div>
                  <div class="ps-3">
                    <h6 id="dash-gas">0 ppm</h6>
                    <span id="dash-co2" class="text-muted small pt-2 ps-1">CO2: 0 ppm</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- KARTU 3: STATUS KESEHATAN -->
          <div class="col-xxl-4 col-xl-12">
            <div class="card info-card customers-card">
              <div class="card-body">
                <h5 class="card-title">Status Ruangan</h5>
                <div class="d-flex align-items-center">
                  <div id="icon-status-bg" class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info-light">
                    <i id="icon-status" class="bi bi-shield-check text-info" style="font-size: 2rem;"></i>
                  </div>
                  <div class="ps-3">
                    <h6 id="dash-status">Memuat...</h6>
                    <span class="text-muted small pt-2 ps-1">Kondisi Udara</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- GRAFIK REAL-TIME GABUNGAN -->
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Grafik Monitoring Real-time</h5>
                <canvas id="chartDashboard" style="max-height: 400px;"></canvas>
              </div>
            </div>
          </div>

        </div>
      </div>
      <!-- END LEFT COLUMNS -->

      <!-- RIGHT COLUMNS -->
      <div class="col-lg-4">

        <!-- LOG AKTIVITAS SISTEM -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Aktivitas Sistem <span>| Log</span></h5>
            <div class="activity">
              <div class="activity-item d-flex">
                <div class="activite-label">Sekarang</div>
                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                <div class="activity-content">
                  Sistem melakukan monitoring real-time.
                </div>
              </div>
              <div class="activity-item d-flex mt-2">
                <div class="activite-label">Sistem</div>
                <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                <div class="activity-content">
                  Menerima data dari ESP8266 secara berkala.
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- GRAFIK RADAR KARAKTERISTIK GAS -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Karakteristik Gas MQ-135</h5>
            <canvas id="chartRadarGas" style="max-height: 350px;"></canvas>
          </div>
        </div>

      </div>
      <!-- END RIGHT COLUMNS -->

    </div>
  </section>

  <?= $this->endSection(); ?>

  ---

 <?= $this->section('script'); ?>

<!-- PERBAIKAN: CDN URL yang Benar dan Resmi -->
<script src="https://jquery.com"></script>
<script src="https://jsdelivr.net"></script>

<script>
// Batas maksimal titik yang bergeser di grafik garis
const maxPoints = 10;

// --- 1. CONFIG GRAFIK GARIS (Skala Y Otomatis Mengikuti Angka Ratusan) ---
let ctxLine = document.getElementById("chartDashboard").getContext("2d");
let chartLine = new Chart(ctxLine, {
  type: "line",
  data: {
    labels: [],
    datasets: [
      { label: "Suhu (°C)", data: [], borderColor: "#0d6efd", tension: 0.3, fill: false },
      { label: "Kelembaban (%)", data: [], borderColor: "#0dcaf0", tension: 0.3, fill: false },
      { label: "CO2 (PPM)", data: [], borderColor: "#dc3545", tension: 0.3, fill: false }
    ]
  },
  options: { 
    responsive: true,
    scales: {
      y: { beginAtZero: true } 
    }
  }
});

// --- 2. CONFIG GRAFIK RADAR ---
let ctxRadar = document.getElementById("chartRadarGas").getContext("2d");
let chartRadar = new Chart(ctxRadar, {
  type: "radar",
  data: {
    labels: ["Gas", "CO2", "NH3", "Asap", "Alkohol", "Benzena"],
    datasets: [{
      label: "Konsentrasi (PPM)",
      data: [0,0,0,0,0,0],
      backgroundColor: "rgba(13, 110, 253, 0.2)",
      borderColor: "#0d6efd",
      pointBackgroundColor: "#0d6efd"
    }]
  },
  options: { 
    responsive: true,
    scales: {
      r: { suggestedMin: 0, suggestedMax: 200 }
    }
  }
});

// --- 3. SATU FUNGSI AJAX TUNGGAL (Sangat Ringan, Cepat, dan Akurat) ---
function sinkronisasiDashboard() {
  const waktuSekarang = new Date().toLocaleTimeString();

  $.ajax({
    url: "<?= base_url('api/dashboard-realtime'); ?>", 
    type: "GET",
    dataType: "json",
    success: function(dataSensor) {
      if(!dataSensor) return;

      // Parsing semua data ke tipe angka pecahan/desimal
      let t    = parseFloat(dataSensor.suhu) || 0;
      let h    = parseFloat(dataSensor.kelembaban) || 0;
      let gas  = parseFloat(dataSensor.gas) || 0;
      let co2  = parseFloat(dataSensor.co2) || 0;
      let nh3  = parseFloat(dataSensor.amonia) || 0;
      let asap = parseFloat(dataSensor.asap) || 0;
      let alco = parseFloat(dataSensor.alkohol) || 0;
      let benz = parseFloat(dataSensor.benzena) || 0;

      // A. Memperbarui Teks Angka pada Info-Cards Atas
      $("#dash-suhu").text(t + " °C");
      $("#dash-kelembaban").text("Humi: " + h + "%");
      $("#dash-gas").text(gas + " ppm");
      $("#dash-co2").text("CO2: " + co2 + " ppm");

      // B. PERBAIKAN LOGIKA AKURASI STATUS (Ambang batas dinamis & aman)
      // Logika diubah: Hanya bahaya jika CO2 tinggi atau Gas beracun tinggi, atau suhu ruangan ekstrem
      if (co2 > 500 || gas > 250 || t > 38) {
        $("#dash-status").text("BAHAYA").css("color", "#dc3545");
        $("#icon-status").attr("class", "bi bi-exclamation-triangle text-danger");
        $("#icon-status-bg").css("background-color", "#f8d7da");
      } else {
        $("#dash-status").text("AMAN").css("color", "#198754");
        $("#icon-status").attr("class", "bi bi-shield-check text-success");
        $("#icon-status-bg").css("background-color", "#d1e7dd");
      }

      // C. PERBAIKAN GRAFIK GARIS (Memasukkan data langsung ke indeks dataset spesifik)
      // Tambahkan label waktu baru di sumbu X
      chartLine.data.labels.push(waktuSekarang);
      
      // Masukkan data ke masing-masing dataset garis secara terpisah agar tidak bentrok
      chartLine.data.datasets[0].data.push(t);   // Jalur 0 = Suhu
      chartLine.data.datasets[1].data.push(h);   // Jalur 1 = Kelembaban
      chartLine.data.datasets[2].data.push(co2); // Jalur 2 = CO2

      // Jika data melebihi batas maksimal (10 titik), hapus data terlama di tiap dataset
      if (chartLine.data.labels.length > maxPoints) {
        chartLine.data.labels.shift();
        chartLine.data.datasets[0].data.shift(); // Hapus titik suhu terlama
        chartLine.data.datasets[1].data.shift(); // Hapus titik kelembaban terlama
        chartLine.data.datasets[2].data.shift(); // Hapus titik CO2 terlama
      }
      
      chartLine.update(); // Render ulang grafik garis secara halus

      // D. Update Grafik Radar MQ135
      chartRadar.data.datasets[0].data = [gas, co2, nh3, asap, alco, benz];
      chartRadar.update(); // Render ulang grafik radar
    },
    error: function(xhr, status, error) {
      console.error("Gagal memuat data IoT: " + error);
    }
  });
}

// Jalankan pengambilan data secara efisien tiap 2 detik berkala
setInterval(sinkronisasiDashboard, 2000);

// Eksekusi langsung di awal saat halaman pertama kali dibuka
$(document).ready(function() {
  sinkronisasiDashboard();
});
</script>

<?= $this->endSection(); ?>

