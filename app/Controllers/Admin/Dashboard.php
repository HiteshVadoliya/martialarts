<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\DashboardModel as ModelsDashboard;
use App\Models\Admin\Question;
use App\Models\Admin\Transcription;
use CodeIgniter\Config\Services;
//use App\Libraries\AccessCtrl;

class Dashboard extends BaseController
{
    public function __construct() {
        // this does not work BC the BaseController::initController is called after the constructor
        //echo 'Session Info :: user_role_id: "'.$this->session->get('user_role_id').'"<br />';
        
        //moved to Filters to better control the Access
        //$session = Services::session();
        // if ($this->session->get('is_admin_login') == NULL) {
        //     header('Location: '.base_url('auth/login'));
        //     exit();
        // }
        
        //$uri = service('uri');
        //echo 'uriSegment(1): '.$uri->getSegment(1).'<br />';


        // $this->accessCtrl = new AccessCtrl();
        // $this->accessCtrl->checkModuleAccess();
        // echo 'hola desde aqui <br />';
        // return redirect()->to(base_url('admin/permission_denied'));
    }
    
    public function index()
    {
        //this does not need to have userPermission Check
        if(!$this->checkUserPermission()){ return redirect()->to(base_url('admin/permission_denied')); exit; }
        // echo '<pre>';
        // print_r($_SESSION);
        // die;
        $data['pg_title'] = 'Dashboard';
        return view('admin/dashboard/index', $data);
        
    }

    public function dashboard2()
    {
        if(!$this->checkUserPermission()){ return redirect()->to(base_url('admin/permission_denied')); exit; }

        // $uri = service('uri');
        // $uri = current_url(true); //echo '<pre>'; print_r($uri); echo '</pre>';
        // echo 'uriTotalSegment => '.$uri->getTotalSegments().'<br />';
        // echo 'uriString => '.(string) $uri.'<br />';
        // echo 'uriScheme => '.$uri->getScheme().'<br />';
        // echo 'uriGetSegments => '.$uri->getSegment(2).'<br />';

        $data['pg_title'] = 'Augmented QA Dashboard';
        return view('admin/dashboard/dashboard2', $data);
    }

    public function dashboard3()
    {
        if(!$this->checkUserPermission()){ return redirect()->to(base_url('admin/permission_denied')); exit; }

        //$uri = service('uri');
        // $uri = current_url(true); //echo '<pre>'; print_r($uri); echo '</pre>';
        // echo 'uriTotalSegment => '.$uri->getTotalSegments().'<br />';
        // echo 'uriString => '.(string) $uri.'<br />';
        // echo 'uriScheme => '.$uri->getScheme().'<br />';
        // echo 'uriGetSegments => '.$uri->getSegment(2).'<br />';

        $data['pg_title'] = 'Augmented QA Dashboard';
        //return view('admin/dashboard/dashboard3', $data);
        echo 'this is dashboard3<br />';
    }

    public function dashboard4()
    {
        if(!$this->checkUserPermission()){ return redirect()->to(base_url('admin/permission_denied')); exit; }

        //$data['pg_title'] = 'Augmented QA Dashboard4';
        //return view('admin/dashboard/dashboard3', $data);

        echo 'dashboard4';
    }
}
