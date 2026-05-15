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
            <img src="<?= base_url('assets-admin/img/nodemcu.png');?>" class="card-img-top" title="NodeMCU v3.0" alt="NodeMCU v1.0">
            <div class="card-body">
              <h5 class="card-title">Relay</h5>
              <p class="card-text">
                Status : &nbsp;&nbsp; <button <?php if ($row->relay == 1) { ?> class="btn btn-lg btn-secondary rounded-pill" <?php } else { ?> class="btn btn-lg btn-success rounded-pill" <?php } ?> onclick="ubah('<?= $row->id;?>')">&nbsp;&nbsp;&nbsp;<?php if ($row->relay == 1) { ?> Kontak Relay OFF <?php } else { ?> Kontak Relay ON <?php } ?>&nbsp;&nbsp;&nbsp;</button>
              </p>
            </div>
          </div><!-- End Card with an image on top -->
        </div>
      </div>
    </section>
<?= $this->endSection('content');?>

<?= $this->section('script'); ?>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script>
  function ubah(id) {
    $.ajax({
      type: 'GET',
      url: '<?= base_url("nilai-relay/"); ?>'+id,
      data: {
        _method: 'GET',
        id: id
      },
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          window.location.href = "<?= base_url('kendali'); ?>"
        }
      }
    }) 
  }
</script>
<?= $this->endSection(); ?>
