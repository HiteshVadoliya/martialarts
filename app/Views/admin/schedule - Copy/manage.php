<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>

      
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
            <a class="btn btn-primary export_pdf" href="javascript::"><i class="" ></i>Export PDF</a>
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
                        <table id='posts' class='table '>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Schedule</th>
                                    <th>Time</th>
                                    <th>School Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
       
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>


<script type="text/javascript">
    
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
            { data: 'schedule_id' },
            { data: 'schedule_title' },
            { data: 'schedule_time' },
            { data: 'school_title' },
            { data: 'action' },
        ]
    });

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
    
    $(document).on("click",".export_pdf",function(){
        $.ajax(
        {
            url: '<?= site_url($url.'/export_pdf/')?>',
            dataType: "JSON",
            method:"POST",
            data: {
            },
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