<?php 
namespace App\Controllers\ADMIN;


use App\Controllers\BaseController;
use App\Models\Admin\QA_Model;
use App\Models\Admin\QA_Details_Model;
use App\Models\Admin\Users_Model;
use App\Models\Admin\CallLog;
use CodeIgniter\Config\Services;

use Dompdf\Dompdf;

use CodeIgniter\Config\BaseConfig;

class QA extends BaseController
{
    public function __construct() {
        $session = Services::session();
        if ($session->get('is_admin_login') == NULL) {
            header('Location: '.base_url('auth/login'));
            exit();
        }
    }
    public function index( ): string
    {   

        $data['pg_title'] = 'QA LIST';
        
        $db = db_connect();
        
        $phonesys_id = $this->session->get('phonesys_id');

        $condition = "  ";
        if($this->session->get('user_role_id') == 4)
        {
            $condition = "AND cl.Agent = '$phonesys_id'  ";
        }

        $qa_query = " SELECT `QA_id`, `QA`.`Uniqueid`, `QA`.`opinion`, `cl`.`Recording`, `Score`, u.fname, `QAComment` as General_Comments, qs.QAS_Description FROM `QA` LEFT JOIN tbl_user u on QA.QAA_id=u.phonesys_id LEFT JOIN QAStatus qs on qs.QAStatus_id=`Status` 
        LEFT JOIN Call_log as cl on QA.Uniqueid = cl.Uniqueid
        WHERE qs.Stage < 5 $condition ORDER BY QA.Uniqueid DESC, QA.QA_id DESC , QA.opinion ASC";

        // AND `QA`.`Uniqueid`= '1583506816.123'
        
        $data['qa_data'] = $db->query($qa_query)->getResultArray();
       
        // echo $db->getLastQuery(); die;
        
        return view('admin/qa/manage', $data);
    }

    public function add() {
        
        $data['pg_title'] = 'Add QA';

        $db = db_connect();

        $phonesys_id = $this->session->get('phonesys_id');

        $condition = "";
        if($this->session->get('user_role_id') == 4)
        {
            $condition = "AND cl.Agent = '$phonesys_id'";
        }

        $unique_id = " SELECT cl.`Uniqueid`,`Campaign` as Camp_iD, c.Camp_Name, cl.Call_date, Agent, AVG(t.AI_Score) 
        FROM Transcriptions t 
        LEFT JOIN `Call_log` cl on t.`Uniqueid` = cl.Uniqueid 
        LEFT JOIN QA on QA.Uniqueid= t.Uniqueid 
        LEFT JOIN Campaign c ON c.Camp_id= cl.Campaign 
        WHERE QA.Uniqueid is NULL $condition
        GROUP BY t.`Uniqueid` 
        ORDER BY AVG(t.AI_Score) DESC LIMIT 1 ";
    
        // Git state changes

        $unique_id_data = $db->query( $unique_id )->getRowArray();

        $Uniqueid = $Camp_iD = '';
        if(isset($unique_id_data) && !empty($unique_id_data)) {
            $Uniqueid = $unique_id_data['Uniqueid'];
            $Camp_iD = $unique_id_data['Camp_iD'];
        }
        
        $data['Uniqueid'] = $Uniqueid;
        $data['Camp_iD'] = $Camp_iD;

        $user_list = $db->table('tbl_user as u');
        $user_list->select('*');
        $user_list->join('tbl_user_role rl','rl.user_pid = u.user_id', 'left');
        $user_list->where('u.is_active', 1);
        $user_list->where('rl.role_pid', 1);
        $user_list->where('phonesys_id !=', 'NULL');
        $user_list->where('phonesys_id !=', '');
        $user_list->orderBy('phonesys_id', 'ASC');
        $user_list_result = $user_list->get()->getResultArray();

        
        $data['user_list'] = $user_list_result;

        return view('admin/qa/add', $data);
    }

    public function save() {

        $response = array();
        $post = $this->request->getVar();

        /*echo '<pre>';
        print_r($post);
        echo '</pre>';*/
        // die;

        $QA = new QA_Model();

        $Uniqueid = $post['Uniqueid'];
        $Camp_id = $post['Camp_iD'];

        $date =date('Y-m-d H:i:s');

        $data = array(
            'Uniqueid' => $Uniqueid,
            'QAA_id' => $post['QAA_id'],
            'Status' => 2,
            'created' => $date,
        );


        $res = $QA->insert( $data );

        $QA_ID = $QA->getInsertID();
        // $db = db_connect();
        // echo $db->getLastQuery();
        // die;

        $QA_Details_Model = new QA_Details_Model();

        $db = db_connect();

        
        $Uniqueid_for_query = " SELECT * FROM `QACampForm` WHERE `Camp_pid`= '[ALL]' OR `Camp_pid`= '".$Camp_id."' ";

        $Uniqueid_for_details = $db->query( $Uniqueid_for_query )->getResultArray();

        // echo '<pre>';
        // print_r($Uniqueid_for_details);
        // echo '</pre>';
        // die;

        if(isset($Uniqueid_for_details) && !empty($Uniqueid_for_details)) {
            foreach ($Uniqueid_for_details as $qa_details_key => $qa_details_value) {
                
                $data_details = array(
                    'QA_pid' => $QA_ID,
                    'QAQues_pid' => $qa_details_value['QAQues_pid'],   
                );

                $QA_Details_Model->insert( $data_details );
            }
        }


        if( $res ) {
            $response['status'] = 1;
            $response['msg'] = 'Data inserted Successfully';
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Data inserted Successfully';
        }

        echo json_encode($response);
        die;

    }

    public function edit( $QA_id = '', $for_pdf = false ) {

        $data['pg_title'] = 'Add QA Form';
        $data['button_text'] = 'Submit';
        $data['mode'] = 'add';

        $db = db_connect();


        if(isset($QA_id) && !empty($QA_id)) {

            $data['pg_title'] = 'Edit QA Form';
            $data['button_text'] = 'Update';
            $data['mode'] = 'edit';

            $QA = new QA_Model;
            $QA_details = $QA->where( 'QA_id', $QA_id )->first();
            $Uniqueid = $QA_details['Uniqueid'];
            $data['QA_data'] = $QA_details;
            $data['Uniqueid'] = $QA_details['Uniqueid'];
            $QAA_id = $QA_details['QAA_id'];

            $QA_Details_Model = new QA_Details_Model();

            $QA_Details_deta = $QA_Details_Model->where( 'QA_pid', $QA_id )->first();

            $data['QA_details_data'] = $QA_Details_deta;
            $data['QA_id'] = $QA_id;


            $que_query = " SELECT `QA_Det_id`,q.Question, q.Notes,`Score`,`Comment`,`Response` FROM `QA_Details` qd LEFT JOIN QAQuestions q on q.QAQues_id=`QAQues_pid` WHERE qd.`QA_pid` = '".$QA_id."'  ";
            $que_details = $db->query( $que_query )->getResultArray();
            $data['que_data'] = $que_details;


            $cam_name_query = " SELECT cl.`Uniqueid`,`Campaign`, c.Camp_Name, cl.Call_date, Agent, AVG(t.AI_Score) FROM Transcriptions t LEFT JOIN `Call_log` cl on t.`Uniqueid` = cl.Uniqueid LEFT JOIN QA on QA.Uniqueid= t.Uniqueid LEFT JOIN Campaign c ON c.Camp_id= cl.Campaign WHERE QA.Uniqueid = '".$QA_details['Uniqueid']."' GROUP BY t.`Uniqueid` ORDER BY AVG(t.AI_Score) DESC LIMIT 10 ";
            

            $cam_details = $db->query( $cam_name_query )->getRowArray();

            $data['cam_details'] = $cam_details;

            $Users_Model = new Users_Model();
            $data['QAA_details'] = $Users_Model->where( 'phonesys_id', $QAA_id )->first();

            $CallLog = new CallLog();

            $call_log_details = $CallLog->where( 'Uniqueid', $QA_details['Uniqueid'] )->first();

            $data['call_log'] = $call_log_details;
            $Agent_id = $call_log_details['Agent'];

            $Users_Model = new Users_Model();
            $user_details = $Users_Model->where( 'phonesys_id', $Agent_id )->first();
            $data['user_details'] = $user_details;
            
           
            /*$transcript_query = "SELECT * FROM `Call_log` cl 
            LEFT JOIN Users u ON cl.Agent = u.User_id 
            LEFT JOIN Transcriptions t ON t.Uniqueid = cl.Uniqueid
            WHERE cl.Uniqueid = '".$Uniqueid."' ";*/

            $transcript = $db->table('Call_log as cl');
            $transcript->select('*');
            $transcript->join('tbl_user as u', 'cl.Agent = u.phonesys_id', 'left');
            // $transcript->join('tbl_user as u', 'cl.Agent = u.user_id', 'left');
            $transcript->join('Transcriptions as t', 't.Uniqueid = cl.Uniqueid', 'left');
            $transcript->join('TransEngine as te', 'te.Trans_eng_id = t.Trans_engine', 'left');
            $transcript->where('cl.Uniqueid', $Uniqueid);
            $transcript_result = $transcript->get()->getResultArray();

            $data['transcript_result'] = $transcript_result;

            
            // echo $db->getLastQuery();
            // echo '<pre>';
            // print_r($data['transcript_result']);
            // die;

            if( $for_pdf == true ) {
                return $data;
            }


        }

        return view('admin/qa/edit', $data);
    }

    

    public function save_edit() {

        $response = array();
        $post = $this->request->getVar();

        $QA = new QA_Model();

        $QA_id  = $post['QA_id'];

        $pdf_details = $this->export_pdf( $QA_id );
        
        $PDFfile = $pdf_details['filename'];

        $date = date('Y-m-d H:i:s');
        
        $data = array(
            'QA_Comment_good' => $post['QA_Comment_good'],
            'QA_Comment_bad' => $post['QA_Comment_bad'],
            'QAComment' => $post['QAComment'],
            'Status' => $post['Status'],
            'PDFfile' => $PDFfile,
            'updated' => $date,
        );

        $res = $QA->update( $QA_id, $data );

        if( $res ) {
            $response['status'] = 1;
            $response['msg'] = 'Data inserted Successfully';
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Data inserted Successfully';
        }

        echo json_encode($response);
        die;

    }

    public function save_qa() {

        $post = $this->request->getVar();

        $QA_Det_id  = $post['QA_Det_id'];
        $QA_id      = $post['QA_id'];
        $Score      = $post['Score'];
        $Comment    = $post['Comment'];


        $data = array(
            'Score'      => $post['Score'],
            'Comment'    => $post['Comment'],
        );

        $QA_Details_Model = new QA_Details_Model();

        $QA_Details_Model->update( $QA_Det_id, $data );


        $QA_Model = new QA_Model();
        $date =date('Y-m-d H:i:s');

        $QA_mode_data = array(
            'Status' => 2,
            'updated'    => $date,
        );

        $QA_Model->update( $QA_id , $QA_mode_data);

        $this->save_update_average_score( $QA_id );

        $response = array();

        $response['status'] = true;

        echo json_encode($response);
        die;

    }

    public function save_update_average_score( $QA_id ) {

        $QA_Details_Model = new QA_Details_Model();

        $QA_details_array = $QA_Details_Model->where( 'QA_pid', $QA_id )->findAll();

        $Score = 0;
        if(isset($QA_details_array) && !empty($QA_details_array)) {
            $total_records = count($QA_details_array);
            foreach ($QA_details_array as $qa_d_key => $qa_d_value) {
                $Score += $qa_d_value['Score'];
            }
        }

        

        $avg_score = ($Score / $total_records);

        $QA_Model = new QA_Model();
        $update_score = array( 'Score' => $avg_score );
        $QA_Model->update( $QA_id, $update_score);
        
    }

    function export_pdf( $QA_id ) {

        $details = $this->edit( $QA_id, true );

        
        $htmlContent = view("admin/qa/pdf_details", $details); die;

        $pdfName = "QA_Form_".date('mdY')."_".time().'.pdf'; 

        if (!file_exists(EXPORT_PDF)) {
            mkdir(EXPORT_PDF, 0777, true);
        }
        
        $filename_return = $this->createPDF(EXPORT_PDF.$pdfName, $htmlContent , $orientation = 'A4');
        $response = array();
        $response['filename'] = $pdfName;
        $response['filepath'] = EXPORT_PDF;

        return $response;
    }

    public function createPDF($fileName,$html,$orientation = 'A4') {

        $dompdf = new Dompdf();
        
        $dompdf->loadHtml($html);
        $dompdf->render();
        file_put_contents( $fileName , $dompdf->output());
        
    }
    function sending_test_email() {

        $email = \Config\Services::email();

        $email->setFrom('reports@augmentedqa.com', 'QA');
        $email->setTo('hitesh.vadoliya5130@gmail.com');
        
        $email->setSubject('my subject');
        $email->setMessage('Testing the email class.');
        // $email->attach($attachment);
        $a = $email->send();
        print_r(  $email->printDebugger()); 
        var_dump($a);
        die;
    }
    function sending_email() {

        $response = array();

        $post = $this->request->getVar();
        
        $QA_id = $post['QA_id'];

        $db = db_connect();

        $QA = new QA_Model();

        $pdf_details = $this->export_pdf( $QA_id );
        
        $PDFfile = $pdf_details['filename'];

        $date = date('Y-m-d H:i:s');
        
        $data = array(
            'PDFfile' => $PDFfile,
            'updated' => $date,
        );

        $QA->update( $QA_id, $data );

        $transcript = $db->table('QA as qa');
        $transcript->select('*');
        $transcript->join('Call_log as cl', 'cl.Uniqueid = qa.Uniqueid', 'left');        
        $transcript->join('tbl_user as u', 'cl.Agent = u.phonesys_id', 'left');
        $transcript->where('qa.QA_id', $QA_id);
        $transcript_result = $transcript->get()->getRowArray();

         
        // echo $db->getLastQuery(); die;
        // echo '<pre>';
        // print_r($transcript_result);
        // echo '</pre>';
        // die;
        if($transcript_result == NULL)
        {
            $response['status'] = false;
            $response['msg'] = 'Data not found';
            echo json_encode($response);
            die;
        }

        // echo '<pre>';
        // print_r($pdf_details);
        // print_r($transcript_result);
        // echo '</pre>';
        // die;
        
        if(isset($transcript_result) && !empty($transcript_result) && isset($transcript_result['email']) && $transcript_result['email'] != '') {

            $subject = 'Submission of QA Form PDF File for Customer Agent Review';

            $toEmail = $transcript_result['email'];
            $toEmails = array(
                $toEmail,
                'fabriciodq.test@gmail.com',
                'aileendomingo123@gmail.com'
            );
            
            $email = \Config\Services::email();

            $email->setFrom('reports@augmentedqa.com', 'QA');
            $email->setTo($toEmails);
            
            
            $email->setSubject($subject);
            
            $body = "Dear ".$transcript_result['fname'].", \r\n As part of our commitment to providing comprehensive and timely information, we are pleased to submit the QA Form report in PDF format for your review that you've requested.\r\n Attached to this email, you will find the PDF file named ".$transcript_result['PDFfile'].", which encapsulates. Thank you for your time and attention to this matter. We look forward to hearing your thoughts on the report.\r\n Best regards,\r\n AugmentedQA";
            
            $email->setMessage($body);
            
            if( $transcript_result['PDFfile'] != '' ) {
                $attachment  = EXPORT_PDF.$transcript_result['PDFfile'];
                $email->attach($attachment);
            }            
            $a = $email->send();
            // var_dump($a);
            // die;

            $QA_Model = new QA_Model();
            $date = date('Y-m-d H:i:s');
            $data_update = array(
                'Status' => 4, // it will be 4
                'PDFfile' => $PDFfile,
                'updated' => $date,
                'delivered' => $date
            );
            $QA_Model->update( $QA_id, $data_update );

            $response['status'] = true;
            $response['msg'] = 'Sent Successfully';

        } else {
            $response['status'] = false;
            $response['msg'] = 'Email Address not found';
        }

        
        echo json_encode($response);
        die;
    }
    
    public function review() {
        $data['pg_title'] = 'Augmented QA Review';

        $db = db_connect();
        $user_id = $this->session->get('phonesys_id');

        $qa_query = "SELECT * FROM `QA` q LEFT JOIN Call_log c on c.Uniqueid=q.`Uniqueid` WHERE c.Agent = '$user_id' and q.`Status` = 4";
        $data['reviews'] = $db->query($qa_query)->getResultArray();
        
        return view('admin/qa/review', $data);
    }
    
    public function response($QA_id) {
        $data['pg_title'] = 'Augmented QA Form Review';

        $db = db_connect();
        $qa_query = "SELECT * FROM `QA` q LEFT JOIN Call_log c on c.Uniqueid=q.`Uniqueid` WHERE c.Agent = '727' and q.`Status` = 4";
        $data['reviews'] = $db->query($qa_query)->getResultArray();

        $QA = new QA_Model;
        $QA->select('QA.*,c.*,camp.*,u.*,QA.Status as StatusQA');
        $QA->join('Call_log c','QA.Uniqueid = c.Uniqueid');
        $QA->join('Campaign camp','camp.Camp_id = c.Campaign','left');
        $QA->join('tbl_user u','u.phonesys_id = c.Agent','left');
        $data['qa'] = $QA->where( 'QA_id', $QA_id )->first();


        if($data['qa']['StatusQA'] != "4")
        {
            return redirect()->to('admin/qa/review'); 
        }

        $QADetail = new QA_Details_Model();
        $QADetail->join('QAQuestions qu','qu.QAQues_id = QA_Details.QAQues_pid');
        $data['qa_details'] = $QADetail->where('QA_pid',$QA_id)->get()->getResultArray();
        
        $data['id'] = $QA_id;
        return view('admin/qa/response', $data);
    }

    function response_store($QA_id) {
        if (! $this->validate([
            'response' => "required",
            'status'  => 'required'
        ])) {
            return $this->response->setStatusCode(422)->setJSON([
                'errors' => $this->validator->getErrors()
            ]);
        }

        $QAModel = new QA_Model;
        $questionData = $QAModel->find($QA_id);

        // Assuming you have form data, you can validate and save it
        $data = [
            'response' => $this->request->getPost('response'),
            'Status' => $this->request->getPost('status'),
            'reviewed' => date('Y-m-d H:i:s')
        ];

        $QAModel->update($QA_id,$data);

        return $this->response->setJSON(['message' => 'QA successfully updated']);
    }

    function secound_opinion() {
        
        $response = array();
        
        $QA = new QA_Model();
        $post = $this->request->getVar();        
        $QA_id = $post['QA_id'];

        $qa_form_details = $QA->where('QA_id',$QA_id)->get()->getRowArray();

        $Uniqueid = $qa_form_details['Uniqueid'];

        $total_count_result = $QA->where('Uniqueid',$Uniqueid)->get()->getResultArray();
        $total_count = count($total_count_result);
        if($total_count>1) {
            $response['status'] = false;
            $response['msg'] = 'You already created secound opinion';            
            echo json_encode($response);
            die;
        }
       

        $db = db_connect();

        $unique_id = " SELECT cl.`Uniqueid`,`Campaign` as Camp_iD, c.Camp_Name, cl.Call_date, Agent, AVG(t.AI_Score) 
        FROM Transcriptions t 
        LEFT JOIN `Call_log` cl on t.`Uniqueid` = cl.Uniqueid 
        LEFT JOIN QA on QA.Uniqueid= t.Uniqueid 
        LEFT JOIN Campaign c ON c.Camp_id= cl.Campaign 
        WHERE QA.Uniqueid = $Uniqueid
        GROUP BY t.`Uniqueid` 
        ORDER BY AVG(t.AI_Score) DESC LIMIT 1 ";

        $unique_id_data = $db->query( $unique_id )->getRowArray();

        $Uniqueid = $Camp_iD = '';
        if(isset($unique_id_data) && !empty($unique_id_data)) {
            $Uniqueid = $unique_id_data['Uniqueid'];
            $Camp_iD = $unique_id_data['Camp_iD'];
        }
        
        // ---------------------
        $Uniqueid;
        $QAA_id =  $qa_form_details['QAA_id'];
        $Camp_id = $Camp_iD;

        $date =     date('Y-m-d H:i:s');

        $data = array(
            'Uniqueid' => $Uniqueid,
            'opinion' => 2,
            'QAA_id' => $QAA_id,
            'Status' => 2,
            'created' => $date,
        );


        $res = $QA->insert( $data );

        $QA_ID = $QA->getInsertID();
        // $db = db_connect();          
        // echo $db->getLastQuery();
        // die;

        $QA_Details_Model = new QA_Details_Model();

        $db = db_connect();

        
        $Uniqueid_for_query = " SELECT * FROM `QACampForm` WHERE `Camp_pid`= '[ALL]' OR `Camp_pid`= '".$Camp_id."' ";

        $Uniqueid_for_details = $db->query( $Uniqueid_for_query )->getResultArray();

        if(isset($Uniqueid_for_details) && !empty($Uniqueid_for_details)) {
            foreach ($Uniqueid_for_details as $qa_details_key => $qa_details_value) {
                
                $data_details = array(
                    'QA_pid' => $QA_ID,
                    'QAQues_pid' => $qa_details_value['QAQues_pid'],   
                );

                $QA_Details_Model->insert( $data_details );
            }
        } 

        if( $res ) {
            $response['status'] = 1;
            $response['msg'] = 'Secound Opinion created Successfully';
        } else {
            $response['status'] = 1;
            $response['msg'] = 'Something Went Wrong..!';
        }

        echo json_encode($response);
        die;

    }
}
