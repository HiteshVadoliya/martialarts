<?php
//namespace App\Controllers;
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\ManageUserModel;
use App\Libraries\HashLib;

class ManageUser extends BaseController
{
    protected $hashLib;

    public function __construct()
    {
        $this->hashLib = new Hashlib();
    }

    public function index()
    {
        echo 'HELLO';
    }

    public function userList()
    {
        $ddebug = false; 
        $manageUserModel = new ManageUserModel();
        $user_arr = $manageUserModel->get_users();
        if($ddebug){ echo ' === [ user_arr ] ===> <pre>'; print_r($user_arr); echo '</pre>'; }

        $data['pg_title'] = 'User list';
        $data['url'] = base_url('/admin/manageuser/');
        $data['user_arr'] = $user_arr;
        return view('admin/manageuser/user_list', $data);
    }

    public function userAdd()
    {
        $ddebug = false;
        //if($ddebug){ echo '<pre>'; print_r($_POST); echo '</pre>'; }

        $manageUserModel = new ManageUserModel();

        if($this->request->getPost('btnSubmit'))
        {
            $passw = $this->hashLib->passw_hash($this->request->getPost('fv_password'));
            $data_arr = [
                "fname" => $this->request->getPost('fv_fname'),
                "lname" => $this->request->getPost('fv_lname'),
                "username" => $this->request->getPost('fv_username'),
                "password" => $passw,
                "email" => $this->request->getPost('fv_email'),
                "phone" => $this->request->getPost('fv_phone'),
                "image" => "", //$this->request->getPost('fv_phonesys_id'),
                "phonesys_id" => $this->request->getPost('fv_phonesys_id'),
                "is_active" => 1 //$this->request->getPost('fv_is_active'),
            ];

            $lastId = $manageUserModel->user_add($data_arr);
            if($ddebug){ echo 'lastId: '.$lastId.'<br />'; } 

            return redirect()->to(base_url('admin/manageuser/user_list'));
        }
        else
        {
            $user_role_arr = $manageUserModel->get_all_user_role();
            
            $data['pg_title'] = 'Add New User';
            $data['url'] = base_url();
            $data['user_role_arr'] = $user_role_arr;
            return view('admin/manageuser/user_add', $data);
        }
    }
    
    public function userEdit($id)
    {
        $ddebug = false;
        
        //$uri = service('uri');
        $uri = current_url(true);
        $id = $uri->getSegment(4);

        $manageUserModel = new ManageUserModel();

        if($ddebug){ echo '<pre>'; print_r($_POST); echo '</pre>'; }

        if($this->request->getPost('btnSubmit'))
        {
            $data_arr = [
                //"user_role_pid" => $this->request->getPost('fv_user_role_id'),
                "fname" => $this->request->getPost('fv_fname'),
                "lname" => $this->request->getPost('fv_lname'),
                "username" => $this->request->getPost('fv_username'),
                //"password" => $this->request->getPost('fv_password'),
                "email" => $this->request->getPost('fv_email'),
                "phone" => $this->request->getPost('fv_phone'),
                "image" => "", //$this->request->getPost('fv_phonesys_id'),
                "phonesys_id" => $this->request->getPost('fv_phonesys_id'),
                "is_active" => $this->request->getPost('fv_is_active')
            ];

            echo '<pre>'; print_r($data_arr); echo '</pre>';

            $manageUserModel->user_edit($id, $data_arr);
            return redirect()->to(base_url('admin/manageuser/user_list'));
        }
        else
        {
            $user_rec = $manageUserModel->get_user_by_id($id);
            if($ddebug){ echo '<pre>'; print_r($user_rec); echo '</pre>'; }
            $user_role_arr = $manageUserModel->get_all_user_role();
            
            $data['pg_title'] = 'Edit User';
            $data['url'] = base_url();
            $data['id'] = $id;
            $data['user_role_arr'] = $user_role_arr;
            $data['user_rec'] = $user_rec;
            return view('admin/manageuser/user_edit', $data);
        }
    }

    public function userDelete($id = 0)
    {
        //$this->rbac->check_operation_access();
        //$id = $this->uri->segment(4);
        //$this->campaign_model->campaign_delete($id);
        //$this->session->set_flashdata('msg', 'The Record has been deleted successfully!');
        //redirect(base_url('admin/campaign'));

        //echo 'user_id: '.$id.'<br />';
        $manageUserModel = new ManageUserModel();
        $affectedRows = $manageUserModel->user_delete($id);
        //echo ' ==================================================================================>AffectedRows: '.$affectedRows.'<br />';

        return redirect()->to(base_url('admin/manageuser/user_list'));
    }
}