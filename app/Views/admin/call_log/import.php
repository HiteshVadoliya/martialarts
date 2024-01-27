<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Call Log</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Call Log</li>
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
            Import Call Log
            </div>
          </div>
          <div class="card-body">
            <form action="" id="form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 mt-2">
                    <label for="">Click to start importing data</label><br>
                    <button type="button" class="btn btn-primary" id="btn-submit">
                        import data
                    </button>

                    <div id="response"></div>
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
        $('#btn-submit').click(function(){
            $('#form').ajaxForm({
                url:'<?= base_url('index.php/admin/call-log/import') ?>',
                method:'POST',
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
                // Callback function to be executed if the form submission fails
                error: function(xhr) {
                    Swal.close();
                    Swal.fire({
                        title: 'Failed!',
                        text: xhr.responseJSON.errors,
                        icon: 'warning'
                    });
                    setErrors(xhr.responseJSON.errors);
                },
                success:function(res){
                    setTimeout(function(){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            html: 'Data succesfully import!'
                        }).then(function(){
                            var html = `
                            <table>
                                <tr>
                                    <td>Inserted Data</td>
                                    <td>:</td>
                                    <td>${res.data.insert}</td>
                                </tr>
                                <tr>
                                    <td>Update Data</td>
                                    <td>:</td>
                                    <td>${res.data.update}</td>
                                </tr>
                                <tr>
                                    <td>Total Data</td>
                                    <td>:</td>
                                    <td>${res.data.total}</td>
                                </tr>
                                <tr>
                                    <td>New User</td>
                                    <td>:</td>
                                    <td>${res.data.user}</td>
                                </tr>
                                <tr>
                                    <td>New Campaign</td>
                                    <td>:</td>
                                    <td>${res.data.campaign}</td>
                                </tr>
                            </table>
                            `;

                            $('#response').html(html);
                        });
                    },1000);
                }
            }).submit();
        });
    });
</script>
<?php echo $this->endSection(); ?>