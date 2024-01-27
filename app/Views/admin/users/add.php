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
                                <label for="">Name</label>
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="Name" value="<?= (isset($edit) && !empty($edit['fname'])) ? $edit['fname'] : ''; ?>" >
                            </div>

                            <div class="form-group">
                              <label for="">Role</label>
                                <select class="form-control select2" id="role_id" name="role_id">
                                <?php
                                if(isset($roles) && !empty($roles)) {
                                  foreach ($roles as $r_key => $r_value) {
                                    $sel = '';
                                    if( isset($edit) && $edit['role_id'] == $r_value['role_id'] ) {
                                      $sel = 'selected';
                                    }
                                    ?>
                                    <option value="<?= $r_value['role_id'] ?>" <?= $sel ?>><?= $r_value['role']; ?></option>
                                    <?php
                                  }
                                }
                                ?>                                
                              </select>
                            </div>
                            

                            <div class="form-group">
                              <label>Birthdate</label>
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right hwt_date" id="reservation" id="b_date" name="b_date" value="<?= (isset($edit) && !empty($edit['b_date'])) ? $edit['b_date'] : ''; ?>">
                              </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="">Cell Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="<?= (isset($edit) && !empty($edit['phone'])) ? $edit['phone'] : ''; ?>" >
                            </div>
                            <div class="form-group">
                              <label for="">Instructor Level</label>
                                <select class="form-control select2" id="level_pid" name="level_pid">
                                <?php
                                if(isset($level) && !empty($level)) {
                                  foreach ($level as $l_key => $l_value) {
                                    $sel = '';
                                    if( isset($edit) && $edit['level_pid'] == $l_value['level_id'] ) {
                                      $sel = 'selected';
                                    }
                                    ?>
                                    <option value="<?= $l_value['level_id'] ?>" <?= $sel ?>><?= $l_value['level_title']; ?></option>
                                    <?php
                                  }
                                }
                                ?>                                
                              </select>
                            </div>
                           
                            <div class="form-group">
                                <label for="">Rank</label>
                                <select class="form-control select2" id="rank_pid" name="rank_pid">
                                <?php
                                if(isset($rank) && !empty($rank)) {
                                  foreach ($rank as $l_key => $l_value) {
                                    $sel = '';
                                    if( isset($edit) && $edit['rank_pid'] == $l_value['rank_id'] ) {
                                      $sel = 'selected';
                                    }
                                    ?>
                                    <option value="<?= $l_value['rank_id'] ?>" <?= $sel ?>><?= $l_value['rank_title']; ?></option>
                                    <?php
                                  }
                                }
                                ?>                                 
                              </select>
                            </div>

                            <div class="form-group">
                                <label for="">Hourly Pay Rate</label>
                                <input type="number" class="form-control" id="hr_rate" name="hr_rate" placeholder="Hourly Pay Rate" value="<?= (isset($edit) && !empty($edit['hr_rate'])) ? $edit['hr_rate'] : ''; ?>" >
                            </div>
                            <div class="form-group">
                                <label for="">Classes Taught</label><br/>
                                <div class="form-group clearfix">
                                  <div class="row">
                                  <?php
                                    if(isset($classes) && !empty($classes)) {
                                      foreach ($classes as $c_key => $c_value) {
                                        $un = 'classes_'.$c_value['class_id'];
                                        $title = $c_value['class_title'];
                                        $sel = '';
                                        if( isset($edit)) {
                                          $class_pid_array = explode(",",$edit['class_pid']);
                                          if(in_array($c_value['class_id'], $class_pid_array)) {
                                            $sel = 'checked';
                                          }
                                        }
                                        ?>
                                        <div class="icheck-primary d-inline col-md-3">
                                          <input name="class_pid[]" type="checkbox" id="<?= $un ?>" value="<?= $c_value['class_id'] ?>" <?= $sel ?>>
                                          <label for="<?= $un ?>"><?= $title ?></label>
                                      </div>
                                        <?php
                                      }
                                    }
                                    ?>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Locations </label><br/>
                                <div class="form-group clearfix">
                                  <div class="row">
                                  <?php
                                    if(isset($location) && !empty($location)) {
                                      foreach ($location as $l_key => $l_value) {
                                        $un = 'location_'.$l_value['location_id'];
                                        $title = $l_value['location_title'];
                                        $sel = '';
                                        if( isset($edit) ) {
                                          $location_pid_array = explode(",",$edit['location_pid']);
                                          if(in_array($l_value['location_id'], $location_pid_array)) {
                                            $sel = 'checked';
                                          }
                                        }
                                        ?>
                                        <div class="icheck-primary d-inline col-md-3">
                                          <input name="location_pid[]" type="checkbox" id="<?= $un ?>" value="<?= $l_value['location_id'] ?>" <?= $sel ?> >
                                          <label for="<?= $un ?>"><?= $title ?></label>
                                      </div>
                                        <?php
                                      }
                                    }
                                    ?>
                                  </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="email" value="<?= (isset($edit) && !empty($edit['email'])) ? $edit['email'] : ''; ?>" autocomplete="off" >
                            </div>

                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="password" value="" autocomplete="off">
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
          singleDatePicker: true,
          timePicker: false,
          timePickerIncrement: 30,
          showDropdowns: true,
          locale: {
              format: 'YYYY-MM-DD',
          }
      });
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