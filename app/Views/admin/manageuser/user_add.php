<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?=$pg_title;?></h1>
                </div>
                <?php /*?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
                <?php /**/ ?>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary card-outline">
                        
                        <div class="card-header">
                            <!-- <h3 class="card-title">Form: Add New User</h3> -->
                            <div class="card-title">Form: Add New User</div>
                            <div class="card-tools">
                                <a href="<?=$url.'admin/manageuser/user_list'?>"> <button type="button" class="btn btn-primary"> <i class="fas fa-bars"></i> Back to List</button></a>
                            </div>
                        </div><!-- /.card-header -->
                        
                        <!-- form start -->    
                        <form class="form-horizontal" name="form_add" id="form_add" method="post" action="<?php echo $url.'admin/manageuser/user_add'?>" enctype="multipart/form-data" accept-charset="utf-8">
                            <div class="card-body">
                                <?php /* ?>
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fv_user_role_id">Role</label>
                                    <select class="form-control select2" id="fv_user_role_id" name="fv_user_role_id">
                                        <option value="">Please select a Role</option>
                                        <?php
                                            if(count($user_role_arr) > 0){
                                                foreach($user_role_arr as $val){
                                                    echo '<option value="'.$val['user_role_id'].'">'.$val['role'].'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <?php /**/ ?>

                                <div class="form-group">
                                    <label for="fv_fname">First Name</label>
                                    <input type="text" class="form-control" id="fv_fname" name="fv_fname" value="">
                                </div>

                                <div class="form-group">
                                    <label for="fv_lname">Last Name</label>
                                    <input type="text" class="form-control" id="fv_lname" name="fv_lname" value="">
                                </div>

                                <div class="form-group">
                                    <label for="fv_lname">Username</label>
                                    <input type="text" class="form-control" id="fv_username" name="fv_username" value="">
                                </div>

                                <div class="form-group">
                                    <label for="fv_password">Password</label>
                                    <input type="text" class="form-control" id="fv_password" name="fv_password" value="">
                                </div>

                                <div class="form-group">
                                    <label for="fv_email">Email address</label>
                                    <input type="email" class="form-control" id="fv_email" name="fv_email" />
                                </div>

                                <div class="form-group">
                                    <label for="fv_phone">Phone Number</label>
                                    <input type="tel" class="form-control" id="fv_phone" name="fv_phone" />
                                </div>

                                <div class="form-group">
                                    <label for="fv_phone">Phone System ID</label>
                                    <input type="text" class="form-control" id="fv_phonesys_id" name="fv_phonesys_id" />
                                </div>

                                <?php /* ?>
                                <div class="form-group">
                                    <label class="col-form-label" for="inputSuccess"><i class="fas fa-check"></i> Input with success</label>
                                    <input type="text" class="form-control is-valid" id="inputSuccess" placeholder="Enter ...">
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label" for="inputWarning"><i class="far fa-bell"></i> Input with warning</label>
                                    <input type="text" class="form-control is-warning" id="inputWarning" placeholder="Enter ...">
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label" for="inputError"><i class="far fa-times-circle"></i> Input with error</label>
                                    <input type="text" class="form-control is-invalid" id="inputError" placeholder="Enter ...">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                </div>
                                <?php /**/ ?>
                            
                            </div><!-- /.card-body -->
                            <div class="card-footer" style="text-align:right">
                                <button type="submit" class="btn btn-primary" value="btnSubmit" id="btnSubmit" name="btnSubmit">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div><!--/.col (left) -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
  
  
  <style type="text/css">
    .main-header {
      border-bottom: 1px solid #dee2e6;
      z-index: 99;
    }
    .error {
        color: red;
    }
    .select2-container--default .select2-selection--single {
        height: 40px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        padding-top: 40px;
    }
  </style>
  
  <script>

  $("#qa_form").validate({
    ignore: [],
    rules: {
       Uniqueid: { required: true},  
       Score: { required: true},  
       QAA_id: { required: true},  
    },
    messages: { 
       Uniqueid: "Uniqueid can not be blank",
       Score: "Score is required." ,
       QAA_id: "QAA_id is required." ,
    },
    submitHandler: function(form) {

      var btn_old_val = $(".custom_submit").text();
      $(".custom_submit").text(btn_old_val+'...');
      $(".custom_submit").text('<?php echo WAIT; ?>');
      $(".custom_submit").attr("disabled", true);
        $.ajax({
          url: '<?php echo base_url('/admin/qa/save') ?>',
          type: 'POST',
          data: $(form).serialize(),
          dataType : 'json',
          success: function(response) {                    
            if(response.status) {
              toastr.success(response.msg);
              let redi_url = '<?= base_url('/admin/qa/') ?>';
              setTimeout(function(){
                location.href = redi_url;
              },1500);
            } else {
              toastr.error(response.msg);
            }

            $(".custom_submit").text(btn_old_val);
            $(".custom_submit").attr("disabled", false);
          }            
      });
    }             
  });
  
  $('.select2').select2()
  </script>

<?php echo $this->endSection(); ?>