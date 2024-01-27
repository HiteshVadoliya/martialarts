<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        //echo 'FCPath: '.FCPATH.'<br />';
        //return view('welcome_message');
        return redirect()->to(base_url('admin'));
    }
}
