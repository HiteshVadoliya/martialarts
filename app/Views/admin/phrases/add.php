<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <style type="text/css">
    .error { color:red; font-weight: 500 !important;  }
    .select2-container--default .select2-selection--single {
        height: 40px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        padding-top: 40px;
    }
  </style>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Phrases Form</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
            <li class="breadcrumb-item active"><?= $MainTitle; ?></li>
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
                <input type="hidden" name="Phrase_id" id="Phrase_id" value="<?= (isset($edit) && !empty($edit['Phrase_id'])) ? $edit['Phrase_id'] : ''; ?>">                
                <input type="hidden" name="mode" id="mode" value="<?= $mode ?>">
                <div class="form-group">
                  <label for="">Phrase</label>
                  <input type="text" class="form-control" id="Phrase" name="Phrase" placeholder="Phrase" value="<?= (isset($edit) && !empty($edit['Phrase'])) ? $edit['Phrase'] : ''; ?>" >
                </div>

                <div class="form-group">                      
                  <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="Good" name="Good" value="1" <?= (isset($edit) && !empty($edit['Good'])) ? 'checked' : ''; ?>>
                    <label for="Good" class="custom-control-label">Good</label>
                  </div>                      
                </div>

                <div class="form-group">
                  <label for="">Weight</label>
                  <input type="text" class="form-control" id="Weight" name="Weight" placeholder="Weight" value="<?= (isset($edit) && !empty($edit['Weight'])) ? $edit['Weight'] : ''; ?>" >
                </div>
                <div class="form-group">
                  <label for="">Camp PID</label>
                  <select class="form-control select2" id="Camp_pid" name="Camp_pid">
                    <option value="">Please select Campaing</option>
                    <?php
                    if(isset($campaign_list) && !empty($campaign_list)) {
                      foreach ($campaign_list as $key => $value) {
                        $sel = '';
                        $Camp_id = $value['Camp_id'];
                        $Camp_Name = $value['Camp_Name'];
                        if((isset($edit) && !empty($edit['Camp_pid'] && $edit['Camp_pid'] == $Camp_id))) {
                          $sel = 'selected';
                        }                        
                        ?>
                        <option <?= $sel; ?> value="<?php echo $Camp_id; ?>"><?= $Camp_Name." (".$Camp_id.")"; ?></option>
                        <?php
                      }
                    }
                    ?>
                  </select>
                  <!-- <input type="text" class="form-control" id="Camp_pid" name="Camp_pid" placeholder="Camp PID" value="<?= (isset($edit) && !empty($edit['Camp_pid'])) ? $edit['Camp_pid'] : ''; ?>" > -->
                </div>
                <!-- <div class="form-group">
                  <label for="">Client</label>
                  <input type="text" class="form-control" id="Client" name="Client" placeholder="Client" value="<?= (isset($edit) && !empty($edit['Client'])) ? $edit['Client'] : ''; ?>" >
                </div> -->
                
              </div>
              
              <div class="card-footer">
                <button type="submit" class="btn btn-primary custom_submit"><?= $button ?></button>
                <a href="<?= base_url($url); ?>" type="button" class="btn btn-navbar">Back</a>
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
  
  
 
  <script>
  $('.select2').select2();
  $("#qa_form").validate({
    ignore: [],
    rules: {
       Phrase: { required: true},  
      //  Good: { required: true},  
       Weight: { required: true},  
       Camp_pid: { required: true},  
    },
    messages: { 
       Phrase: "Phrase is required",
      //  Good: "Good is required." ,
       Weight: "Weight is required." ,
       Camp_pid: "Camp PID is required." ,
    },
    submitHandler: function(form) {

      var btn_old_val = $(".custom_submit").text();
      $(".custom_submit").text(btn_old_val+'...');
      $(".custom_submit").text('<?php echo WAIT; ?>');
      $(".custom_submit").attr("disabled", true);
        $.ajax({
          url: '<?php echo base_url($url.'/save') ?>',
          type: 'POST',
          data: $(form).serialize(),
          dataType : 'json',
          success: function(response) {                    
            if(response.status) {
              toastr.success(response.msg);
              // $.notify({message: response.msg },{type: 'success'});
              let redi_url = '<?= base_url($url) ?>';
              setTimeout(function(){
                location.href = redi_url;
              },1500);
            } else {
              toastr.error(response.msg);
              // $.notify({message: response.msg },{type: 'danger'});
            }

            $(".custom_submit").text(btn_old_val);
            $(".custom_submit").attr("disabled", false);
          }            
      });
    }             
  });

  </script>

<?php echo $this->endSection(); ?>