<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">QA Review</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">QA</li>
              <li class="breadcrumb-item active">Review</li>
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
            Data QA Reviews
            </div>
          </div>
          <div class="card-body">
            <table class="table table-striped projects datatables">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Uniqueid</th>
                  <th>Score</th>
                  <th width="30%"></th>
                </tr>
              </thead>
              <tbody>
                <?php if(count($reviews) > 0){?> 
                <?php 
                $no = 1;
                foreach ($reviews as $data) { ?> 
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['Uniqueid'] ?></td>
                    <td><?= $data['Score'] ?></td>
                    <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="<?= base_url('/admin/qa/review/'.$data['QA_id']) ?>">
                            <i class="fas fa-star">
                            </i>
                            Review
                        </a>
                    </td>
                    </tr>
                <?php } ?>
                <?php }else{?>
                <tr>
                  <td colspan="4" class="text-center">Data is empty</td>
                </tr>  
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
<?php echo $this->endSection(); ?>

<?php echo $this->section('script'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function deleteData(id) {
    Swal.fire({
      title: 'Hapus data?',
      text: 'Anda yakin ingin menghapus data ini?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Hapus',
      confirmButtonColor: '#d33',
      cancelButtonText: 'Batal',
    }).then((result) => {
      // kode yang dijalankan setelah pengguna memilih Ya atau Tidak
      if (result.isConfirmed) {
        //ajax hapus data
        $.ajax({
          url: `<?= base_url('/admin/questions/delete/') ?>`+id,
          type: 'POST',
          beforeSubmit: function(formData, jqForm, options) {
            Swal.fire({
              title: 'Loading...',
              allowOutsideClick: false,
              allowEscapeKey: false,
              allowEnterKey: false,
              showConfirmButton: false,
              onBeforeOpen: () => {
                Swal.showLoading();
              }
            });
          },
          success: function(response) {
            Swal.close();
              Swal.fire({
                title: 'Success!',
                text: 'Data success deleted',
                icon: 'success'
              }).then(function(){
                document.location.reload()
              });
          },
          error: function(xhr, status, error) {
                Swal.close();
                Swal.fire({
                    title: 'Failed!',
                    text: 'Failed to delete data',
                    icon: 'warning'
                });
          }
        });
      }
    });
  }
</script>
<?php echo $this->endSection(); ?>