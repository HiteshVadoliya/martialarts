<?php 
namespace App\Controllers\ADMIN;


use App\Controllers\BaseController;
use App\Models\Admin\Phrases_Model;
use App\Models\Admin\CampaignModel;
use CodeIgniter\Config\Services;

use CodeIgniter\Config\BaseConfig;

class Phrases extends BaseController
{
    function __construct()
    { 
        $this->folder = 'phrases/';
        $this->Controller = 'Phrases';
        $this->url = 'admin/phrases';
        $this->MainTitle = "Phrases";
        $this->id = "Phrase_id";
        $this->model = new Phrases_Model();
        
        $session = Services::session();
        if ($session->get('is_admin_login') == NULL) {
            header('Location: '.base_url('auth/login'));
            exit();
        }
    }
    public function index( ): string
    {   

        $data['Controller'] = $this->Controller;
        $data['url'] = $this->url;
        $data['MainTitle'] = $this->MainTitle;
        $data['pg_title'] = 'Phrases LIST';
        
        $db = db_connect();

        $Phrases_Model = new Phrases_Model();

        $phrases_details = $Phrases_Model->orderBy('Phrase_id','DESC')->paginate(15);
        $data['pagination_link'] = $Phrases_Model->pager;        
        $data['phrases_details'] = $phrases_details;
        
        return view('admin/'.$this->folder.'manage', $data);
    }

    function add( $Phrase_id = '' )
    {
        $data['Controller'] = $this->Controller;
        $data['url'] = $this->url;
        $data['MainTitle'] = $this->MainTitle;
        $data['mode'] = 'add';
        $data['button'] = 'Submit';
        $data['pg_title'] = 'Phrases LIST';

        $MainModel = $this->model;

        $CampaignModel = new CampaignModel();
        $campaign_list = $CampaignModel->findAll();

        $data['campaign_list'] = $campaign_list;



        if(isset($Phrase_id) && !empty($Phrase_id)) {
            $Edit_data = $MainModel->where( $this->id, $Phrase_id )->first();
            $data['edit'] = $Edit_data;
            $data['button'] = 'Update';
            $data['mode'] = 'edit';
        }

        return view('admin/'.$this->folder.'add', $data);
    }

    function save( )
    {
        $post = $this->request->getVar(); 
      
        $Good = (isset($post['Good'])) ? 1 : 0;
        
        $response = array();       
        $MainModel = $this->model;
        $data = array(
            'Phrase' => $post['Phrase'],
            'Good' => $Good,
            'Weight' => $post['Weight'],
            'Camp_pid' => $post['Camp_pid'],
            // 'Client' => $post['Client'],
        );

        if(isset($post['Phrase_id']) && $post['mode'] == 'edit') {
            $MainModel->update( $post['Phrase_id'], $data );
            $response['status'] = true;
            $response['msg'] = 'Data Updated Successfully';
        } else {
            $res = $MainModel->insert( $data );
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

    function delete( ) {

        $post = $this->request->getVar();

        $did = $post['did'];
        
        $MainModel = $this->model;

        $res = $MainModel->delete( $did );

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
