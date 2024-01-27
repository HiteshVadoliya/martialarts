<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url();?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<script src="<?php echo base_url();?>public/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script> 


<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> -->


  <style>
    button.dt-button.buttons-pdf.buttons-html5,
    button.dt-button.buttons-excel.buttons-html5,
    button.dt-button.buttons-csv.buttons-html5,
    button.dt-button.buttons-copy.buttons-html5 {
        background-color: #f8f9fa;
        border-color: #ddd;
        color: #444;
    }
    
    .dt-button {
      display: inline-block;
      font-weight: 400;
      color: #212529;
      text-align: center;
      vertical-align: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      background-color: transparent;
      border: 1px solid transparent;
      padding: 0.375rem 0.75rem;
      font-size: 1rem;
      line-height: 1.5;
      border-radius: 0.25rem;
      transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
  }
  .dropdown-menu .dropdown-item:hover {
      background: #007bff;
      color: #fff;
      box-shadow: inset 0 0 10px #000000;
  }
  </style>
      <!-- Content Wrapper. Contains page content -->
      
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>QA Form List</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active"> QA Form </li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <section class="content-header">
          <div class="container-fluid">
            <a class="btn btn-primary" href="<?= base_url('/admin/qa/add'); ?>">+ Add QA Form</a>
          </div>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">QA List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                  <table id="example2" class="datatable table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>Sr.</th>
                      <th>QA Id</th>
                      <th><a href="">Call ID</a></th>
                      <th>Score</th>
                      <th>Opinion</th>
                      <th>Agent Name</th>
                      <th>General Comments</th>
                      <th>Play</th>
                      <th>QA Form Status</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    if(isset($qa_data) && !empty($qa_data))
                    {
                        $sr = 1;
                        foreach($qa_data as $qa)
                        {
                            $Recording = $qa['Recording'];
                            $playurl = '';
                            if($Recording != 'NOTFOUND' ) {
                              $playurl = base_url().$qa['Recording'];
                            }

                            $QA_id = $qa["QA_id"];
                            $button_unique_id = $QA_id."_".rand();
                            echo '
                            <tr>
                                <td>'.$sr.'</td>
                                <td>'.$qa["QA_id"].'</td>
                                <td>'.$qa["Uniqueid"].'</td>
                                <td>'.$qa["Score"].'</td>
                                <td>'.$qa["opinion"].'</td>
                                <td>'.$qa["fname"].'</td>
                                <td>'.$qa["General_Comments"].'</td>
                                <td>
                                  <audio controls>
                                    <source src="'.$playurl.'" type="audio/ogg">
                                    <source src="'.$playurl.'" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                  </audio>
                                </td>
                                <td>'.$qa["QAS_Description"].'</td>
                                <td>
                                <div class="btn-group dropleft">
                                  <button type="button" class="btn btn-secondary dropdown-toggle action_class_'.$button_unique_id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                  </button>
                                  <div class="dropdown-menu">
                                    <a href="javascript:;" data-QA_id='.$QA_id.' data-buttonId="'.$button_unique_id.'" class="dropdown-item btn btn-warning custom_email_'.$button_unique_id.' send_email ">Send form to agent</a>
                                    <a href="javascript:;" class="dropdown-item btn btn-warning secound_opinion custom_submit_'.$button_unique_id.' " data-buttonId="'.$button_unique_id.'"  data-QA_id='.$QA_id.' >Request a second Opinion</a>
                                    <a href="'.base_url('/admin/qa/edit/'.$QA_id).'" class="dropdown-item btn btn-primary ">Edit</a>
                                  </div>
                                </div>

                                </td>
                            </tr>';
                            // <a href="javascript:;" data-QA_id='.$QA_id.' class="btn btn-sm btn-warning custom_email_'.$QA_id.' send_email ">Send</a>
                            $sr++;
                        }
                    } else {
                      ?>
                      <tr><td colspan="10" ><center>No Data Found </center></td></tr>
                      <?php
                    }

                    ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th>#</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                      </tr>
                  </tfoot>                    
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              
              <!-- /.card -->

              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>

          

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
      table.dataTable > thead .sorting:before {
        margin-right: 3px;
      }

      </style>
      
      <script type="text/javascript">
        new DataTable('.datatable',              
            {
              dom: 'Bfrtip',
              buttons: [
                  'copy', 'csv', 'excel', 'pdf', 'print'
              ],
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        let column = this;
                        console.log(column[0][0]);
                        let break_col = column[0][0];
                        if( break_col == 0 || break_col == 1 || break_col == 3 || break_col == 6 || break_col == 7 || break_col == 9 ) {
                          return false;
                        }
                        // Create select element
                        let select = document.createElement('select');
                        select.add(new Option(''));
                        column.footer().replaceChildren(select);
        
                        // Apply listener for user change in value
                        select.addEventListener('change', function () {
                            var val = DataTable.util.escapeRegex(select.value);

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });
                        // Add list of options
                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.add(new Option(d));
                            });
                    });
            }
        });
        $('select').addClass('form-control');
        
        // $(".datatable").DataTable( {
        //    'columnDefs':[{
        //      'targets': [0,2,3,4,5,6,7], 
        //      'orderable': false,
        //     }],
        // });
        
        jQuery(document).on('click', '.send_email', function(){

          let QA_id = $(this).attr('data-QA_id');            
          let buttonId = $(this).attr('data-buttonId');            
          
          // let custom_submit = 'custom_email_' + buttonId;
          let custom_submit = 'action_class_' + buttonId;
          var btn_old_val = $("." + custom_submit).text();
          
          $("." + custom_submit).text(btn_old_val+'...');
          $("." + custom_submit).text('<?php echo 'Sending...'; ?>');
          $("." + custom_submit).attr("disabled", true);
          
          $.ajax(
          {
              url: '<?php echo base_url('/admin/qa/sending_email') ?>',
              dataType: "JSON",
              method:"POST",
              data: {
                  "QA_id": QA_id,
              },
              success: function ( response )
              {
                if(response.status) {
                  toastr.success(response.msg);
                } else {
                  toastr.error(response.msg);
                }
                
                $("." + custom_submit).text(btn_old_val);
                $("." + custom_submit).attr("disabled", false);  
              }
              
              
          });
          
        });

        jQuery(document).on('click', '.secound_opinion', function(){

          let QA_id = $(this).attr('data-QA_id');            
          let buttonId = $(this).attr('data-buttonId');            
          console.log();
          // let custom_submit = 'custom_submit_' + buttonId;
          let custom_submit = 'action_class_' + buttonId;
          var btn_old_val = $("." + custom_submit).text();

          $("." + custom_submit).text(btn_old_val+'...');
          $("." + custom_submit).text('<?php echo 'Sending...'; ?>');
          $("." + custom_submit).attr("disabled", true);
          
          $.ajax(
          {
              url: '<?php echo base_url('/admin/qa/secound_opinion') ?>',
              dataType: "JSON",
              method:"POST",
              data: {
                  "QA_id": QA_id,
              },
              success: function ( response )
              {
                if(response.status) {
                  toastr.success(response.msg);
                  setTimeout(function(){
                    location.reload();
                  },1500);
                } else {
                  toastr.error(response.msg);
                }
                
                $("." + custom_submit).text(btn_old_val);
                $("." + custom_submit).attr("disabled", false);  
              }
              
              
          });

          });

      </script>
<?php echo $this->endSection(); ?>