<?= $this->extend('admin/layout/template');?>
<?= $this->section('content');?>
    <div class="pagetitle">
      <h1>Master Data Siswa</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Data Siswa</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
            <h5 class="card-title">Tools</h5>
            <form method="post" action="<?= base_url('siswa/import');?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fileexcel">File Excel</label>
                        <input type="file" name="fileexcel" class="form-control" id="file" required accept=".xls, .xlsx" /></p>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary mb-2" type="submit"> <i class="ri-file-excel-2-fill"></i> Import Excel</button>
                        <a href="<?= base_url('file-excel/responden.xlsx');?>" class="btn btn-sm btn-warning mb-2"><i class="bi-cloud-download"></i> Download Template</a>
                        <a href="<?= base_url('siswa/export');?>" class="btn btn-sm btn btn-outline-dark mb-2" style="float: right;"><i class="ri-file-excel-2-line"></i> Export Excel</a>
                      </div>
                    
                </form>
                
</div>
</div>
          <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tabel Data Siswa</h5>
                <?php if(session()->getFlashdata('message')){ ?>
                    <div class="alert alert-info">
                        <?= session()->getFlashdata('message') ?>
                    </div>
                <?php } ?>
                
                <!-- Table with stripped rows -->
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th class="text-center">NIS</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Alamat</th>
                            <!--<th data-type="date" data-format="YYYY/DD/MM">Start Date</th>-->
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach($data_siswa as $siswa) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?>.</td>
                                <td class="text-center"><?= $siswa->nis; ?></td>
                                <td><?= $siswa->nama; ?></td>
                                <td><?= $siswa->alamat; ?></td>
                                <td class="text-center" width="20%"><button class="btn btn-sm btn-success mb-2" type="submit"><i class="ri-image-edit-fill"></i></button>
                                <button class="btn btn-sm btn-danger mb-2" type="submit"><i class="bi bi-trash"></i></button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- End Table with stripped rows -->
            </div>
          </div>
        </div>
      </div>
    </section>
<?= $this->endSection('content');?>
  