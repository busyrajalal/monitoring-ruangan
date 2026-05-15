<?= $this->include('admin/layout/header'); ?>
<?= $this->include('admin/layout/navbar'); ?>

  <main id="main" class="main">
    <?= $this->renderSection('content') ?>
  </main><!-- End #main -->

<?= $this->include('admin/layout/footer'); ?>