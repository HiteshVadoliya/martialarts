<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add QA Form</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">QA </li>
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
        <div class="col-md-6 col-md-offset-2">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <!-- <h3 class="card-title">QA Form</h3>
              <br/> -->
              <h3 class="card-title"></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            
            <form role="form" name="qa_form" id="qa_form" method="post" action="javascript:;">
              <div class="card-body">
                <!-- <input type="hidden" name="QACF_id" id="QACF_id" value=""> -->
                <div class="form-group">
                  <label for="">Unique Id</label>
                  <input type="text" class="form-control" id="" name="" placeholder="Unique id" value="<?= $Uniqueid ?>" readonly >
                  <input type="hidden" class="form-control" id="Uniqueid" name="Uniqueid" value="<?= $Uniqueid ?>" >
                  <input type="hidden" class="form-control" id="Camp_iD" name="Camp_iD" value="<?= $Camp_iD ?>" >
                </div>
                <div class="form-group">
                  <label for="">QAA id</label>
                  <select class="form-control select2" id="QAA_id" name="QAA_id">
                    <?php
                    if(isset($user_list) && !empty($user_list)) {
                      foreach ($user_list as $u_key => $u_value) {
                        $phonesys_id = $u_value['phonesys_id'];
                        $user_name = $u_value['fname']." ".$u_value['lname']. " (".$phonesys_id.")";
                        ?>
                        <option value="<?= $phonesys_id ?>"><?= $user_name  ?></option>
                        <?php
                      }
                    }
                    ?>
                    
                  </select>
                </div>
               <!--  <div class="form-group">
                  <label for="">Score</label>
                  <input type="number" class="form-control" id="Score" name="Score" placeholder="Score" value="" >
                </div> -->
                <!-- <div class="form-group">
                  <label for="">QAA id </label>
                  <input type="number" class="form-control" id="QAA_id" name="QAA_id" placeholder="set to 1,2, or 3" value="" >
                </div> -->
                <!-- <div class="form-group">
                  <label for="">QA Comment good</label>
                  <input type="text" class="form-control" id="QA_Comment_good" name="QA_Comment_good" placeholder="QA Comment good" value="">
                </div>
                <div class="form-group">
                  <label for="">QA Comment bad</label>
                  <input type="text" class="form-control" id="QA_Comment_bad" name="QA_Comment_bad" placeholder="QA Comment bad" value="">
                </div>
                <div class="form-group">
                  <label for="">QA Comment</label>
                  <input type="text" class="form-control" id="QAComment" name="QAComment" placeholder="QA Comment" value="">
                </div> -->

                <div class="form-group">
                  <!-- <label for="">QA Comment</label> -->
                  <input type="hidden" class="form-control" id="Status" name="Status" placeholder="QA Comment" value="2">
                </div>
                                
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary custom_submit">Submit</button>
                <a href="<?= base_url('/admin/qa/'); ?>" type="button" class="btn btn-navbar">Back</a>
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