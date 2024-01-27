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
            <table class="table">
                <tr>
                    <td width="150"><b>Uniqueid</b></td>
                    <td>: <?= $qa['Uniqueid'] ?></td>

                    <td width="150"><b>Call Date</b></td>
                    <td>: <?= $qa['Call_date'] ?></td>
                </tr>
                <tr>
                    <td><b>Campaign Name</b></td>
                    <td>: <?= $qa['Campaign'] ?></td>
                    <td><b>Agent</b></td>
                    <td>: <?= $qa['Agent'] ?></td>
                </tr>
            </table>

            <h4>QA Detail</h4>
            <table class="table table-bordered">
                <tr>
                    <th >Question</th>
                    <th width="100">Score</th>
                    <th width="300">Comment</th>
                </tr>
                <?php foreach ($qa_details as $qa_detail) { ?>
                    <tr>
                        <td><?= $qa_detail['Question'] ?></td>
                        <td><?= $qa_detail['Score'] ?></td>
                        <td><?= $qa_detail['Comment'] ?></td>
                    </tr>
                <?php } ?>
            </table>
          </div>
          <div class="card-body">
            <form action="" id="form">
            <div class="row">
                <div class="col-md-4 mb-1">
                    <label for="" class="required">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Choose Status</option>
                        <option value="5">Disputed</option>
                        <option value="6">Acknowledged</option>
                    </select>
                </div>
                <div class="col-md-12 mb-1">
                    <label for="" class="required">Response <span class="text-danger">*</span></label>
                    <textarea name="response" id="response" cols="30" rows="5" class="form-control"></textarea>
                </div>

                <div class="col-md-12">
                    <button type="button" class="btn btn-primary" id="btn-submit">
                        <i class="fa fa-save"></i>
                        Save
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
                url:'<?= base_url('admin/qa/review/'.$id) ?>',
                method:'POST',
                beforeSend:function(){
                    Swal.fire({
                        timerProgressBar: true,
                        title: 'Please Wait !',
                        html: '',// add html attribute if you want or remove
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
                            html: 'Data succesfully reviewed!'
                        }).then(function(){
                            document.location.href = '<?= base_url('/admin/qa/review') ?>'
                        });
                    },1000);
                }
            }).submit();
        });
    });
</script>
<?php echo $this->endSection(); ?>