<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Libraries\AccessCtrl;

class Auth extends BaseController
{
    public function __construct(){
        
        $this->accessCtrl = new AccessCtrl();

    }

    public function index(){
        //$_SESSION['fab'] = "1234567890";
        // $newdata = [
        //     'username'  => 'johndoe',
        //     'email'     => 'johndoe@some-site.com',
        //     'logged_in' => true,
        // ];

        //$session->set($newdata);

        //echo 'logguer: '.$session->logger.'<br />';
        //echo ' === [ session ] ===> <pre>'; print_r($this->session); echo '</pre>';

        if ($this->session->get('is_admin_login')) {
            return redirect()->to(base_url('admin/dashboard'));
        } else {
            return redirect()->to(base_url('auth/login'));
        }


        return "";
    }

    public function login()
    {
        $ddebug = true; //fabMod
        $authModel = new AuthModel();
        $msg_err = '';
            if ($this->request->getPost('submit')) {
            $username = $this->request->getPost('fv_username');
            $password = $this->request->getPost('fv_password');
            if (!empty($username) && !empty($password)) {
                $result = $authModel->login($username);
                //if($ddebug){ echo '<pre>'; print_r($result); echo '</pre>'; }

                if (count($result) > 0) {
                    if (password_verify($password, $result[0]['password'])) {

                        $role_arr = $authModel->get_role_by_userid($result[0]['user_id']);
                        //if($ddebug){ echo ' === [ role_arr ] ===> <pre>'; print_r($role_arr); echo '</pre>'; }

                        foreach($role_arr as $rol){
                            $roles = $rol['role_pid'];
                            // $roles[] = $rol['role_pid'];
                        }
                        // if($ddebug){ echo ' === [ roles ] ===> <pre>'; print_r($roles); echo '</pre>'; } 

                        $admin_data = array(
                            //'result' => $result,
                            'is_admin_login' => true,
                            'user_id' => $result[0]['user_id'],
                            'roles' => $roles,
                            'role' => $roles,
                            'first_name' => $result[0]['fname'],
                            'last_name' => $result[0]['lname'],
                            'username' => $result[0]['username'],
                            'image' => $result[0]['image'],
                        );
                        // if($ddebug){ echo ' === [ admin_data ] ===> <pre>'; print_r($admin_data); echo '</pre>'; } die;
                        
                        $this->session->set($admin_data);
                        $this->accessCtrl->set_user_access();

                        return redirect()->to(base_url('admin/dashboard')); //fabMod

                    } else {
                        $msg_err = "Invalid Password";
                    }
                } else {
                    $msg_err = "Invalid Username or Password!";
                }
            } else {
                $msg_err = 'Username and Password are required';
            }
        }

        $data['pg_title'] = 'Augmented QA Login';
        $data['msg_err'] = $msg_err;
        
        return view('auth/login', $data); //fabMod
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('auth/login'));
    }

    public function permissionDenied(){

    }

    public function checkSession1(){
        echo 'Session Info :: is_admin_login: "'.$this->session->get('is_admin_login').'"<br />';
        echo 'Session Info :: user_id: "'.$this->session->user_id.'"<br />';
        echo 'Session Info :: user_role_id: "'.$this->session->get('user_role_id').'"<br />';
        echo 'Session Info :: first_name: "'.$this->session->get('first_name').'"<br />';
        echo 'Session Info :: last_name: "'.$this->session->get('last_name').'"<br />';
        echo 'Session Info :: username: "'.$this->session->get('username').'"<br />';
        echo 'Session Info :: image: "'.$this->session->get('image').'"<br /><br /><br />';
        
        echo ' === [ module_access ] ===> <pre>'; print_r($this->session->get('module_access')); echo '</pre>';
        // echo ' === [ $_SESS ] ===> <pre>'; print_r($_SESSION); echo '</pre>';
        // echo ' === [ session ] ===> <pre>'; print_r($this->session); echo '</pre>';        
    }
}
