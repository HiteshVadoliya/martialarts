<?php
namespace App\Libraries;

class HashLib {

    protected $db;

    public function __construct(){
        $this->db = \Config\Database::connect();
    }

    public function passw_hash($val){
        return password_hash($val, PASSWORD_BCRYPT);
    }
}
?>