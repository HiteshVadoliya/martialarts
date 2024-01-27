<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Questions</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Questions</li>
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
            Data Questions
            </div>
          </div>
          <div class="card-body">
            <form action="" id="form">
            <div class="row">
                <div class="col-md-12 mb-1">
                    <label for="" class="required">Question <span class="text-danger">*</span></label>
                    <input type="text" name="question" id="question" class="form-control">
                </div>
                <div class="col-md-12 mb-1">
                    <label for="" class="required">Notes (to help the QA Agent understand the parameters around the question) <span class="text-danger">*</span></label>
                    <textarea name="note" id="note" cols="30" rows="5" class="form-control"></textarea>
                </div>

                <div class="col-md-12 mb-1 ">
                    <label for="" class="campaign">Campaign <span class="text-danger">*</span></label> <br>
                    <?php foreach ($campaigns as $campaign) { ?>
                        <input type="checkbox" name="campaign[]" value="<?= $campaign['Camp_id'] ?>" id="campaign-<?= $campaign['Camp_id'] ?>"> <?= $campaign['Camp_Name'] ?> <br>
                    <?php } ?>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" id="btn-submit">
                        <i class="fa fa-save"></i>
                        Insert Question
                    </button>
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
                url:'<?= base_url('admin/questions') ?>',
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
                        text: 'Make sure all form are filled',
                        icon: 'warning'
                    });
                    setErrors(xhr.responseJSON.errors);
                },
                success:function(){
                    setTimeout(function(){
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            html: 'Data succesfully insert!'
                        }).then(function(){
                            document.location.href = '<?= base_url('/admin/questions') ?>'
                        });
                    },1000);
                }
            }).submit();
        });
    });
</script>
<?php echo $this->endSection(); ?>