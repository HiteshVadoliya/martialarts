<?php echo $this->extend('template/layout_admin'); ?>
<?php echo $this->section('main_content'); ?>

<!-- Content Wrapper. Contains page content -->

    

    <!-- Main content -->
    <section class="content">
      <div style="margin:0 auto;width:700px;padding-top:70px">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! You do not have permission to access this page.</h3>
          <p>Please contact administrator in case you think this is wrong..<br />Click here to <a href="dashboard">return to dashboard</a> or try using the search form.</p>
      </div>
    </section>

<?php echo $this->endSection(); ?>