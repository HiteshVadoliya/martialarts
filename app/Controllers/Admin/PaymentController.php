<?php 
namespace App\Controllers\ADMIN;


use App\Controllers\BaseController;
use App\Models\Admin\PaymentModel;
use App\Models\Admin\SchoolAllModel;
use App\Models\HWTModel;
use Config\Services;
use Dompdf\Dompdf;
class PaymentController extends BaseController
{
    function __construct()
    { 
        $this->folder = 'payment/';
        $this->Controller = 'PaymentController';
        $this->url = 'admin/payment';
        $this->MainTitle = "Payment";
        $this->id = "payment_id";
        $this->model = new PaymentModel();
        
        $session = Services::session();
        if ($session->get('is_admin_login') == NULL) {
            header('Location: '.base_url('auth/login'));
            exit();
        }
    }
    public function global_data() {

        $global_data = array();
        $global_data['Controller'] = $this->Controller;
        $global_data['url'] = $this->url;
        $global_data['MainTitle'] = $this->MainTitle;
        $global_data['pg_title'] = $this->MainTitle.' LIST';
        $global_data['id'] = $this->id;
        return $global_data;

    }
    public function index( ): string
    {   
        // HWTModel::get_schedule_details( 1 );
        // die;
        $data['Controller'] = $this->Controller;
        $data['url'] = $this->url;
        $data['MainTitle'] = $this->MainTitle;
        $data['pg_title'] = $this->MainTitle.' LIST';
        
        $db = db_connect();

        $PaymentModel = new PaymentModel();

        $phrases_details = $PaymentModel->paginate(2);
        $data['pagination_link'] = $PaymentModel->pager;        
        $data['phrases_details'] = $phrases_details;
        
        return view('admin/'.$this->folder.'manage', $data);
    }

    function add( $edit_id = '' )
    {
        $data = $this->global_data();
        $data['mode'] = 'add';
        // $SchoolAllModel = new SchoolAllModel();;
        // $data['school_pid'] = $SchoolAllModel->where('status',1)->where('isDelete',0)->findAll();

        // $data['class_pid'] = HWTModel::get_row( 'classes_all', array( 'isDelete' => 0, 'status' => 1 ) );
        // $data['weekdays_pid'] = HWTModel::get_row( 'weekdays', array( 'isDelete' => 0, 'status' => 1 ) );

        $db = db_connect();
        $builder = $db->table('tbl_user as u');
        $wh = array(
            'isDelete' => 0,
            'status' => 1,
            'role_pid' => 2,
        );
        $builder->where( $wh );
        $builder->join( 'tbl_user_role tr', 'tr.user_pid = u.user_id' );
        $query = $builder->get();
        $data['instructor_pid'] = $query->getResultArray();
       

        
        $MainModel = $this->model;

        if(isset($edit_id) && !empty($edit_id)) {
            
            $db = db_connect();
            $query = $db->table('payment');
            $query->select('*');
            // $query->join(' as sc', 'sc.school_id = s.school_pid');
            $query->where('payment_id',$edit_id);
            $user_data = $query->get()->getRowArray();

            // $Edit_data = $MainModel->where( $this->id, $edit_id )->first();
            $data['edit'] = $user_data;
            
            $data['mode'] = 'edit';

            $query = $db->table('payment');
            $query->select('*');
            $query->where('payment_main_id',$edit_id);
            $payment_data = $query->get()->getResultArray();
            $data['payment_data'] = $payment_data;
        }

        $data['mode'] = $data['mode'];
        $data['pg_title'] = $this->MainTitle.' '.ucfirst($data['mode']);

        return view('admin/'.$this->folder.'add', $data);
    }

    public function ajax_list(){

        $request = service('request');
        $postData = $request->getPost();
        $dtpostData = $postData['data'];
        $response = array();
 
        ## Read value
        $draw = $dtpostData['draw'];
        $start = $dtpostData['start'];
        $rowperpage = $dtpostData['length']; // Rows display per page
        $columnIndex = $dtpostData['order'][0]['column']; // Column index
        $columnName = $dtpostData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $dtpostData['order'][0]['dir']; // asc or desc
        $searchValue = $dtpostData['search']['value']; // Search value
 
        ## Total number of records without filtering
        $users = new PaymentModel();
        $query_total_records = $users->select($this->id);
        $query_total_records ->where('isDelete',0);
        $totalRecords = $query_total_records ->countAllResults();
 
        ## Total number of records with filtering
        $query_filter = $users->select($this->id);
        if(session('role') == 2) {
            $query_filter->where('instructor_pid',session('user_id'));    
        }
        $query_filter->where('isDelete',0);
        $query_filter->where('payment_main_id',NULL);
        // $query_filter->groupStart();
        // $query_filter->orLike('class_pid', $searchValue);
        // $query_filter->groupEnd();
        $totalRecordwithFilter = $query_filter->countAllResults();;
 
        ## Fetch records
        $query = $users->select('*');
        if(session('role') == 2) {
            $query->where('instructor_pid',session('user_id'));    
        }
        $query->where('isDelete',0);
        $query->where('payment_main_id',NULL);
        // $query->groupStart();
        // $query->orLike('class_pid', $searchValue);
        // $query->groupEnd();
        $query->orderBy($columnName,$columnSortOrder);
        $records = $query->findAll($rowperpage, $start);;
        
        $data = array();
        $SchoolAllModel = new SchoolAllModel();
        foreach ($records as $post) {
            
            $statuslbl = $post['status'] == '1' ? 'Active' : 'Deactive';
            $statusColor = $post['status'] == '1' ? 'success' : 'danger';
            $nestedData[$this->id] = $post[$this->id];

            $nestedData['effective_date_from'] = 'From : '.date('Y-m-d',strtotime($post['effective_date_from'])).' To : '.date('Y-m-d',strtotime($post['effective_date_to']));

            // $statuslblClass = $post['class_status'] == '1' ? 'Accepted' : 'Pending';
            // $statusColorClass = $post['class_status'] == '1' ? 'success' : 'danger';

            if(session('role') == 2) {
                // $nestedData['action'] = '&nbsp;<button data-id='.$post[$this->id].' data-status='.$post['class_status'].' class="btn btn-sm btn-'.$statusColorClass.' rowClassStatus " >'.$statuslblClass.'</button>';
            } else {
                $nestedData['action'] = '<button data-id='.$post[$this->id].' class="btn btn-sm btn-danger rowDelete delete_'.$post[$this->id].'">Delete</button>
                <a href='.base_url().$this->url.'/edit/'.$post[$this->id].' data-id='.$post[$this->id].' class="btn btn-sm btn-info " >Edit</a>
                <button data-id='.$post[$this->id].' data-status='.$post['status'].' class="btn btn-sm btn-'.$statusColor.' rowStatus " >'.$statuslbl.'</button>';

                $nestedData['action'] = '<a href='.base_url().$this->url.'/edit/'.$post[$this->id].' data-id='.$post[$this->id].' class="btn btn-sm btn-info " >Edit</a>';
            }
            $data[] = $nestedData;
        }
 
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data,
            "token" => csrf_hash()
        );
 
        return $this->response->setJSON($response);
    }
    function get_week( $date ){
        $ddate = date('Y-m-d',strtotime($date));
        $duedt = explode("-", $ddate);
        $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
        $week  = (int)date('W', $date);
        return $week;

    }
    function store()
    {
        $post = $this->request->getVar(); 
        
        
        $edit_id = $post['edit_id'];
        $mode = $post['mode'];
        
        //$instructor_pid = $post['instructor_pid'];
        $effective_date = $post['effective_date'];
        $effective_date_ex = explode(" - ", $post['effective_date']);
        $effective_date_from = date('Y-m-d',strtotime($effective_date_ex[0]));
        $effective_date_to = date('Y-m-d',strtotime($effective_date_ex[1]));

        $response = array();       
        $MainModel = $this->model;
        $data = array(
            'effective_date' => $effective_date,
            'effective_date_from' => $effective_date_from,
            'effective_date_to' => $effective_date_to,
        );
       
        if(isset($post['edit_id']) && $post['mode'] == 'edit') {
            $last_id = $edit_id = $post['edit_id'];
            $instructor_pid = $post['instructor_pid'];
            $total_hrs = $post['total_hrs'];
            if(isset($instructor_pid) && !empty($instructor_pid)) {
                foreach ($instructor_pid as $int_key => $int_value) {
                    $wh = array(
                        'payment_main_id' => $edit_id,
                        'instructor_pid' => $int_value,
                    );
                    $user_details = HWTModel::get_row('tbl_user', array( 'user_id' => $int_value ));
                    $hr_rate = $user_details[0]['hr_rate'];
                    $total_hrs_rate = $total_hrs[$int_key];
                    $total_payment = $hr_rate * $total_hrs_rate;
                    $update_data = array(
                        'payment_main_id' => $edit_id,
                        'instructor_pid' => $int_value,
                        'total_hrs' => $total_hrs_rate,
                        'hourly_rate' => $hr_rate,
                        'total_payment' => $total_payment,
                        'updated_at' => date('Y-m-d H:i:s'),
                    );
                    HWTModel::add_or_update( 'payment', $wh , $update_data );
                }
            }
          
            $data['updated_at'] = date('Y-m-d H:i:s');
            $MainModel->update( $edit_id, $data );
            $response['status'] = true;
            $response['msg'] = 'Data Updated Successfully';
            $response['last_id'] = $last_id;
        } else {
            $res = $MainModel->insert( $data );
            $last_id = $MainModel->getInsertID();

            if( $res ) {
                $response['status'] = true;
                $response['last_id'] = $last_id;
                $response['msg'] = 'Data inserted Successfully';
            } else {
                $response['status'] = false;
                $response['last_id'] = 0;
                $response['msg'] = 'Something Went Wrong..!';
            }

        }
        $response['url'] = base_url('admin/payment/edit/'.$last_id);

        $response['status'] = true;
        echo json_encode($response);
        die;
        
    }

    function status( ) {

        $post = $this->request->getVar();

        $id = $post['id'];        
        $status = ($post['status'] == 1) ? 0 : 1;
        $MainModel = $this->model;

        $wh = array(
            $this->id => $id
        );        
        $data = array(
            'status' => $status
        );        
        $res = $MainModel->update($wh, $data);
        
        $response = array();
        if($res) {
            $response['status'] = true;
            $response['msg'] = 'Status Updated Successfully';
        } else {
            $response['status'] = false;
            $response['msg'] = 'Something Went Wrong..!';
        }

        echo json_encode($response);
        die;
    }

    function Classstatus( ) {

        $post = $this->request->getVar();

        $id = $post['id'];        
        $status = ($post['status'] == 1) ? 0 : 1;
        $MainModel = $this->model;

        $wh = array(
            $this->id => $id
        );        
        $data = array(
            'class_status' => $status
        );        
        $res = $MainModel->update($wh, $data);
        
        $response = array();
        if($res) {
            $response['status'] = true;
            $response['msg'] = 'Status Updated Successfully';
        } else {
            $response['status'] = false;
            $response['msg'] = 'Something Went Wrong..!';
        }

        echo json_encode($response);
        die;
    }
    function delete( ) {

        $post = $this->request->getVar();

        $did = $post['did'];        
        $MainModel = $this->model;
        $wh = array(
            $this->id => $did
        );        
        $data = array(
            'isDelete' => 1
        );        
        $res = $MainModel->delete( $did );
        // $res = $MainModel->update($wh, $data);
        
        $response = array();
        if($res) {
            $response['status'] = true;
            $response['msg'] = 'Data Deleted Successfully';
        } else {
            $response['status'] = false;
            $response['msg'] = 'Something Went Wrong..!';
        }

        echo json_encode($response);
        die;
    }

    function export_pdf() {

        $post = $this->request->getVar();
        $payment_id = $post['payment_id'];
        
        $db = db_connect();
		$builder = $db->table( 'payment p' );
		$builder->where( array( 'p.isDelete' => 0, 'p.status' => 1, 'p.payment_main_id' => $payment_id ) );
		$builder->join( 'tbl_user as u', 'u.user_id = p.instructor_pid' );
		$data['payment_data'] = $builder->get()->getResultArray();
        // echo '<pre>';
        // print_r($data['payment_data']);
        // echo '</pre>';
        // die;
        $builder = $db->table( 'payment p' );
        $builder->where( array( 'p.isDelete' => 0, 'p.status' => 1, 'p.payment_id' => $payment_id ) );
        $data['payment_main_data'] = $builder->get()->getRowArray();

        $htmlContent = view('admin/'.$this->folder.'pdf_details', $data);
        
        $pdfName = "payment_".date('mdY')."_".time().'.pdf'; 

        if (!file_exists(EXPORT_PDF)) {
            mkdir(EXPORT_PDF, 0777, true);
        }
        
        $filename_return = $this->createPDF(EXPORT_PDF.$pdfName, $htmlContent , $orientation = 'A4');
        $response = array();
        $response['filename'] = $pdfName;
        $response['filepath'] = EXPORT_PDF;

        echo json_encode($response);
        die;
    }

    public function createPDF($fileName,$html,$orientation = 'A4') {

        $dompdf = new Dompdf();
        
        $dompdf->loadHtml($html);
        $dompdf->render();
        file_put_contents( $fileName , $dompdf->output());
    }

    function export_pdf_old() {

        $post = $this->request->getVar();
        
        $db = db_connect();
		$builder = $db->table( 'schedule' );
		$builder->where( array( 'isDelete' => 0, 'status' => 1 ) );
		$builder->orderBy('week', 'ASC');
		$builder->orderBy('day_number', 'ASC');
		$result = $builder->get()->getResultArray();

        $SchoolAllModel = new SchoolAllModel();;
        $data['schools'] = $SchoolAllModel->where('status',1)->where('isDelete',0)->findAll();
        $data['result'] = $result;        
        $htmlContent = view('admin/'.$this->folder.'pdf_details', $data);

        $pdfName = "schedule_".date('mdY')."_".time().'.pdf'; 

        if (!file_exists(EXPORT_PDF)) {
            mkdir(EXPORT_PDF, 0777, true);
        }
        
        $filename_return = $this->createPDF(EXPORT_PDF.$pdfName, $htmlContent , $orientation = 'A4');
        $response = array();
        $response['filename'] = $pdfName;
        $response['filepath'] = EXPORT_PDF;

        echo json_encode($response);
        die;
    }
    
}
