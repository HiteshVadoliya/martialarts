<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Daterange picker -->
<link rel="stylesheet" href="<?php echo base_url();?>public/plugins/daterangepicker/daterangepicker.css">
<!-- daterangepicker -->
<script src="<?php echo base_url();?>public/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url();?>public/plugins/daterangepicker/daterangepicker.js"></script>


<style type="text/css">
  .main-header {
    border-bottom: 1px solid #dee2e6;
    z-index: 99;
  }
  .error {
    color:red; font-weight: 500 !important; 
  }
  .select2-container--default .select2-selection--single {
      height: 40px;
  }
  .select2-container--default .select2-selection--single .select2-selection__arrow {
      padding-top: 40px;
  }
</style>

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h1><?= $pg_title; ?></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url($url) ?>"><?= $MainTitle; ?></a></li>
                <li class="breadcrumb-item active"><?= ucfirst($mode); ?></li>
            </ol>
        </div>
      </div>
    </div>
  </section>

  
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-md-offset-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                    </div>
                    
                    <form role="form" name="add_form" id="add_form" method="post" action="javascript:;">
                        <div class="card-body">
                            <input type="hidden" name="edit_id" id="edit_id" value="<?= (isset($edit) && !empty($edit[$id])) ? $edit[$id] : ''; ?>">                
                            <input type="hidden" name="mode" id="mode" value="<?= $mode ?>">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" class="form-control" id="schedule_title" name="schedule_title" placeholder="Schedule" value="<?= (isset($edit) && !empty($edit['schedule_title'])) ? $edit['schedule_title'] : ''; ?>" >
                            </div>

                            <div class="form-group">
                              <label for="">School</label>
                                <select class="form-control select2" id="school_pid" name="school_pid">
                                <?php
                                if(isset($school_pid) && !empty($school_pid)) {
                                  foreach ($school_pid as $s_key => $s_value) {
                                    $sel = '';
                                    if( isset($edit) && $edit['school_pid'] == $s_value['school_id'] ) {
                                      $sel = 'selected';
                                    }
                                    ?>
                                    <option value="<?= $s_value['school_id'] ?>" <?= $sel ?>><?= $s_value['school_title']; ?></option>
                                    <?php
                                  }
                                }
                                ?>                                
                              </select>
                            </div>
                            

                            <div class="form-group">
                              <label>Schedule Date & Time</label>
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right hwt_date" id="schedule_time" name="schedule_time" value="<?= (isset($edit) && !empty($edit['schedule_time'])) ? $edit['schedule_time'] : ''; ?>">
                              </div>
                            </div>
                            
                        </div>
                    
                    <div class="card-footer">
                            <button type="submit" class="btn btn-primary custom_submit">Submit</button>
                            <a href="<?= base_url($url); ?>" type="button" class="btn btn-navbar">Back</a>
                    </div>
                    </form>
                </div>
            </div>            
        </div>
    </div>
  </section>
 
  <script>
    $('.hwt_date').daterangepicker({
        "singleDatePicker": true,
        "showDropdowns": true,
        "showISOWeekNumbers": true,
        "timePicker": true,
        "linkedCalendars": false,
        "showCustomRangeLabel": false,
        "minDate":new Date(),
        "locale": {
              format: 'YYYY-MM-DD hh:mm A',
          }        
    }, function(start, end, label) {
      console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
    });
    // $('.hwt_date').daterangepicker({
    //       singleDatePicker: false,
    //       timePicker : true,
    //       timePicker: false,
    //       timePickerIncrement: 30,
    //       showDropdowns: true,
    //       locale: {
    //           format: 'YYYY-MM-DD',
    //       }
    //   });
  $('.select2').select2()
  $("#add_form").validate({
    ignore: [],
    rules: {
       fname: { required: true},  
       mobile: { required: true},  
       level_pid: { required: true},  
       rank_pid: { required: true},  
       hr_rate: { required: true, number :true},  
       'class_pid[]': { required: true },  
       'location_pid[]': { required: true },  
       email: { required: true, email:true},  
       //password: { required: true },  
    },
    messages: { 
        fname: "Please enter firstname",
        mobile: "Please enter Cell Phone number",
        level_pid: "Please select Level",
        rank_pid: "Please select Level",
        hr_rate: "Please enter hourly rate",
        'class_pid[]': "Please select class",
        'location_pid[]': "Please select location",
        email: "Please enter Email Id",
        //password: "Please enter Password",
    },
    submitHandler: function(form) {

      var btn_old_val = $(".custom_submit").text();
      $(".custom_submit").text(btn_old_val+'...');
      $(".custom_submit").text('<?php echo WAIT; ?>');
      $(".custom_submit").attr("disabled", true);
        $.ajax({
          url: '<?php echo base_url($url.'/store') ?>',
          type: 'POST',
          data: $(form).serialize(),
          dataType : 'json',
          success: function(response) {                    
            if(response.status) {
              toastr.success(response.msg);
              let redi_url = '<?= base_url($url) ?>';
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

  </script>

<?php echo $this->endSection(); ?>