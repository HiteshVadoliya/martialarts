<?php

namespace App\Controllers;
use App\Libraries\HashLib;
use App\Libraries\AccessCtrl;

class Test extends BaseController{
    protected $hashLib;
    protected $accessCtrl;

    public function __construct(){
        $this->hashLib = new Hashlib();
        $this->accessCtrl = new AccessCtrl();
    }

    public function index(){
        //echo 'FCPath: '.FCPATH.'<br />';
        //echo '<h2>Controller Test</h2>';
        //echo '</pre>';print_r($this->session);echo '</pre>';
        //return '<h2>Controller Test</h2>';
        //return view('welcome_message');
        
        //echo 'FCPath: '.FCPATH.'<br />';
        //echo base_url();
        $data['pgTitle'] = 'Product Catalog';
        $data['pgFooter'] = date('Y-m-d');
        return view('main_content', $data);
    }

    public function password_hash($id){
        echo 'id: '.$id.'<br />';
        //$passw_res = HashLib :: passw_hash($id);
        $passw_res = $this->hashLib->passw_hash($id);

        echo 'passw: '.$passw_res.'<br />';
    }

    public function check_session(){
        $this->accessCtrl->check_session();
    }

    public function check_access(){
        $this->accessCtrl->check_access();
    }
}