<?php 
namespace App\Controllers\ADMIN;


use App\Controllers\BaseController;
use App\Models\Admin\ScheduleModel;
use App\Models\Admin\SchoolAllModel;
use App\Models\HWTModel;
use Config\Services;
use Dompdf\Dompdf;

class ScheduleController extends BaseController
{
    function __construct()
    { 
        $this->folder = 'schedule/';
        $this->Controller = 'ScheduleController';
        $this->url = 'admin/schedule';
        $this->MainTitle = "Schedule";
        $this->id = "schedule_id";
        $this->model = new ScheduleModel();
        
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

        $ScheduleModel = new ScheduleModel();

        $phrases_details = $ScheduleModel->paginate(15);
        $data['pagination_link'] = $ScheduleModel->pager;        
        $data['phrases_details'] = $phrases_details;
        
        return view('admin/'.$this->folder.'manage', $data);
    }

    function add( $edit_id = '' )
    {
        $data = $this->global_data();
        $data['mode'] = 'add';
        $SchoolAllModel = new SchoolAllModel();;
        $data['school_pid'] = $SchoolAllModel->where('status',1)->where('isDelete',0)->findAll();

        $data['class_pid'] = HWTModel::get_row( 'classes_all', array( 'isDelete' => 0, 'status' => 1 ) );
        $data['weekdays_pid'] = HWTModel::get_row( 'weekdays', array( 'isDelete' => 0, 'status' => 1 ) );

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
            $query = $db->table('schedule as s');
            $query->select('*');
            $query->join('school_all as sc', 'sc.school_id = s.school_pid');
            $query->where('s.schedule_id',$edit_id);
            $user_data = $query->get()->getRowArray();

            // $Edit_data = $MainModel->where( $this->id, $edit_id )->first();
            $data['edit'] = $user_data;
            
            $data['mode'] = 'edit';
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
        $users = new ScheduleModel();
        $totalRecords = $users->select($this->id)
                        ->where('isDelete',0)
                        ->countAllResults();
 
        ## Total number of records with filtering
        $totalRecordwithFilter = $users->select($this->id)
            ->where('isDelete',0)
            ->groupStart()
            ->orLike('class_pid', $searchValue)
            ->groupEnd()
            ->countAllResults();
 
        ## Fetch records
        $records = $users->select('*')
            ->where('isDelete',0)
            ->groupStart()
            ->orLike('class_pid', $searchValue)
            ->groupEnd()
            ->orderBy($columnName,$columnSortOrder)
            ->findAll($rowperpage, $start);
 
        $data = array();
        $SchoolAllModel = new SchoolAllModel();
        foreach ($records as $post) {
            
            $statuslbl = $post['status'] == '1' ? 'Active' : 'Deactive';
            $statusColor = $post['status'] == '1' ? 'success' : 'danger';
            $nestedData[$this->id] = $post[$this->id];

            $class_pid = HWTModel::get_row('classes_all', array( 'class_id' => $post['class_pid']));
            $nestedData['class_pid'] = $class_pid[0]['class_title'];

            $school_pid = HWTModel::get_row('school_all', array( 'school_id' => $post['school_pid']));
            $nestedData['school_pid'] = $school_pid[0]['school_title'];

            $instructor_pid = HWTModel::get_row('tbl_user', array( 'user_id' => $post['instructor_pid']));
            $nestedData['instructor_pid'] = $instructor_pid[0]['fname'];

            $weekday_pid = HWTModel::get_row('weekdays', array( 'weekdays_id' => $post['weekday_pid']));
            $nestedData['weekday_pid'] = $weekday_pid[0]['week_title'].' '.$post['day_time'];
            $nestedData['effective_date_from'] = 'From : '.date('Y-m-d',strtotime($post['effective_date_from'])).' To : '.date('Y-m-d',strtotime($post['effective_date_to']));

            $nestedData['action'] = '<button data-id='.$post[$this->id].' class="btn btn-sm btn-danger rowDelete delete_'.$post[$this->id].'">Delete</button>
            <a href='.base_url().$this->url.'/edit/'.$post[$this->id].' data-id='.$post[$this->id].' class="btn btn-sm btn-info " >Edit</a>
            <button data-id='.$post[$this->id].' data-status='.$post['status'].' class="btn btn-sm btn-'.$statusColor.' rowStatus " >'.$statuslbl.'</button>';
            
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
        
        $class_pid = $post['class_pid'];
        $school_pid = $post['school_pid'];
        $instructor_pid = $post['instructor_pid'];
        $weekday_pid = $post['weekday_pid'];
        $day_time = $post['day_time'];
        $effective_date = $post['effective_date'];
        $effective_date_ex = explode(" - ", $post['effective_date']);
        $effective_date_from = date('Y-m-d',strtotime($effective_date_ex[0]));
        $effective_date_to = date('Y-m-d',strtotime($effective_date_ex[1]));

        $response = array();       
        $MainModel = $this->model;
        $data = array(
            'class_pid' => $class_pid,
            'school_pid' => $school_pid,
            'instructor_pid' => $instructor_pid,
            'weekday_pid' => $weekday_pid,
            'day_time' => $day_time,
            'effective_date' => $effective_date,
            'effective_date_from' => $effective_date_from,
            'effective_date_to' => $effective_date_to,
        );
       
        if(isset($post['edit_id']) && $post['mode'] == 'edit') {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $MainModel->update( $edit_id, $data );
            $response['status'] = true;
            $response['msg'] = 'Data Updated Successfully';
        } else {
            $res = $MainModel->insert( $data );
            $last_id = $MainModel->getInsertID();

            if( $res ) {
                $response['status'] = true;
                $response['msg'] = 'Data inserted Successfully';
            } else {
                $response['status'] = false;
                $response['msg'] = 'Something Went Wrong..!';
            }
        }

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
        $res = $MainModel->update($wh, $data);
        
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
        
        $db = db_connect();
		// $builder = $db->table( 'schedule' );
		// $builder->where( array( 'isDelete' => 0, 'status' => 1 ) );
		// $builder->orderBy('week', 'ASC');
		// $builder->orderBy('day_number', 'ASC');
		// $result = $builder->get()->getResultArray();

        $SchoolAllModel = new SchoolAllModel();;
        $data['schools'] = $SchoolAllModel->where('status',1)->where('isDelete',0)->findAll();
        $data['weekdays'] = HWTModel::get_row( 'weekdays', array( 'isDelete' => 0,'status' => 1 ), 'list' );
             
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
