<?php
namespace App\Models\Admin;

use CodeIgniter\Model;

class ManageUserModel extends Model
{
    public function get_users(){
        $builder = $this->db->table('tbl_user');
        //$builder->where($data);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function get_user_by_id($id){
        $builder = $this->db->table('tbl_user');
        $query = $builder->getWhere(['user_id' => $id]);
        $rs = $query->getRowArray();

        return $rs;
    }

    public function get_all_user_role(){
        $builder = $this->db->table('tbl_user_role');
        $query = $builder->getWhere(['is_active' => 1]);
        $rs = $query->getResultArray();

        return $rs;
    }

    public function user_add($data){
        //$this->db->table('tbl_user')->insert($data);
        $builder = $this->db->table('tbl_user');
        $builder->insert($data);

        $lastId = $this->db->insertID();

        return $lastId;
    }

    public function user_edit($id, $data){
        $builder = $this->db->table('tbl_user');
        //$builder->update($data, 'user_id = '.$id);  //Option 1
        //$builder->update($data, ['user_id' =>$id]); //Option 2
        
        //Option 3
        $builder->where('user_id', $id);
        $builder->update($data);
    }

    public function user_delete($id){
        $softDelete = true; //when true it just changes the status from 1 to 0
        
        $builder = $this->db->table('tbl_user');
        if($softDelete){
            $builder->where('user_id', $id);
            $builder->update(['is_active' => 0]);
        }
        else{
            //$builder->delete(['user_id' => $id]);
            $builder->where('user_id', $id);
            $builder->delete();
        }
        $affectedRows = $this->db->affectedRows();

        return $affectedRows;
    }
}
?>