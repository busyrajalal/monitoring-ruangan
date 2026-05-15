    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
                <?php
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename=TemplateMasterData.xls');
                    header('Cache-Control: max-age=0');
                ?>
                <!-- Table with stripped rows -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">nis</th>
                            <th class="text-center">nama</th>
                            <th class="text-center">alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">0123456789</td>
                            <td>ali Affandi</td>
                            <td>Tanjungwadung Kabuh Jombang</td>
                            
                        </tr>
                    </tbody>
                </table>
                <!-- End Table with stripped rows -->
            </div>
          </div>
        </div>
      </div>
    </section>

  