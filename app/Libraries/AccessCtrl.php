<?php
namespace App\Libraries;
use CodeIgniter\Database\Query;

class AccessCtrl {

    protected $db;
    protected $builder;
    protected $session;
    private $module_access;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
        $this->module_access = $this->session->get('module_access');
    }

    function set_user_access()
    {
        $roles = $this->session->roles;
        $data = [];
        //$qry = 'select * from tbl_module_access where role_pid = '.$this->session->user_role_id;
        $qry = 'select * from tbl_module_access where role_pid = '.$roles[0];
        $rs = $this->db->query($qry)->getResult();
        //echo 'lastQuery: '.$this->db->getLastQuery().'<br />';

        foreach($rs as $row)
        {
            $data[$row->module][$row->operation] = '';
        }

        $this->session->set('module_access', $data);
    }

    function checkModulePermission($module)
    {
		if(isset($this->module_access[$module])) 
			return 1;
		else 
		 	return 0;
	}

    function checkOperationPermission($module, $operation)
    {
		if(isset($this->module_access[$module][$operation])) 
			return 1;
		else 
		 	return 0;
	}

    function checkUserPermission()
    {
        $operation = $module = '';

        $uri = service('uri');
        $totalSegments = $uri->getTotalSegments();
        $module = $uri->getSegment(2);
        
        if($totalSegments > 2)
        {
            $operation = $uri->getSegment(3);
            return $this->checkOperationPermission($module, $operation);
        }
        else
        {
            return $this->checkModulePermission($module);
        }
    }

    public function check_session(){
        echo ' === [ $_SESS ] ===> <pre>'; print_r($_SESSION); echo '</pre>';
    }

    public function check_access(){
        echo ' === [ ModuleAccess ] ===> <pre>'; print_r($this->module_access); echo '</pre>';
    }
}
?>