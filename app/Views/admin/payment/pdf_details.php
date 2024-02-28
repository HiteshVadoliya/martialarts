<?php
use App\Models\HWTModel;
?>
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
   ul.sch_ul_li {
        list-style-type: none;
        padding: 0;
        margin-top: 10px;
        font-size: 14px;
        line-height: 21px;
    }
    td.school_heading {
        text-align: center;
        font-size: 16px;
    }

    strong.day_name {
        font-size: 16px;
    }
</style>

<table class="" cellspacing="0" cellpadding="0">   
<center><h1>PAYMENT DETAILS</h1></center>
<center><h1><?= $payment_main_data['effective_date'] ?></h1></center>
</table>
<table class="" cellspacing="0" cellpadding="0">   
   <tr><td></td></tr>
   <tr>
      <td align="left" width="100%">
         <table width="100%" class="border-pack" cellpadding="5" cellspacing="0" >
            <thead>
               <tr>
                  <th>Instructor Rate ( <?= CURRENCY ?> )</th>
                  <th>Hours</th>
                  <th>Total</th>
               </tr>
            </thead>
            <tbody>
            <?php
               if(isset($payment_data) && !empty($payment_data)) {
                  foreach ($payment_data as $p_key =>$p_value) {
                     $total_hrs = $p_value['total_hrs'];
                     $total_payment = $p_value['total_payment'];
                     $payment_id = $p_value['payment_id'];
                     ?>
                      <tr>
                        <th><?= $p_value['fname'] ?> ( <?= $p_value['hourly_rate'] ?> )</th>
                        <th><?= $p_value['total_hrs']; ?></th>
                        <th><?= CURRENCY. $p_value['total_payment']; ?></th>
                     </tr>                     
                     <?php
                     }
                  }
               ?>
              
            </tbody>
         </table>
      </td>      
   </tr>   
   <tr><td></td></tr>
</table>