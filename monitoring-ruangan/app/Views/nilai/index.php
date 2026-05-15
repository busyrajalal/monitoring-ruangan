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
      <h1>Prototipe Penilaian UKK</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Radio Button</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <form action="" method="post">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pertanyaan 1</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;" scope="col">#</th>
                                        <th style="text-align: center;" scope="col">0</th>
                                        <th style="text-align: center;" scope="col">1</th>
                                        <th style="text-align: center;" scope="col">2</th>
                                        <th style="text-align: center;" scope="col">3</th>
                                        <th style="text-align: center;" scope="col">Penilaian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td valign="middle" style="text-align: center;" scope="row">1</td>
                                        <td valign="middle" style="text-align: center;"><input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="0" checked></td>
                                        <td valign="middle" style="text-align: center;"><input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="1"></td>
                                        <td valign="middle" style="text-align: center;"><input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="2"></td>
                                        <td valign="middle" style="text-align: center;"><input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="3"></td>
                                        <td valign="middle" style="text-align: center;">
                                            <button type="button" class="btn btn-success mb-2">
                                                Nilai: &nbsp; <span id="label-nilai1" class="badge bg-white text-success">0</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- End Card with an image on top -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pertanyaan 2</h5>
                    
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;" scope="col">#</th>
                                        <th style="text-align: center;" scope="col">0</th>
                                        <th style="text-align: center;" scope="col">1</th>
                                        <th style="text-align: center;" scope="col">2</th>
                                        <th style="text-align: center;" scope="col">3</th>
                                        <th style="text-align: center;" scope="col">Penilaian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td valign="middle" style="text-align: center;" scope="row">1</td>
                                        <td valign="middle" style="text-align: center;"><input class="form-check-input" type="radio" name="gridRadio" id="gridRadio1" value="0" checked></td>
                                        <td valign="middle" style="text-align: center;"><input class="form-check-input" type="radio" name="gridRadio" id="gridRadio1" value="1"></td>
                                        <td valign="middle" style="text-align: center;"><input class="form-check-input" type="radio" name="gridRadio" id="gridRadio2" value="2"></td>
                                        <td valign="middle" style="text-align: center;"><input class="form-check-input" type="radio" name="gridRadio" id="gridRadio3" value="3"></td>
                                        <td valign="middle" style="text-align: center;">
                                            <button type="button" class="btn btn-success mb-2">
                                                Nilai: &nbsp; <span id="label-nilai2" class="badge bg-white text-success">0</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- End Card with an image on top -->
                </div>
                
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered mt-4" >
                                <thead>
                                    <tr>
                                        <th valign="middle" colspan="5" style="text-align: center;" scope="col">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;Total Nilai &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th style="text-align: center;" scope="col"><button type="button" class="btn btn-primary">
                                                Nilai: &nbsp; <span id="hasil" class="badge bg-white text-primary">0</span>
                                            </button></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div><!-- End Card with an image on top -->
                </div>
                
            </div>
            
        </form>
    </section>
<?= $this->endSection('content');?>

<?= $this->section('script'); ?>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script>
$(document).ready(function() {
    $('input[name="gridRadios"], input[name="gridRadio"]').on('change', function() {
        var nilai1 = $('input[name="gridRadios"]:checked').val();
        var nilai2 = $('input[name="gridRadio"]:checked').val();
        var total = parseInt(nilai1) + parseInt(nilai2);

        $('#label-nilai1').text(nilai1);
        $('#label-nilai2').text(nilai2);
        $('#hasil').text(total);

        // $.ajax({
        //     type: 'POST',
        //     url: '<?= site_url('nama_controller/terima_nilai') ?>',
        //     data: {nilai1: nilai1, nilai2: nilai2, total: total},
        //     success: function(data) {
        //         console.log(data);
        //     }
        // });
    });
});
</script>
<?= $this->endSection(); ?>
