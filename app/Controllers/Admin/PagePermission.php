<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Config\Services;
use App\Libraries\AccessCtrl;

class PagePermission extends BaseController
{
    public function index()
    {
        //return view('admin/dashboard/index', $data);
        return redirect()->to(base_url('admin/pagepermission/denied'));
    }

    public function denied()
    {
        $data['pg_title'] = 'Permission Denied';
        return view('admin/pagePermission/denied', $data);
    }
}