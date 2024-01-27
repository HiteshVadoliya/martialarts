<?php
namespace App\Models;
use CodeIgniter\Model;

Class AuthModel extends Model
{
    public function login($username)
    {
        $builder = $this->db->table('tbl_user');
        $builder->where(["username" => $username]);
        $builder->orwhere(["email" => $username]);
        $query = $builder->get();
        
        return $query->getResultArray();
    }

    public function get_role_by_userid($id)
    {
        $builder = $this->db->table('tbl_user_role');
        $builder->where(['user_pid'=>$id]);
        $query = $builder->get();

        return $query->getResultArray();
    }
}
?>