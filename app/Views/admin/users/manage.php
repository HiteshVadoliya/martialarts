<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content');
use App\Models\HWTModel;
?>

      
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $MainTitle ?> List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('/admin') ?>">Home</a></li>
                    <li class="breadcrumb-item active"> <?= $MainTitle ?> List </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content-header">
        <div class="container-fluid">
            <a class="btn btn-primary" href="<?= base_url($url.'/add'); ?>">+ Add <?= $MainTitle ?></a>
        </div>
    </section>

    <input type="hidden" class="csrf_token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

    <section class="content">
        <div class="row">
            <div class="col-12">
               
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?= $MainTitle ?> List</h3>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Filter Role</label>
                                <select class="form-control role_filter" id="role_filter">
                                    <option value="">Default</option>
                                    <?php
                                    if(isset($roles_list) && !empty($roles_list)) {
                                        foreach ($roles_list as $role_key => $role_value) {
                                            $sel = '';
                                            if( $by_role > 0 && $by_role == $role_value['role_id'] ) {
                                                $sel = 'selected';
                                            }
                                            ?>
                                            <option <?= $sel ?> value="<?= $role_value['role_id'] ?>"><?= $role_value['role'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <table id='posts' class='table datatable'>
                            <thead>
                                
                            <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($records_list as $post) {
            
                                $statuslbl = $post['status'] == '1' ? 'Active' : 'Deactive';
                                $statusColor = $post['status'] == '1' ? 'success' : 'danger';
                                $nestedData['user_id'] = $post['user_id'];
                                $nestedData['fname'] = $post['fname'];
                                $userDetails = HWTModel::get_user_by_id( $post['user_id'] );            
                                $nestedData['role'] = $userDetails['role'];
                                $nestedData['email'] = $post['email'];
                                
                                $nestedData['action'] = '<button data-id='.$post[$id].' class="btn btn-sm btn-danger rowDelete delete_'.$post[$id].'">Delete</button>
                                <a href='.base_url().$url.'/edit/'.$post[$id].' data-id='.$post[$id].' class="btn btn-sm btn-info " >Edit</a>
                                <button data-id='.$post[$id].' data-status='.$post['status'].' class="btn btn-sm btn-'.$statusColor.' rowStatus " >'.$statuslbl.'</button>';
                                ?>
                                <tr>
                                    <td><?= $nestedData['user_id'] ?></td>
                                    <td><?= $nestedData['fname'] ?></td>
                                    <td><?= $nestedData['role'] ?></td>
                                    <td><?= $nestedData['email'] ?></td>
                                    <td><?= $nestedData['action'] ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
       
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>


<script type="text/javascript">
    $(".datatable").DataTable( {
        'columnDefs':[{
            // 'targets': [0,6], 
            'orderable': true,
        }],
    });
    jQuery(document).on("change","#role_filter",function(){
        let filter_role = $("#role_filter option:selected").val();
        location.href = site_url + '/admin/users?by_role='+ filter_role;
        
    });
    //get_data();
    
    function get_data() {

        $('#posts').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            'processing': true,
            'serverSide': true,
            "destroy":true,
            "serverSide": true,
            'serverMethod': 'post',
            'ajax': {
                'url':"<?= site_url($url.'/ajax_list/')?>",
                'data': function(data){
                var csrfName = $('.csrf_token').attr('name'); // CSRF Token name
                var csrfHash = $('.csrf_token').val(); // CSRF hash
                return {
                    data: data,
                    [csrfName]: csrfHash
                };
                },
                dataSrc: function(data){
                $('.csrf_token').val(data.token);
                return data.aaData;
                }
            },
            'columns': [
                { data: 'user_id' },
                { data: 'fname' },
                { data: 'role' },
                { data: 'email' },
                { data: 'action' },
            ]
        });

    }

    $(document).on("click",".rowStatus",function(){
        var id = $(this).attr("data-id");             
        var status = $(this).attr("data-status");             
        $.ajax(
        {
            url: '<?= site_url($url.'/status/')?>',
            dataType: "JSON",
            method:"POST",
            data: {
                "id": id,
                "status": status,
            },
            success: function (response)
            { 
                if(response.status) {
                    toastr.success(response.msg);
                } else {
                    toastr.error(response.msg);
                } 
                //$('#posts').DataTable().ajax.reload(null, false);
            }
        });
                
    }); 
    
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
            let did = $(this).attr('data-id');
        
            let custom_submit = 'delete_' + did;
            var btn_old_val = $("." + custom_submit).val();
            console.log(btn_old_val);
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

    
</script>

<?php echo $this->endSection(); ?>