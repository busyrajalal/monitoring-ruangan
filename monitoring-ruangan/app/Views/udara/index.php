<?= $this->extend('admin/layout/template');?>

<?= $this->section('content');?>

<div class="pagetitle">
  <h1>Monitoring Kualitas Udara [MQ-135]</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard');?>">Home</a></li>
      <li class="breadcrumb-item active">Kualitas Udara</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">

    <!-- GAS -->
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">Gas</h5>
          <button class="btn btn-lg btn-primary mb-2">
            Gas: <span id="cekgas" class="badge bg-white text-primary">0 ppm</span>
          </button>
        </div>
      </div>
    </div>

    <!-- CO2 -->
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">CO2</h5>
          <button class="btn btn-lg btn-danger mb-2">
            CO2: <span id="cekco2" class="badge bg-white text-danger">0 ppm</span>
          </button>
        </div>
      </div>
    </div>

    <!-- AMONIA -->
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">NH3 (Amonia)</h5>
          <button class="btn btn-lg btn-warning mb-2">
            NH3: <span id="ceknh3" class="badge bg-white text-warning">0 ppm</span>
          </button>
        </div>
      </div>
    </div>

  </div>

  <div class="row mt-3">

    <!-- ASAP -->
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">Asap</h5>
          <button class="btn btn-dark btn-lg">
            Asap: <span id="cekasap" class="badge bg-white text-dark">0</span>
          </button>
        </div>
      </div>
    </div>

    <!-- ALKOHOL -->
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">Alkohol</h5>
          <button class="btn btn-info btn-lg">
            Alkohol: <span id="cekalcohol" class="badge bg-white text-info">0 ppm</span>
          </button>
        </div>
      </div>
    </div>

    <!-- BENZENA -->
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">Benzena</h5>
          <button class="btn btn-secondary btn-lg">
            Benzena: <span id="cekbenzena" class="badge bg-white text-secondary">0 ppm</span>
          </button>
        </div>
      </div>
    </div>

    <!-- KARTU STATUS -->
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title">Status Udara</h5>
          <h3 id="statusudara">Normal</h3>
        </div>
      </div>
    </div>

  </div>

  <!-- CHART -->
  <div class="row mt-3">

    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Grafik Kualitas Udara</h5>
          <canvas id="chartUdara"></canvas>
        </div>
      </div>
    </div>

  </div>
</section>

<?= $this->endSection(); ?>

---

<?= $this->section('script'); ?>

<!-- Load Library Eksternal -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Buat objek grafik duluan di luar agar bisa diakses oleh fungsi AJAX
let ctx = document.getElementById("chartUdara").getContext("2d");
let chartUdara = new Chart(ctx, {
  type: "bar",
  data: {
    labels: ["Gas", "CO2", "NH3", "Asap", "Alkohol", "Benzena"],
    datasets: [{
      label: "Nilai Kualitas Udara (PPM)",
      data: [0, 0, 0, 0, 0, 0], // Nilai awal sebelum AJAX berjalan
      backgroundColor: [
        "#0d6efd", // Gas
        "#dc3545", // CO2
        "#ffc107", // NH3
        "#212529", // Asap
        "#0dcaf0", // Alkohol
        "#6c757d"  // Benzena
      ]
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: { beginAtZero: true }
    }
  }
});

// Fungsi tunggal untuk mengambil data sensor dan memperbarui komponen web + grafik sekaligus
function loadDataRealtime(){
  $.ajax({
    url: "<?= base_url('udara/grafikudara'); ?>", // SUDAH DISESUAIKAN dengan Route tunggal Anda
    type: "GET",
    dataType: "json", // Memberitahu jQuery bahwa data otomatis bertipe JSON
    success: function(res){
      // Karena fungsi getGas() mengembalikan array [$data[] = $row], kita ambil indeks [0]
      let dataSensor = res[0]; 

      // Ambil nilai masing-masing kolom database dan konversi ke angka pecahan/bulat
      let gas     = parseFloat(dataSensor.gas);
      let co2     = parseFloat(dataSensor.co2);
      let nh3     = parseFloat(dataSensor.amonia);
      let asap    = parseFloat(dataSensor.asap);
      let alcohol = parseFloat(dataSensor.alkohol);
      let benzena = parseFloat(dataSensor.benzena);

      // 1. UPDATE ANGKA PADA CARD MONITORING
      $("#cekgas").text(gas + " ppm");
      $("#cekco2").text(co2 + " ppm");
      $("#ceknh3").text(nh3 + " ppm");
      $("#cekasap").text(asap);
      $("#cekalcohol").text(alcohol + " ppm");
      $("#cekbenzena").text(benzena + " ppm");

      // 2. KONDISI STATUS KUALITAS UDARA
      if(co2 > 200 || gas > 200){
        $("#statusudara").text("Tidak Sehat").css("color","red");
      } else {
        $("#statusudara").text("Normal").css("color","green");
      }

      // 3. SINKRONISASI LANGSUNG KE GRAFIK BAR CHART
      chartUdara.data.datasets[0].data = [gas, co2, nh3, asap, alcohol, benzena];
      chartUdara.update(); // Render ulang grafik secara halus
    },
    error: function(xhr, status, error) {
      console.error("Gagal mengambil data sensor: " + error);
    }
  });
}

// Jalankan fungsi load data setiap 2 detik berkala
setInterval(loadDataRealtime, 2000);

// Jalankan sekali di awal saat halaman pertama kali dibuka agar tidak kosong selama 2 detik
$(document).ready(function() {
    loadDataRealtime();
});
</script>

<?= $this->endSection(); ?>