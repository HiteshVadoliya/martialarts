<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>

      <!-- Content Wrapper. Contains page content -->
      
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>QA Campaign Form</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                  <li class="breadcrumb-item active"> QA Campaign Form </li>
                </ol>
              </div>
            </div>
            <!-- <a class="btn btn-primary" href="<?= base_url('/admin/qa_form/add'); ?>">+ Add campaign Form</a> -->
            <form name="camp_form" id="camp_form" action="" method="GET" >
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label>Campaign Form</label>
                    <select class="form-control" name="camp_pid" id="camp_pid" required >
                      <option value="">Select Campaign</option>
                      <?php
                      if(isset($camp_list) && !empty($camp_list) ) {
                        foreach ($camp_list as $c_key => $c_value) {
                          $sel = '';
                          if(isset($camp_pid) && $camp_pid == $c_value['Camp_id']) {
                            $sel = 'selected';
                          }
                          ?>
                          <option <?=$sel;?> value="<?= $c_value['Camp_id'] ?>"><?= $c_value['Camp_Name'] ?></option>
                          <?php
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-6">
                    <br/><label>&nbsp;</label>
                    <a class="btn btn-primary" href="<?= base_url('admin/qa_form') ?>">Back to List</a>
                </div>
              </div>
            </form>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">QA Campaign Form List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th><a href="">Campaign Name</a></th>
                      <th>QAQues_pid</th>
                      <th>weight</th>
                      <th>FormOrder</th>
                      <!-- <th>Edit</th> -->
                      <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    if(isset($camp_data) && !empty($camp_data))
                    {
                        foreach($camp_data as $user)
                        {
                            $QACF_id = $user["QACF_id"];
                            echo '
                            <tr>
                                <td>'.$user["QACF_id"].'</td>
                                <td>'.$user["Camp_pid"].'</td>
                                <td>'.$user["Question"].'</td>
                                <td><input type="text" id="weight_'.$QACF_id.'" value="'.$user["weight"].'"></td>
                                <td><input type="text" id="FormOrder_'.$QACF_id.'" value="'.$user["FormOrder"].'"></td>
                                <td><button type="button" onclick="delete_data('.$user["QACF_id"].')" class="btn btn-danger btn-sm">Delete</button>
                                  <input type="hidden" value="'.$QACF_id.'" name="QACF_id[]" >
                                </td>
                            </tr>';
                        }
                    } else {
                      ?>
                      <tr><td colspan="8" ><center>No Data Found </center></td></tr>
                      <?php
                    }

                    ?>
                    <!-- <td><a href="javascript:;" data-QACF_id="'.$user["QACF_id"].'" class="btn btn-sm btn-warning update_qu_form custom_submit_'.$QACF_id.' ">Update</a></td> -->
                    </tbody>                    
                  </table>
                  <input class="btn btn-warning update_qu_form" type="button" value="update">
                </div>
                <!-- /.card-body -->
              </div>
              <div>
                <?php

                if(isset($pagination_link) && !empty($pagination_link))
                {
                    $pagination_link->setPath('crud');

                    echo $pagination_link->links();
                }
                
                ?>
                  
                </div>
              <!-- /.card -->

              <!-- /.card -->
            </div>


            <!-- /.col -->
          </div>
          
          <?php
          if(isset($camp_data) && !empty($camp_data))
          {
            ?>
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Question</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form role="form" name="checkbox_form" id="checkbox_form" method="post" action="<?= base_url('admin/qa_form/submit/') ?>">
                <input type="hidden" name="camp_pid" id="camp_pid" value="<?= (isset($camp_pid)) ? $camp_pid: ''; ?>">
                <div class="row">
                  <div class="col-sm-12">
                    <!-- checkbox -->
                    <?php
                    if(isset($checkbox) && !empty($checkbox)) {
                      foreach ($checkbox as $c_key => $c_value) {
                        ?>
                        <div class="form-group">                      
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="customCheckbox<?= $c_value->QAQues_id; ?>" name="selected_question[]" value="<?= $c_value->QAQues_id ?>">
                            <label for="customCheckbox<?= $c_value->QAQues_id; ?>" class="custom-control-label"><?= $c_value->Question; ?></label>
                          </div>                      
                        </div>
                        <?php
                      }
                    }
                    ?>


                  </div>                  
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <input class="btn btn-primary" type="submit" name="update_qa" id="update_qa" value="+ Add  Selected Questions to Form">
                  </div>
                </div>

              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <?php } ?>

          <!-- /.row -->
        </section>
        <!-- /.content -->
      
      <!-- /.content-wrapper -->
      
      <style>
      .pagination li a
      {
          position: relative;
          display: block;
          padding: .5rem .75rem;
          margin-left: -1px;
          line-height: 1.25;
          color: #007bff;
          background-color: #fff;
          border: 1px solid #dee2e6;
      }

      .pagination li.active a {
          z-index: 1;
          color: #fff;
          background-color: #007bff;
          border-color: #007bff;
      }
      </style>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <script>
          jQuery(document).ready(function () {
              jQuery("#camp_pid").change(function () {
                  var selectedValue = $(this).val();                  
                  let qu_url = '<?= base_url('/admin/qa_form/') ?>' + selectedValue;
                  location.href = qu_url;
              });
          });

          jQuery(document).on('click', '.update_qu_form', function(){
            
            var values = $("input[name='QACF_id[]']")
              .map(function(){
                update_data($(this).val());
              }).get();
              console.log(values);
            
          });

          function update_data( QACF_id ) {
            // let QACF_id = $(this).attr('data-QACF_id');            
            let weight = $("#weight_" + QACF_id).val();
            let FormOrder = $("#FormOrder_" + QACF_id).val();

            let custom_submit = 'update_qu_form';
            // var btn_old_val = $("." + custom_submit).val();
            
            // $("." + custom_submit).val(btn_old_val+'...');
            // $("." + custom_submit).val('<?php echo 'Wait...'; ?>');
            $("." + custom_submit).attr("disabled", true);

            $.ajax(
            {
                url: '<?php echo base_url('admin/qa_form/edit_save') ?>',
                dataType: "JSON",
                method:"POST",
                data: {
                    "QACF_id": QACF_id,
                    "weight": weight,
                    "FormOrder": FormOrder,
                },
                beforeSend:function(){
                    Swal.fire({
                        timerProgressBar: true,
                        title: 'Please Wait !',
                        html: 'data uploading',// add html attribute if you want or remove
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    });
                },
                success: function ( res )
                {
                  // $("." + custom_submit).val(btn_old_val);
                  $("." + custom_submit).attr("disabled", false);  

                  Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                      html: 'Data succesfully updated!'
                  })
                }
                
                
            });
          }

          
      </script>
    

      <script>
      function delete_data(id)
      {
        Swal.fire({
          title: 'Are you sure to Delete',
          text: '',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          confirmButtonColor: '#d33',
          cancelButtonText: 'No',
        }).then((result) => {
            if(result.isConfirmed) {
              window.location.href="<?php echo base_url(); ?>admin/qa_form/delete/"+id;
            }
        });
        return false;
          // if(confirm("Are you sure you want to remove it?"))
          // {
          //     window.location.href="<?php echo base_url(); ?>admin/qa_form/delete/"+id;
          // }
          // return false;
      }
      </script>
<?php echo $this->endSection(); ?>