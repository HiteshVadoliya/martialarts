<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>QA Form</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">QA Form</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <!-- <h3 class="card-title">QA Form</h3>
              <br/> -->
              <h3 class="card-title"><?= $qa_data['Camp_pid'] ?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" name="qa_form_update" id="qa_form_update" method="post" action="<?= base_url('/admin/qa_form/edit_save/'); ?>">
              <div class="card-body">
                <input type="hidden" name="QACF_id" id="QACF_id" value="<?= $qa_data['QACF_id'] ?>">
                <!-- <div class="form-group">
                  <label for="exampleInputEmail1">Camp pid</label>
                  <input type="text" class="form-control" id="Camp_pid" name="Camp_pid" placeholder="Campaing Name">
                </div> -->
                <div class="form-group">
                  <label for="exampleInputPassword1">weight</label>
                  <input type="number" class="form-control" id="weight" name="weight" placeholder="Weight" value="<?= (isset($qa_data['weight'])) ? $qa_data['weight'] : ''; ?>" >
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Form Order</label>
                  <input type="number" class="form-control" id="FormOrder" name="FormOrder" placeholder="Form Order" value="<?= (isset($qa_data['FormOrder'])) ? $qa_data['FormOrder'] : ''; ?>">
                </div>
                                
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?= base_url('/admin/qa_form/'); ?>" type="button" class="btn btn-navbar">Back</a>
              </div>
            </form>
          </div>
          <!-- /.card -->

        </div>
        <!--/.col (left) -->
        
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<?php echo $this->endSection(); ?>