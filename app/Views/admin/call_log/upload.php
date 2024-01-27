<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Upload Purge CC Data</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Upload Purge CC Data</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <div class="card-title">
            Purge CC Data
            </div>
          </div>
          <div class="card-body">
            <form action="" id="form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 mt-2">
                    <div class="form-group">
                        <label for="">Upload Audio File</label><br>
                        <input type="file" name="file" class="form-control-file" id="file">
                    </div>
                    <button type="button" class="btn btn-primary" id="uploadBtn">Upload</button>
                    
                    <h5 class="mb-2" style="display: none;" id="label-progress">Uploading Audio File...</h5>
                    <div class="progress" style="display: none;" >
                        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </section>
<?php echo $this->endSection(); ?>


<?php echo $this->section('script'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
     function resetErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    }
    function setErrors(errors) {
        resetErrors();
        $.each(errors, function(index, value) {
        $("#"+index).addClass('is-invalid');
        $("#"+index).after(`<div class="invalid-feedback">`+value+`</div>`);

        $("."+index).addClass('is-invalid');
        $("."+index).after(`<div class="invalid-feedback">`+value+`</div>`);
        });
    }
</script>
<script>
    $(document).ready(function(){
        $('#uploadBtn').click(function(){
            $('#form').ajaxForm({
                url:'<?= base_url('index.php/admin/call-log/upload') ?>',
                method:'POST',
                beforeSend:function(){
                    $('#uploadBtn').prop('disabled',true);
                },
                // Callback function to be executed if the form submission fails
                error: function(xhr) {
                    Swal.close();
                    Swal.fire({
                        title: 'Failed!',
                        text: xhr.responseJSON.message,
                        icon: 'warning'
                    });
                    setErrors(xhr.responseJSON.errors);
                    $('#uploadBtn').prop('disabled',false);
                },
                xhr: function () {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function (e) {
                        if (e.lengthComputable) {
                            var percent = Math.round((e.loaded / e.total) * 100);
                            $(".progress-bar").width(percent + '%');
                            $(".progress-bar").html(percent + '%');
                        }
                    }, false);
                    return xhr;
                },
                success:function(res){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        html: 'Data succesfully import!'
                    }).then(function(){
                        $('#uploadBtn').prop('disabled',false);
                        window.location.reload();
                    });
                }
            }).submit();
            $(".progress").show();
            $("#label-progress").show();
        });
    });
</script>
<?php echo $this->endSection(); ?>