<?php echo $this->extend('template/layout_admin'); ?>

<?php echo $this->section('main_content'); ?>
  <style type="text/css">
    .mycardbody {
      padding-top: 10px !important;
      padding-bottom: 10px;
    }
    .mygreen {
        color: green;
    }
    .myclass {
      font-size: 24px;
    }
    
  </style>
  <!-- above is style -->
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?= $pg_title ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">QA </li>
          </ol>
          <a href="<?= base_url('/admin/qa/'); ?>" type="button" class="btn btn-default  ">Back</a>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-8">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <!-- <h3 class="card-title">QA Form</h3>
              <br/> -->
              <h3 class="card-title"></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <?php if($mode == 'edit') { ?>
              <!-- <div class="card">
                <div class="card-body mycardbody">
                  <?php
                  if(isset($transcript_result) && !empty($transcript_result)) {
                    $sr = 1;
                    foreach ($transcript_result as $tr_key => $tr_value) {
                      ?>
                      <div class="row">
                        <div class="col-sm-4"><b>Engine name : <?= $tr_value['Trans_eng_name']; ?> </b> </div>
                        <div class="col-sm-4"><b>AI_Score : <?= $tr_value['AI_Score']; ?></b> </div>
                        <div class="col-sm-4"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg-transcription-data_<?= $sr; $sr++; ?>">
                          Transcription Data
                        </button></div>
                      </div>
                      <?php
                    }
                  }
                  ?>

                </div>
              </div> -->

              <div class="card">              
                <div class="card-body mycardbody">
                  
                  <div class="row">
                    <div class="col-sm-4">
                      <b>Campaign Name : </b> <?php echo (isset($cam_details) && $cam_details['Camp_Name'] != '') ? $cam_details['Camp_Name'] : ''; ?> 
                      <br/>
                      <b>Name of The QAA : </b> <?php echo (isset($QAA_details) && $QAA_details['fname']!='') ? $QAA_details['fname'] : ''; ?> 
                      <br/>
                    </div>
                    <div class="col-sm-4">
                      <b>Call Date : </b> <?= date('d M, Y', strtotime($call_log['Call_date'] )); ?>
                      <br/>
                      <b>Agent  : </b> <?= (isset($user_details) && isset($user_details['fname'])) ? $user_details['fname']." : " : ''; ?>
                      <br/>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>

            <form role="form" name="qa_form" id="qa_form" method="post" action="javascript:;">
              <div class="card-body">
                <input type="hidden" name="QA_id" id="QA_id" value="<?= $QA_id; ?>">                
                <input type="hidden" class="form-control" id="" name="" placeholder="Unique id" value="<?= $Uniqueid ?>" readonly >
                <input type="hidden" class="form-control" id="Uniqueid" name="Uniqueid" value="<?= $Uniqueid ?>" >
                
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="">What went Well with the call</label>
                      <textarea class="form-control" id="QA_Comment_good" name="QA_Comment_good" placeholder="QA Comment good" rows="3"><?= (isset($QA_data) && !empty($QA_data['QA_Comment_good'])) ? $QA_data['QA_Comment_good'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="">What needs to be improved on the call</label>
                      <textarea class="form-control" id="QA_Comment_bad" name="QA_Comment_bad" placeholder="QA Comment bad" rows="3"><?= (isset($QA_data) && !empty($QA_data['QA_Comment_bad'])) ? $QA_data['QA_Comment_bad'] : ''; ?></textarea>                  
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="">How did the call go?</label>
                      <textarea class="form-control" id="QAComment" name="QAComment" placeholder="QA Comment" rows="3"><?= (isset($QA_data) && !empty($QA_data['QAComment'])) ? $QA_data['QAComment'] : ''; ?></textarea>
                    </div>
                  </div>

                </div>

                <input type="hidden" class="form-control" id="Status" name="Status" placeholder="QA Comment" value="3">                
                                
              </div>
              <input type="hidden" name="mode" id="mode" value="<?= $mode ?>">
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary custom_submit">SUBMIT</button>
                <a href="<?= base_url('/admin/qa/'); ?>" type="button" class="btn btn-navbar">Back</a>
              </div>
            </form>
          </div>
          <!-- /.card -->

          <div class="card card-primary">
            <div class="card-header">
              <!-- <h3 class="card-title">QA Form</h3>
              <br/> -->
              <h3 class="card-title"></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            
            
              <div class="card-body mycardbody">
                    
                    <?php
                    if(isset($que_data) && !empty($que_data)) { 

                      foreach ($que_data as $q_key => $q_value) {
                        
                        $QA_Det_id = $q_value['QA_Det_id'];
                        $Question = $q_value['Question'];
                        $Notes = $q_value['Notes'];
                        $Response = $q_value['Response'];
                        $Score = $q_value['Score'];
                        $Comment = $q_value['Comment'];
                        ?>
                       
                        
                        <div class="row">
                          <div class="col-sm-3">
                            <b>Question <?= $QA_Det_id; ?> : </b> <?= $Question; ?> 
                            <br/>
                            <b>Notes : </b> <?= $Notes; ?> 
                            <br/>
                            <b>Response : </b> <?= $Response ?> 
                          </div>
                          <div class="col-sm-1">
                            <div class="form-group">
                              <label for="">Score</label>
                              <input type="number" class="form-control numberbox" id="Score_<?= $QA_Det_id ?>" name="Score[]" placeholder="Score" value="<?= $Score; ?>" min="0" max="100" >
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label for="">Comment</label>
                              <textarea class="form-control" id="Comment_<?= $QA_Det_id ?>" name="Comment[]" placeholder="Comment" rows="3"><?= $Comment; ?></textarea>                          
                            </div>
                          </div>
                          <div class="col-sm-3" style="margin-top: 5%;">
                            <div class="form-group">
                              <input type="hidden" name="QA_Det_id[]" value="<?= $QA_Det_id; ?>">
                              <input type="button" name="save_qa" id="save_qa" data-QA_Det_id="<?= $QA_Det_id ?>" class="btn btn-primary custom_submit_<?= $QA_Det_id ?> update_qu_form" value="SAVE">
                            </div>
                          </div>
                        </div>
                        <?php
                      }
                    }
                    ?>                                
              </div>
              <input type="hidden" name="mode" id="mode" value="<?= $mode ?>">
              <!-- /.card-body -->
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Transcript Review</h3>
            </div>
              <div class="card-body mycardbody">
                <?php
                $db = db_connect();
                if(isset($transcript_result) && !empty($transcript_result)) {
                  $sr = 1;
                  foreach ($transcript_result as $tr_key => $tr_value) {
                    $trans_pid = $tr_value['Trans_id'];
                    
                    $query_rw = $db->table('trans_score_detail t');
                    $query_rw->select('*, SUM(p.Weight) as total_weight ');
                    $query_rw->join('Phrases p', 'p.Phrase_id = t.phrase_pid ', 'left');
                    $query_rw->where('trans_pid', $trans_pid);
                    $tsd = $query_rw->get()->getRowArray();

                    // echo $db->getLastQuery();

                    // echo '<pre>';
                    // print_r($tsd);
                    // echo '</pre>';

                    ?>
                    <div class="row">
                      <div class="col-sm-6"><b>Engine name : </b> </div>
                      <div class="col-sm-6"><b><?= $tr_value['Trans_eng_name']; ?> </b></div>
                      
                      <div class="col-sm-6"><b>AI_Score : </b></div>
                      <div class="col-sm-6"><b><?= $tr_value['AI_Score']; ?></b> </div>
                        <?php
                        if($tr_value['AI_Tone'] != '') {
                          ?>
                          <div class="col-sm-6"><b>AI Tone : </b></div>
                          <div class="col-sm-6"><b><?= $tr_value['AI_Tone']; ?> </b></div>
                          <?php
                        }
                        if($tr_value['AI_Speech_Quality'] != '') {
                          ?>
                          <div class="col-sm-6"><b>AI Speech Quality : </b></div>
                          <div class="col-sm-6"><b>
                            <?php 
                            $quality = json_decode($tr_value['AI_Speech_Quality'], true);
                            foreach ($quality as $q_key => $q_value) {
                              echo $q_value['participant']. " : ". number_format((float)$q_value['score'], 2, '.', '')."%<br/>";
                            }
                            ?>
                          </b> </div>
                          <?php
                        }
                        ?>
                        <div class="col-md-6">
                          <b>Score : </b>
                        </div>
                        <div class="col-md-6">
                        <b><?php 
                        if(isset($tsd)) {
                          if($tsd['Good'] == 1) {
                            echo '<i class="fa fa-check-square mygreen myclass" aria-hidden="true"></i>';
                          } else {
                            echo '<i class="fa fa-times error myclass" aria-hidden="true"></i>';
                          }
                        }
                        ?></b>
                        </div>
                        <div class="col-md-6">
                          <b>Weight : </b>
                        </div>
                        <div class="col-md-6">
                          <b><?php echo (isset($tsd)) ? $tsd['total_weight'] : ''; ?></b>
                        </div>
                        <div class="col-sm-12"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg-transcription-data_<?= $sr; $sr++; ?>">
                          Transcription Data
                        </button></div>

                    </div>
                    <hr/>
                      
                    <?php
                  }
                }
                ?>                          
              </div>
          </div>
        </div>




        <!--/.col (left) -->
        
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  <?php
  if(isset($transcript_result) && !empty($transcript_result)) {
    $sr = 1;
    foreach ($transcript_result as $tr_key => $tr_value) {
      
      ?>
      <div class="modal fade" id="modal-lg-transcription-data_<?= $sr; ?>">
        <div class="modal-dialog modal-lg-transcription-data_<?= $sr; ?>">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Transcription Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <?php
              echo (isset($tr_value['Text']) && !empty($tr_value['Text'])) ? nl2br($tr_value['Text']) : 'No Data Found';
              ?>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <?php
      $sr++;
    }
  }
  ?>
  
  
  <style type="text/css">
    .main-header {
      border-bottom: 1px solid #dee2e6;
      z-index: 99;
    }
    .error {
        color: red;
    }
  </style>
  <script>
    
    $('.numberbox').keyup(function(){
      if ($(this).val() > 100 || $(this).val() <= 0){
        alert("Score should be between 1 to 100");
        $(this).val('100');
      }
    });

    jQuery(document).on('click', '.update_qu_form', function(){

      let QA_Det_id = $(this).attr('data-QA_Det_id');            
      let Score = $("#Score_" + QA_Det_id).val();
      let Comment = $("#Comment_" + QA_Det_id).val();
      let QA_id = $("#QA_id").val();

      let custom_submit = 'custom_submit_' + QA_Det_id;
      var btn_old_val = $("." + custom_submit).val();
      
      $("." + custom_submit).val(btn_old_val+'...');
      $("." + custom_submit).val('<?php echo 'Wait...'; ?>');
      $("." + custom_submit).attr("disabled", true);

      $.ajax(
      {
          url: '<?php echo base_url('/admin/qa/save_qa') ?>',
          dataType: "JSON",
          method:"POST",
          data: {
              "QA_Det_id": QA_Det_id,
              "Score": Score,
              "Comment": Comment,
              "QA_id": QA_id,
          },
          success: function ( res )
          {
            $("." + custom_submit).val(btn_old_val);
            $("." + custom_submit).attr("disabled", false);  
          }
          
          
      });
      
    });

  $("#qa_form").validate({
    ignore: [],
    rules: {
       Uniqueid: { required: true},  
    },
    messages: { 
       Uniqueid: "Uniqueid can not be blank",
    },
    submitHandler: function(form) {

      var btn_old_val = $(".custom_submit").text();
      $(".custom_submit").text(btn_old_val+'...');
      $(".custom_submit").text('<?php echo WAIT; ?>');
      $(".custom_submit").attr("disabled", true);
        $.ajax({
          url: '<?php echo base_url('/admin/qa/save_edit') ?>',
          type: 'POST',
          data: $(form).serialize(),
          dataType : 'json',
          success: function(response) {                    
            if(response.status) {
              toastr.success(response.msg);
              //$.notify({message: response.msg },{type: 'success'});
              let redi_url = '<?= base_url('/admin/qa/') ?>';
              setTimeout(function(){
                location.href = redi_url;
              },1500);
            } else {
              toastr.error(response.msg);
              // $.notify({message: response.msg },{type: 'danger'});
            }

            $(".custom_submit").text(btn_old_val);
            $(".custom_submit").attr("disabled", false);
          }            
      });
    }             
  });

  </script>

<?php echo $this->endSection(); ?>