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

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <?php /*<h1><i class="fas fa-list"></i> <?= $pg_title ?></h1>*/?>
                <h1><?= $pg_title ?></h1>
                </div>
                <?php /* ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $pg_title ?></li>
                    </ol>
                </div>
                <?php /**/ ?>
            </div>
        </div>
    </section>

    <?php /* ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="col-6">
                <a class="btn btn-primary" href="<?= $url; ?>">+ Add <?= $pg_title ?></a>
            </div>
            <div class="col-6"></div>
        </div>
    </section>
    <?php /**/ ?>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <?php /*<div class="card-title" style="margin-top:10px"><h3 class="card-title"><i class="fas fa-list"></i> <?= 'Form: '.$pg_title ?></h3></div>*/ ?>
                        <div class="card-title" style="margin-top:10px"><h3 class="card-title"><?= 'Form: '.$pg_title ?></h3></div>
                        <div class="card-tools"><a class="btn btn-primary" href="<?= $url; ?>user_add">+ Add New User</a></div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="datatable table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(count($user_arr) > 0)
                                    {
                                        foreach($user_arr as $row)
                                        {
                                            $delUrl = $url.'user_delete/'.$row['user_id'];
                                            echo '
                                            <tr class="tr_'.$row["user_id"].'" >
                                                <td>'.$row["fname"].' '.$row["lname"].'</td>
                                                <td>'.$row["username"].'</td>
                                                <td>'.$row["email"].'</td>
                                                <td>'.$row["phone"].'</td>
                                                <td>'.$row["is_active"].'</td>
                                                <td>
                                                    <a href="'.$url.'user_edit/'.$row["user_id"].'" class="btn btn-sm btn-primary "><i class="fas fa-pencil-alt"></i></a>
                                                    <a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.$delUrl.'" data-toggle="modal" data-target="#confirm-delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>';
                                        }
                                    }
                                    else {
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
                    <div></div>
                </div>
            </div>
        </div>

        <?php /* ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-edit"></i> Modal Examples </h3>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#confirm-delete">
                        Launch Default Modal
                        </button>
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
        <?php /**/ ?>

        <!-- Modal Ini -->
        <div class="modal fade" id="confirm-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Record</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete??</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <!-- <button type="button" class="btn btn-primary btn-ok">Delete</button> -->
                        <a class="btn btn-danger btn-ok">Delete</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal end -->

    </section>

    <style>
        .pagination li a {
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

        // jQuery(document).ready(function(){
        //     console.log('HOLA1');
        //     jQuery('#confirm-delete').on('show.bs.modal', function(e) {
        //         $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        //         console.log('HOLA2');
        //     });
        // });

    </script>
<?php echo $this->endSection(); ?>