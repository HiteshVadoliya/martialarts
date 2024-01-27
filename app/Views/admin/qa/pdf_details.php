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

<table class="" cellspacing="0" cellpadding="0">   
   <tr><td></td></tr>
   <tr>
      <td align="left" width="100%">
         <table width="100%" class="border-pack" cellpadding="5" cellspacing="0" >
            <tbody>
               <tr>
                  <th>Campaign Name :</th>
                  <td><?= $cam_details['Camp_Name']; ?></td>
               </tr>
               <tr>
                  <th>Name of The QAA :</th>
                  <td><?= $QAA_details['fname'] ?? '-'; ?></td>
               </tr>
               <tr>
                  <th>Call Date :</th>
                  <td></td>
               </tr>
               <tr>
                  <th>Agent :</th>
                  <td></td>
               </tr>
               <tr>
                  <th>Uniqueid :</th>
                  <td><?= $Uniqueid ?></td>
               </tr>
               <tr>
                  <th>QA Comment good :</th>
                  <td><?= $QA_data['QA_Comment_good'] ?></td>
               </tr>
               <tr>
                  <th>QA Comment bad :</th>
                  <td><?= $QA_data['QA_Comment_bad'] ?></td>
               </tr>
               <tr>
                  <th>QA Comment :</th>
                  <td><?= $QA_data['QAComment'] ?></td>
               </tr>
               <tr>
                  <th>Status :</th>
                  <td><?= $QA_data['Status'] ?></td>
               </tr>
            </tbody>
         </table>
      </td>      
   </tr>   
   <tr><td></td></tr>  
</table>

<table class="" cellspacing="0" cellpadding="0">   
   <tr><td></td></tr>
   <tr>
      <td align="left" width="100%">
         <table width="100%" class="border-pack" cellpadding="5" cellspacing="0" >
            <tbody>
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

                   <tr>
                      <th>QA_Det_id :</th>
                      <td><?= $QA_Det_id; ?></td>
                   </tr>
                   <tr>
                      <th>Question :</th>
                      <td><?= $Question; ?></td>
                   </tr>
                  <tr>
                     <th>Notes :</th>
                     <td><?= $Notes; ?></td>
                  </tr>
                  <tr>
                     <th>Response :</th>
                     <td><?= $Response; ?></td>
                  </tr>

                  <tr>
                     <th>Score :</th>
                     <td><?= $Score; ?></td>
                  </tr>
                  <tr>
                     <th>Comment :</th>
                     <td><?= $Comment; ?></td>
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