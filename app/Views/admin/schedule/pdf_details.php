<style type="text/css">
   table{
      background-color: #fff;  
      font-size: 10px;
      width:100%;
      /* border: 1px solid #ddd; */
      border-spacing: 0;
      border-collapse: collapse;
      display: table;
      font-size: 12px;      
   }

   td{
      padding: 8px;
      line-height: 20px;
   }
   .border td{
      padding: 8px;
      line-height: 20px;
      border:1px solid #ffa500;
   }
   .border th{
      padding: 8px;
      line-height: 20px;
      border:1px solid #ffa500;
   }
   .border-pack td{
      padding: 8px;
      line-height: 20px;
      border:1px solid #555;
   }
   .border-pack th{
      padding: 8px;
      line-height: 20px;
      border:1px solid #555;
   }
   th{
      font-weight: bold;
      text-align: left;
   }
   .bg-color-yellow{
      background-color: #ffa500;
   }
   .bg-color-dark{
      background-color: #ffa500;
      color: #fff;
   }
   .bold{
      font-weight: bold;
   }
   .bold-600{
      font-weight: 600;
   }
   .heading-style{
      color: #fff;
      font-size: 14px;
      background-color: #ffa500;
      padding: 10px;
      line-height: 36px;
   }
   .heading-style-dark{
      color: #fff;
      font-size: 14px;
      background-color: #555;
      padding: 10px;
      line-height: 36px;
   }
   .heading-style-second{
      color: #fff;
      font-size: 11px;
      background-color: #ffa500;
      padding: 10px;
      line-height: 36px;
   }
   #img
   {
      page-break-inside: auto;
   }
</style>
<?php
$day_list = array(
    '1' => 'Monday',
    '2' => 'Tuesday',
    '3' => 'Wednesday',
    '4' => 'Thursday',
    '5' => 'Friday',
    '6' => 'Saturday'
);
?>
<table class="" cellspacing="0" cellpadding="0">   
<center><h1>MASTER SCHEDULE</h1></center>
</table>
<table class="" cellspacing="0" cellpadding="0">   
   <tr><td></td></tr>
   <tr>
      <td align="left" width="100%">
         <table width="100%" class="border-pack" cellpadding="5" cellspacing="0" >
            <thead>
                <tr>
                    <?php
                    if(isset($schools) && !empty($schools)) {
                        foreach ($schools as $s_key => $s_value) {
                            ?><td><strong><?= $s_value['school_title'] ?><strong></td><?php
                        }
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $db = db_connect();
                
                if(isset($day_list) && !empty($day_list)) {
                    foreach ($day_list as $day_key => $day_value) {
                        if(isset($schools) && !empty($schools)) {
                            echo '<tr>';
                            foreach ($schools as $s_key => $s_value) {
                                $school_id = $s_value['school_id'];
                                $day_number = $day_key;
                                
                                $builder = $db->table( 'schedule' );
                                $builder->where( array( 'isDelete' => 0, 'status' => 1, 'school_pid' => $school_id, 'day_number' => $day_number ) );
                                $builder->orderBy('week', 'ASC');
                                $builder->orderBy('day_number', 'ASC');
                                $result_list = $builder->get()->getResultArray();
                                
                                ?>
                                    <td>
                                        <strong><?= $day_value ?></strong>
                                        <?php
                                        if(isset($result_list) && !empty($result_list)) {
                                            echo '<ul>';
                                            foreach ($result_list as $res_key => $res_value) {
                                                $display_list = $res_value['schedule_title'];
                                                ?>
                                                <li><?= $display_list ?></li>
                                                <?php
                                            }
                                            echo '</ul>';
                                        }
                                        ?>
                                    </td>                                
                                <?php
                            }
                            echo '</tr>';
                        }
                    }
                }

                ?>
              
            </tbody>
         </table>
      </td>      
   </tr>   
   <tr><td></td></tr>
</table>