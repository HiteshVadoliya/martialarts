<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>

<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url();?>public/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<script src="<?php echo base_url();?>public/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>public/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<style>
  table.dataTable > thead .sorting:before {
    margin-right: 3px;
  }
</style>
      <!-- Content Wrapper. Contains page content -->
      
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1><?= $MainTitle ?> List</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active"> <?= $MainTitle ?> List </li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <section class="content-header">
          <div class="container-fluid">
            <a class="btn btn-primary" href="<?= base_url($url.'/add'); ?>">+ Add <?= $MainTitle ?></a>
          </div>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title"><?= $MainTitle ?> List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example2" class="datatable table table-bordered table-hover">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Phrase</th>
                      <th>Good</th>
                      <th>Weight</th>
                      <th>Camp_pid</th>
                      <th>Client</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    if(isset($phrases_details) && !empty($phrases_details))
                    {
                        foreach($phrases_details as $data)
                        {
                            $MainId = $data["Phrase_id"];
                            echo '
                            <tr class="tr_'.$MainId.'" >
                                <td>'.$data["Phrase_id"].'</td>
                                <td>'.$data["Phrase"].'</td>
                                <td>'.$data["Good"].'</td>
                                <td>'.$data["Weight"].'</td>
                                <td>'.$data["Camp_pid"].'</td>
                                <td>'.$data["Client"].'</td>
                                <td>
                                  <a href="'.base_url($url.'/edit/'.$MainId).'" class="btn btn-sm btn-primary ">Edit</a>
                                  <button type="button" data-delete="'.$MainId.'" class="delete delete_'.$MainId.' btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>';
                        }
                    } else {
                      ?>
                      <tr><td colspan="8" ><center>No Data Found </center></td></tr>
                      <?php
                    }

                    ?>
                    </tbody>                    
                  </table>
                  <?php

                  // if(isset($pagination_link) && !empty($pagination_link))
                  // {
                  //     $pagination_link->setPath('admin/phrases');

                  //     echo $pagination_link->links();
                  // }
                  
                  ?>
                </div>
                <div>
                    
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
      </style>
      <script>
        $(".datatable").DataTable( {
           'columnDefs':[{
             'targets': [0,6], 
             'orderable': false,
            }],
        });

        // $('#example2').DataTable({
        //   "paging": true,
        //   "lengthChange": false,
        //   "searching": false,
        //   "ordering": true,
        //   "info": true,
        //   "autoWidth": false,
        // });
        jQuery(document).on('click', '.delete', function(){

          let r = confirm("Are you sure to Delete?");
          if(!r) { return false; }

          let did = $(this).attr('data-delete');
        
          let custom_submit = 'delete_' + did;
          var btn_old_val = $("." + custom_submit).val();
          console.log(btn_old_val);
          $("." + custom_submit).val(btn_old_val+'...');
          $("." + custom_submit).val('<?php echo 'Wait...'; ?>');
          $("." + custom_submit).attr("disabled", true);

            $.ajax({
              url: '<?php echo base_url($url.'/delete') ?>',
              type: 'POST',
              data: { 'did' : did },
              dataType : 'json',
              success: function(response) {                    
                if(response.status) {
                  toastr.success(response.msg);
                  jQuery(".tr_" + did).remove();
                } else {
                  toastr.error(response.msg);
                }

                $("." + custom_submit).val(btn_old_val);
                $("." + custom_submit).attr("disabled", false);  
              }            
          });

        });
        
      
        
      /*function delete_data(id)
      {
          if(confirm("Are you sure you want to delete it?"))
          {
              window.location.href="<?php echo base_url($url); ?>/delete/"+id;
          }
          return false;
      }*/
      </script>

<?php echo $this->endSection(); ?>