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
                            <!-- <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" class="form-control" id="schedule_title" name="schedule_title" placeholder="Schedule" value="<?= (isset($edit) && !empty($edit['schedule_title'])) ? $edit['schedule_title'] : ''; ?>" >
                            </div> -->

                            <div class="form-group">
                              <label>Effective Date Range</label>
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span class="input-group-text">
                                      <i class="far fa-calendar-alt"></i>
                                    </span>
                                  </div>
                                  <input type="text" class="form-control float-right hwt_date" id="effective_date" name="effective_date" value="<?= (isset($edit) && !empty($edit['effective_date'])) ? $edit['effective_date'] : ''; ?>">
                              </div>
                            </div>
                      		<?php if(isset($edit) && !empty($edit)) { ?>
                            <div class="form-group">
                              <table id="myTable" border="1" class="table">
                                  <tr>
                                      <th>Instructor Rate ( <?= CURRENCY ?> )</th>
                                      <th>Hours</th>
                                      <th>Total</th>
                                      <th>Action</th>
                                  </tr>
                                  <tbody class="t_body_contend">
									<?php
									if(isset($payment_data) && !empty($payment_data)) {
										foreach ($payment_data as $p_key => $p_value) {
											
											$total_hrs = $p_value['total_hrs'];
											$total_payment = $p_value['total_payment'];
											$payment_id = $p_value['payment_id'];
											$trclass = 'tr_'.$payment_id;
											?>
											<tr class="<?= $trclass ?>">
												<td>
												<select class="form-control select2" id="instructor_pid" name="instructor_pid[]">
												<?php
												if(isset($instructor_pid) && !empty($instructor_pid)) {
													foreach ($instructor_pid as $i_key => $i_value) {
													$hr_rate = $i_value['hr_rate'];
													$sel = '';
													if( isset($payment_data) && $p_value['instructor_pid'] == $i_value['user_id'] ) {
														$sel = 'selected';
													}
													?>
													<option <?= $sel ?> value="<?= $i_value['user_id'] ?>"><?= $i_value['fname'].' '.$i_value['lname']. ' ( '.CURRENCY.$hr_rate.' )'; ?></option>
													<?php
													}
												}
												?>                                
												</select>
												</td>
												<td><input type="number" name="total_hrs[]" id="total_hrs" value="<?= $total_hrs ?>"></td>
												<td><?= CURRENCY.$total_payment ?></td>
												<td ><button type="button" data-did="<?= $payment_id ?>" class="rowDelete btn btn-danger">Delete</button></td>
											</tr>
											<?php
										}
									}
									?>
                                  </tbody>
                                  
                              </table>
                              <button type="button" onclick="addRow()">Add Row</button>
                            </div>

							<?php } ?>
                            <!-- <div class="form-group">
                              <label for="">Instructor</label>
                                <select class="form-control select2" id="instructor_pid" name="instructor_pid">
                                <?php
                                if(isset($instructor_pid) && !empty($instructor_pid)) {
                                  foreach ($instructor_pid as $i_key => $i_value) {
                                    $sel = '';
                                    $hr_rate = $i_value['hr_rate'];
                                    if( isset($edit) && $edit['instructor_pid'] == $i_value['user_id'] ) {
                                      $sel = 'selected';
                                    }
                                    ?>
                                    <option value="<?= $i_value['user_id'] ?>" <?= $sel ?>><?= $i_value['fname'].' '.$i_value['lname']. ' ( '.CURRENCY.$hr_rate.' )'; ?></option>
                                    <?php
                                  }
                                }
                                ?>                                
                              </select>
                            </div>                             -->
                        </div>
                    
                    <div class="card-footer">
                            <button type="submit" class="btn btn-primary custom_submit"><?= (isset($edit) && !empty($edit)) ? 'Update' : 'Next'; ?></button>
                            <a href="<?= base_url($url); ?>" type="button" class="btn btn-navbar">Back</a>
                            <?php if(isset($edit) && !empty($edit)) { ?> 
                            <a class="btn btn-danger export_pdf" href="javascript::" data-payment_id="<?= $edit['payment_id']; ?>" ><i class="" ></i>Export PDF </a>
                            <?php } ?>
                    </div>
                    </form>
                </div>
            </div>            
        </div>
    </div>
  </section>
  <table class="main_row main_container" style="display:none;">
      <tr>
        <td>
        <select class="form-control select2" id="instructor_pid" name="instructor_pid[]">
          <?php
          if(isset($instructor_pid) && !empty($instructor_pid)) {
            foreach ($instructor_pid as $i_key => $i_value) {
              $hr_rate = $i_value['hr_rate'];
              if( isset($edit) && $edit['instructor_pid'] == $i_value['user_id'] ) {
                $sel = 'selected';
              }
              ?>
              <option value="<?= $i_value['user_id'] ?>"><?= $i_value['fname'].' '.$i_value['lname']. ' ( '.CURRENCY.$hr_rate.' )'; ?></option>
              <?php
            }
          }
          ?>                                
        </select>
        </td>
        <td><input type="number" name="total_hrs[]" id="total_hrs"></td>
        <td></td>
        <td class="delete_tr"><button href="javascript:;" class="delete_row_html btn btn-danger">Delete</button></td>
      </tr>
      <input type="hidden" value="5130" id="myid">
  </table>
  
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url();?>public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
          
  <script>
    $(document).on("click",".export_pdf",function(){
        let payment_id = $(this).attr('data-payment_id');
        
        $.ajax(
        {
            url: '<?= site_url($url.'/export_pdf/')?>',
            dataType: "JSON",
            method:"POST",
            data: { payment_id : payment_id },
            success: function (response)
            { 
                pdf_download = site_url + 'public/uploads/pdf_export/' +response.filename;
                setTimeout(function(){
                    window.open(
                        pdf_download,
                        '_blank'
                    );
                },3000);
                // if(response.status) {
                //     toastr.success(response.msg);
                // } else {
                //     toastr.error(response.msg);
                // } 
                //$('#posts').DataTable().ajax.reload(null, false);
            }
        });        
    }); 

    function addRow() {
      let myid = $("#myid").val();
      $(".main_row tr").removeAttr('class');
      $(".main_row tr").addClass('tr_'+myid);
      $(".main_row tr .delete_tr button").attr('data-did', myid);
      $(".main_row tr").clone().appendTo(".t_body_contend");
      $(".main_container tr").removeAttr('class');
      myid++;
      console.log(myid);
      $("#myid").val( myid );
    }
    jQuery(document).on("click",".delete_row_html",function(){
      let did = $(this).attr('data-did');
      console.log(did);
      $(".tr_"+did).remove();
    }) 

	jQuery(document).on('click', '.rowDelete', function(){
        Swal.fire({
        title: 'Delete Confirm?',
        text: 'Are you sure to Delete?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        confirmButtonColor: '#d33',
        cancelButtonText: 'No',
        }).then((result) => {
            if(result.isConfirmed == false) { return false; }
            let did = $(this).attr('data-did');
        
            let custom_submit = 'delete_' + did;
            var btn_old_val = $("." + custom_submit).val();
            
            $("." + custom_submit).val(btn_old_val+'...');
            $("." + custom_submit).val('<?php echo 'Wait...'; ?>');
            $("." + custom_submit).attr("disabled", true);
            $.ajax({
                url: '<?= site_url($url.'/delete/') ?>',
                type: 'POST',
                data: { 'did' : did },
                dataType : 'json',
                success: function(response) {                    
                    if(response.status) {
						$(".tr_" + did).remove();
                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    }                    
                    //$('#posts').DataTable().ajax.reload(null, false);
                    $("." + custom_submit).val(btn_old_val);
                    $("." + custom_submit).attr("disabled", false);  
                }            
            });
        });
    });
    
    $('#timepicker').datetimepicker({
        // format: 'LT',
        format: 'HH:mm',
        pickDate: false,
        pickSeconds: false,
        pick12HourFormat: false
    })
    $('.hwt_date').daterangepicker({
        "singleDatePicker": false,
        "showDropdowns": true,
        "showISOWeekNumbers": false,
        "timePicker": false,
        "linkedCalendars": false,
        "showCustomRangeLabel": false,
        // "minDate":new Da te(),
        "locale": {
              format: 'YYYY-MM-DD',
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
  // $('.select2').select2()

  
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
      // $(".custom_submit").text(btn_old_val+'...');
      // $(".custom_submit").text('<?php echo WAIT; ?>');
      // $(".custom_submit").attr("disabled", true);
        $.ajax({
          url: '<?php echo base_url($url.'/store') ?>',
          type: 'POST',
          data: $(form).serialize(),
          dataType : 'json',
          success: function(response) {                    
            if(response.status) {
              toastr.success(response.msg);
              if( response.last_id > 0 ) {
                let redi_url = response.url;
                setTimeout(function(){
                  location.href = redi_url;
                },1500);
              }
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