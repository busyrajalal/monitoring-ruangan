<?= $this->extend('admin/layout/template');?>

<?= $this->Section('style'); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<?= $this->endSection(); ?>

<?= $this->section('content');?>
<?php 
    $db     = \Config\Database::connect();
    $query  = $db->query('SELECT * FROM kendalirelay');
    $row    = $query->getRow();
?>
    <div class="pagetitle">
      <h1>Kendali Relay + NodeMCU v3.0</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Kendali Relay</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Grafik Suhu</h5>
              <canvas id="myChart" style="height: 50vh; width: 80vh;"></canvas>
              <?php 
                $suhu = "";

                foreach($grafik as $row) :
                    $dataSuhu = $row->suhu;
                    $suhu .= "'$suhu'" . ",";
                endforeach;
              ?>
              <script>
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'bar',
                        responsive: true,
                        data: {
                            labels: ['Suhu'],
                            datasets: [{
                                label: 'Grafik Suhu',
                                data: <?= $suhu; ?>
                                backgroundColor: ['rgba(255, 99, 132, 0.2)'],
                                borderColor: ['rgba(255, 99, 132, 1)'],
                                borderWidth: 1
                            }] 
                        },
                        duration: 1000
                    })
              </script>  
            </div>
          </div><!-- End Card with an image on top -->
        </div>
      </div>
    </section>
<?= $this->endSection('content');?>

<?= $this->section('script'); ?>

<?= $this->endSection(); ?>
