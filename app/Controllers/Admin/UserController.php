<?php 
namespace App\Controllers\ADMIN;


use App\Controllers\BaseController;
use App\Models\Admin\Users_Model;
use App\Models\Admin\UserRolesModel;
use App\Models\Admin\InstructorLevelModel;
use App\Models\Admin\RankModel;
use App\Models\Admin\ClassesAllModel;
use App\Models\Admin\LocationModel;
use App\Models\Admin\RoleModel;
use App\Models\HWTModel;
use Config\Services;
use CodeIgniter\Config\BaseConfig;

class UserController extends BaseController
{
    function __construct()
    { 
        $this->folder = 'users/';
        $this->Controller = 'users';
        $this->url = 'admin/users';
        $this->MainTitle = "Users";
        $this->id = "user_id";
        $this->model = new Users_Model();
        
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
        $data = $this->global_data();
        $db = db_connect();

        $Users_Model = new Users_Model();

        $phrases_details = $Users_Model->paginate(15);
        $data['pagination_link'] = $Users_Model->pager;        
        $data['phrases_details'] = $phrases_details;

        $RoleModel = new RoleModel();;
        $data['roles_list'] = $RoleModel->where('role_id !=',1)->findAll();

        $by_role = (isset($_GET['by_role']))? $_GET['by_role'] : '';
        $data['by_role'] = $by_role;
        $wh = array(
			'isDelete' => 0,
			'role_id !=' => 1,
		);
        if( $by_role > 0 ) {
            $wh['role_id'] = $by_role;
        }
        $builder = $db->table( 'tbl_user tu' );
        $builder->where($wh);
        $builder->join( ' tbl_user_role tur', 'tur.user_pid = tu.user_id' );
        $builder->join( 'tbl_role tr', 'tr.role_id = tur.role_pid' );
        $query = $builder->get();
        $records = $query->getResultArray();
        $data['records_list'] = $records;

        // $query = $Users_Model->select('*');
        // $query->where('isDelete',0);
        // if( $by_role != '' ) {
        //     $query->where('user_id',$by_role);
        // }
        // $query->where('user_id !=',1);
        // $records = $query->findAll();
        // $data['records_list'] = $records;

        return view('admin/'.$this->folder.'manage', $data);
    }

    function add( $edit_id = '' )
    {
        $data = $this->global_data();
        $data['mode'] = 'add';
        $InstructorLevelModel = new InstructorLevelModel();;
        $data['level'] = $InstructorLevelModel->where('status',1)->where('isDelete',0)->findAll();
        $RankModel = new RankModel();;
        $data['rank'] = $RankModel->where('status',1)->where('isDelete',0)->findAll();
        $ClassesAllModel = new ClassesAllModel();;
        $data['classes'] = $ClassesAllModel->where('status',1)->where('isDelete',0)->findAll();
        $LocationModel = new LocationModel();;
        $data['location'] = $LocationModel->where('status',1)->where('isDelete',0)->findAll();
        $RoleModel = new RoleModel();;
        $data['roles'] = $RoleModel->where('role_id !=',1)->findAll();
       
        
        $MainModel = $this->model;

        if(isset($edit_id) && !empty($edit_id)) {
            echo $edit_id;
            $db = db_connect();
            $query = $db->table('tbl_user as u');
            $query->select('*');
            $query->join('tbl_user_role as ur', 'ur.user_pid = u.user_id');
            $query->join('tbl_role as role', 'role.role_id = ur.role_pid');
            $query->where('u.user_id',$edit_id);
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
        $users = new Users_Model();
        $totalRecords = $users->select('user_id')
                        ->where('isDelete',0)
                        ->where('user_id !=',1)
                        ->countAllResults();
 
        ## Total number of records with filtering
        $totalRecordwithFilter = $users->select('user_id')
            ->where('isDelete',0)
            ->where('user_id !=',1)
            ->groupStart()
            ->orLike('fname', $searchValue)
            ->orLike('email', $searchValue)
            ->groupEnd()
            ->countAllResults();
 
        ## Fetch records
        $records = $users->select('*')
            ->where('isDelete',0)
            ->where('user_id !=',1)
            ->groupStart()
            ->orLike('fname', $searchValue)
            ->orLike('email', $searchValue)
            ->groupEnd()
            ->orderBy($columnName,$columnSortOrder)
            ->findAll($rowperpage, $start);
 
        $data = array();
 
        foreach ($records as $post) {
            
            $statuslbl = $post['status'] == '1' ? 'Active' : 'Deactive';
            $statusColor = $post['status'] == '1' ? 'success' : 'danger';
            $nestedData['user_id'] = $post['user_id'];
            $nestedData['fname'] = $post['fname'];
            $userDetails = HWTModel::get_user_by_id( $post['user_id'] );            
            $nestedData['role'] = $userDetails['role'];
            $nestedData['email'] = $post['email'];
            
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
        $fname = $post['fname'];
        $b_date = date('Y-m-d',strtotime($post['b_date']));
        $phone = $post['phone'];
        $hr_rate = $post['hr_rate'];
        $level_pid = $post['level_pid'];
        $rank_pid = $post['rank_pid'];
        $class_pid = implode(",",$post['class_pid']);
        $location_pid = implode(",",$post['location_pid']);
        $email = $post['email'];
        $password = $post['password'];

        $role = $post['role_id'];
        $response = array();       
        $MainModel = $this->model;
        $data = array(
            'fname' => $fname,
            'b_date' => $b_date,
            'phone' => $phone,
            'hr_rate' => $hr_rate,
            'level_pid' => $level_pid,
            'rank_pid' => $rank_pid,
            'class_pid' => $class_pid,
            'location_pid' => $location_pid,
            'email' => $email,
        );
       
        if( $password != '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if(isset($post['edit_id']) && $post['mode'] == 'edit') {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $MainModel->update( $edit_id, $data );
            $db = db_connect();

            $builder = $db->table('tbl_user_role');
            $role_data = [
                'role_pid' => $role,
            ];

            $wh_data = array(
                'user_pid' => $edit_id,
            );
            $builder->set($role_data);
            $builder->where($wh_data);
            $builder->update();

            $response['status'] = true;
            $response['msg'] = 'Data Updated Successfully';
        } else {
            $res = $MainModel->insert( $data );
            $last_id = $MainModel->getInsertID();

            if( $res ) {
                $UserRolesModel = new UserRolesModel();
                $role_data = array(
                    'user_pid' => $last_id,
                    'role_pid' => $role,
                );
                $UserRolesModel->insert( $role_data );

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
