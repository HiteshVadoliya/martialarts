<?php 
namespace App\Controllers\ADMIN;

use App\Controllers\BaseController;
use App\Models\Admin\QACampFormModel;
use App\Models\Admin\CampaignModel;
use CodeIgniter\Config\Services;

class QA_Campain_Form extends BaseController
{
    public function __construct() {
        $session = Services::session();
        if ($session->get('is_admin_login') == NULL) {
            header('Location: '.base_url('auth/login'));
            exit();
        }
    }
    
    public function index( $camp_pid = '' ): string
    {   
        $data['pg_title'] = 'QA Campain Form';

        $QA_Form = new QACampFormModel();
        $db = db_connect();

        /*$db = db_connect();

        $qry = 'SELECT cf.`Camp_pid`, count(*) as Questions, AVG( if(`weight` is NULL,1,0))*100 as Percent_Unweighted , AVG( if(`FormOrder` is NULL,1,0))*100 as Percent_unordered  FROM `QACampForm` cf
        LEFT JOIN Campaign c on c.Camp_id = cf.`Camp_pid`
        GROUP BY cf.`Camp_pid`';

        $res =  $db->simpleQuery($qry);*/


        /*$db = db_connect();

        $qry = 'SELECT * FROM campaign';

        $res =  $db->simpleQuery($qry);*/

        $Campaign = new CampaignModel();
        $data['camp_list'] = $Campaign->orderBy('Camp_id','DESC')->paginate(100);
        $not_in = array();
        if(isset($camp_pid) && !empty($camp_pid)) {
            $camp_pid = $camp_pid;

            // $data['camp_data'] = $QA_Form->where('Camp_pid', $camp_pid)->paginate(10);

            $query_with_quatioin = " SELECT * FROM `QACampForm` cf LEFT JOIN QAQuestions q on cf.QAQues_pid = q.`QAQues_id` WHERE cf.Camp_pid = '".$camp_pid."' ";
            

            $data['camp_data'] = $db->query($query_with_quatioin)->getResultArray();;
            /*echo '<pre>';
            print_r($data['camp_data']);
            echo '</pre>';*/
            $data['camp_pid'] = $camp_pid;
            $data['pagination_link'] = $QA_Form->pager;

            
            foreach ($data['camp_data'] as $ca_key => $ca_value) {
                $not_in[] = $ca_value['QAQues_id'];
            }

            $query_with_all = " SELECT * FROM `QACampForm` cf LEFT JOIN QAQuestions q on cf.QAQues_pid = q.`QAQues_id` WHERE cf.Camp_pid = '[ALL]' ";
            $result_with_all_array = $db->query($query_with_all)->getResultArray();

            if(isset($result_with_all_array) && !empty($result_with_all_array)) {
                foreach ($result_with_all_array as $all_key => $all_value) {
                    $not_in[] = $all_value['QAQues_id'];
                }
            }
            

            /*echo '<pre>';
            print_r($not_in);
            echo '</pre>';*/
            // $not_in = implode(",", $not_in);


            
        }



        // echo $query = "SELECT * FROM QAQuestions q LEFT JOIN `QACampForm` cf on q.QAQues_id=cf.`QAQues_pid` WHERE `cf`.`Camp_pid` is NULL OR (`cf`.`Camp_pid` != 'TC7' AND `cf`.`Camp_pid` != 'BE' AND `cf`.`Camp_pid` != '[ALL]' )";

        // echo $query = "SELECT * FROM QAQuestions q LEFT JOIN `QACampForm` cf on q.QAQues_id=cf.`QAQues_pid` WHERE `cf`.`Camp_pid` is NULL OR (`cf`.`Camp_pid` != 'TC7' AND `cf`.`Camp_pid` != 'BE' AND `cf`.`Camp_pid` != '[ALL]' AND `cf`.`Camp_pid` is NULL  )";

        $query = " SELECT * FROM QAQuestions q LEFT JOIN `QACampForm` cf on q.QAQues_id=cf.`QAQues_pid` WHERE `cf`.`Camp_pid` is NULL OR (`cf`.`Camp_pid` != '".$camp_pid."' AND `cf`.`Camp_pid` != '[ALL]'  ) AND cf.QAQues_pid NOT IN (  '" . implode( "', '" , $not_in ) . "' ) GROUP BY q.QAQues_id";
            

        

        

        $data['checkbox'] = $db->query($query)->getResult();
        
        return view('admin/qaform/index', $data);
    }

    function qa_submit() {

        $post = $_POST;
        $camp_pid = $post['camp_pid'];

        if(isset($post['selected_question']) && !empty($post['selected_question'])) {
            $selected_question = $post['selected_question'];

            $QA_Form = new QACampFormModel(); 

            if(isset($selected_question) && !empty($selected_question)) {
                foreach ($selected_question as $qa_key => $qa_value) {
                    
                    $data_update = [
                        'Camp_pid'         => $camp_pid,
                        'QAQues_pid'       => $qa_value,
                    ];

                    $already = $QA_Form->where( $data_update )->first();

                    if(!isset($already) && empty($already)) {
                        $QA_Form->insert( $data_update );
                    }               

                }
            }
        }

        return redirect()->to(previous_url());        
    }

    function qa_delete( $did ) {

        $QA_Form = new QACampFormModel(); 

        $QA_Form->where('QACF_id', $did)->delete();

        return redirect()->to(previous_url());

    }

    function add()
    {

        $data['pg_title'] = 'QA Campain Form Add';
        return view('admin/qaform/add', $data);
    }

    function edit( $QACF_id )
    {
        $QACF_id;

        $QA_Form = new QACampFormModel();
        
        $data['qa_data'] = $QA_Form->where('QACF_id', $QACF_id)->first();

        
        $data['pg_title'] = 'QA Campain Form Edit';
        return view('admin/qaform/add', $data);
    }

    function edit_save( )
    {
        $post = $this->request->getVar(); 
        $response = array();       

        $QACF_id = $post['QACF_id'];
        $weight = $post['weight'];
        $FormOrder = $post['FormOrder'];

        $QA_Form = new QACampFormModel();

        $update_data = array(
            'weight' => $weight,
            'FormOrder' => $FormOrder,
        );

        $a = $QA_Form->update( $QACF_id, $update_data );

        $QA_Form->getLastQuery()->getQuery();

        $response['status'] = true;
        echo json_encode($response);
        die;
        
    }
}
