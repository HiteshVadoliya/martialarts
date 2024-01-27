<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class UserRolesModel extends Model
{
	protected $table  = 'tbl_user_role';

	protected $primaryKey = 'user_role_id';

	protected $allowedFields    = [
        'user_role_id',
        'user_pid',
        'role_pid',
        'cdate',
        'created_at',
        'updated_at',
    ];

}