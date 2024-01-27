<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class RoleModel extends Model
{
	protected $table  = 'tbl_role';

	protected $primaryKey = 'role_id';

	protected $allowedFields    = [
        'role_id',
        'role',
    ];

}