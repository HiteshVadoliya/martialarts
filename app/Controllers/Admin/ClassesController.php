<?php 
namespace App\Controllers\ADMIN;


use App\Controllers\BaseController;
use App\Models\Admin\ClassesAllModel;
use App\Models\Admin\UserRolesModel;
use App\Models\Admin\InstructorLevelModel;
use App\Models\Admin\RankModel;
use App\Models\Admin\LocationModel;
use App\Models\Admin\RoleModel;
use App\Models\HWTModel;
use Config\Services;
use CodeIgniter\Config\BaseConfig;

class ClassesController extends BaseController
{
    function __construct()
    { 
        $this->folder = 'classes/';
        $this->Controller = 'ClassesController';
        $this->url = 'admin/classes';
        $this->MainTitle = "Class";
        $this->id = "class_id";
        $this->model = new ClassesAllModel();
        
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

        $data['Controller'] = $this->Controller;
        $data['url'] = $this->url;
        $data['MainTitle'] = $this->MainTitle;
        $data['pg_title'] = $this->MainTitle.' LIST';
        
        $db = db_connect();

        $ClassesAllModel = new ClassesAllModel();

        $phrases_details = $ClassesAllModel->paginate(15);
        $data['pagination_link'] = $ClassesAllModel->pager;        
        $data['phrases_details'] = $phrases_details;
        
        return view('admin/'.$this->folder.'manage', $data);
    }

    function add( $edit_id = '' )
    {
        $data = $this->global_data();
        $data['mode'] = 'add';
        
        $MainModel = $this->model;

        if(isset($edit_id) && !empty($edit_id)) {
            $Edit_data = $MainModel->where( $this->id, $edit_id )->first();
            $data['edit'] = $Edit_data;            
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
        $users = new ClassesAllModel();
        $totalRecords = $users->select($this->id)
                        ->where('isDelete',0)
                        ->countAllResults();
 
        ## Total number of records with filtering
        $totalRecordwithFilter = $users->select($this->id)
            ->where('isDelete',0)
            ->groupStart()
            ->orLike('class_title', $searchValue)
            ->groupEnd()
            ->countAllResults();
 
        ## Fetch records
        $records = $users->select('*')
            ->where('isDelete',0)
            ->groupStart()
            ->orLike('class_title', $searchValue)
            ->groupEnd()
            ->orderBy($columnName,$columnSortOrder)
            ->findAll($rowperpage, $start);
 
        $data = array();
 
        foreach ($records as $post) {
            
            $statuslbl = $post['status'] == '1' ? 'Active' : 'Deactive';
            $statusColor = $post['status'] == '1' ? 'success' : 'danger';
            $nestedData['class_id'] = $post['class_id'];
            $nestedData['class_title'] = $post['class_title'];
            
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

    function store()
    {
        $post = $this->request->getVar(); 
        
        $edit_id = $post['edit_id'];
        $mode = $post['mode'];
        $class_title = $post['class_title'];
        
        $response = array();       
        $MainModel = $this->model;
        $data = array(
            'class_title' => $class_title,
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
    
}
